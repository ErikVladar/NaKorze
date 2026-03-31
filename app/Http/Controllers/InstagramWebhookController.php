<?php

namespace App\Http\Controllers;

use App\Models\InstagramUnlockRequest;
use App\Services\InstagramFollowVerifier;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class InstagramWebhookController extends Controller
{
    public function verify(Request $request): Response
    {
        $mode = (string) $request->query('hub_mode', $request->query('hub.mode'));
        $token = (string) $request->query('hub_verify_token', $request->query('hub.verify_token'));
        $challenge = (string) $request->query('hub_challenge', $request->query('hub.challenge'));

        $configuredToken = (string) config('services.instagram.webhook_verify_token');
        $matched = $mode === 'subscribe' && $token !== '' && hash_equals($configuredToken, $token);

        Log::info('dm_unlock.webhook.verify_called', [
            'mode' => $mode,
            'token_present' => $token !== '',
            'challenge_present' => $challenge !== '',
            'matched' => $matched,
        ]);

        if ($matched) {
            return response($challenge, 200)->header('Content-Type', 'text/plain');
        }

        return response('Forbidden', 403);
    }

    public function handle(Request $request, InstagramFollowVerifier $verifier): JsonResponse
    {
        /** @var array<string, mixed> $payload */
        $payload = $request->all();

        $keyword = strtoupper((string) config('services.instagram.dm_unlock_keyword', 'UNLOCK'));

        $entries = is_array($payload['entry'] ?? null) ? $payload['entry'] : [];
        $processedEvents = 0;

        Log::info('dm_unlock.webhook.handle_start', [
            'entry_count' => count($entries),
            'keyword' => $keyword,
            'payload_keys' => array_keys($payload),
        ]);

        foreach ($entries as $entry) {
            if (! is_array($entry)) {
                continue;
            }

            $messagingEvents = $this->extractMessagingEvents($entry);

            Log::info('dm_unlock.webhook.entry_extracted', [
                'events_count' => count($messagingEvents),
                'entry_keys' => array_keys($entry),
            ]);

            foreach ($messagingEvents as $event) {
                if (! is_array($event)) {
                    continue;
                }

                $igsid = (string) data_get($event, 'sender.id', data_get($event, 'message.from', ''));
                $text = trim((string) data_get($event, 'message.text', data_get($event, 'text', '')));

                if ($igsid === '' || $text === '') {
                    Log::info('dm_unlock.webhook.event_skipped_missing_fields', [
                        'has_igsid' => $igsid !== '',
                        'has_text' => $text !== '',
                    ]);

                    continue;
                }

                $processedEvents++;

                Log::info('dm_unlock.webhook.event_received', [
                    'igsid' => $igsid,
                    'text_length' => strlen($text),
                ]);

                $token = $this->extractUnlockToken($text, $keyword);

                if ($token === null) {
                    Log::info('dm_unlock.webhook.token_not_found_in_message', [
                        'igsid' => $igsid,
                        'text_preview' => substr($text, 0, 80),
                    ]);

                    continue;
                }

                Log::info('dm_unlock.webhook.token_extracted', [
                    'igsid' => $igsid,
                    'token_masked' => $this->maskToken($token),
                ]);

                $unlockRequest = InstagramUnlockRequest::where('unlock_token', $token)->first();

                if (! $unlockRequest) {
                    Log::info('Instagram unlock token not found', ['token' => $token]);
                    continue;
                }

                Log::info('dm_unlock.webhook.request_found', [
                    'request_id' => $unlockRequest->id,
                    'status_before' => $unlockRequest->status,
                    'token_masked' => $this->maskToken($token),
                ]);

                $verification = $verifier->verifyByIgsid($igsid);

                Log::info('dm_unlock.webhook.verification_result', [
                    'request_id' => $unlockRequest->id,
                    'igsid' => $igsid,
                    'verified' => (bool) ($verification['verified'] ?? false),
                    'reason' => $verification['reason'] ?? null,
                ]);

                $unlockRequest->igsid = $igsid;
                $unlockRequest->last_event_at = now();
                $unlockRequest->meta_payload = [
                    'event' => $event,
                    'verification' => $verification,
                ];
                $unlockRequest->is_following = (bool) $verification['verified'];

                if ((bool) $verification['verified']) {
                    $unlockRequest->status = 'unlocked';
                    $unlockRequest->unlocked_at = now();
                    if (is_string($verification['username']) && $verification['username'] !== '') {
                        $unlockRequest->instagram_username = $verification['username'];
                    }
                } else {
                    $unlockRequest->status = 'pending_follow';
                }

                $unlockRequest->save();

                Log::info('dm_unlock.webhook.request_saved', [
                    'request_id' => $unlockRequest->id,
                    'status_after' => $unlockRequest->status,
                    'has_unlocked_at' => $unlockRequest->unlocked_at !== null,
                    'igsid' => $igsid,
                ]);
            }
        }

        if ($processedEvents === 0) {
            Log::info('Instagram webhook received with no processable message events', [
                'has_entry' => is_array($payload['entry'] ?? null),
                'entry_count' => count($entries),
            ]);
        }

        return response()->json(['ok' => true]);
    }

    private function maskToken(string $token): string
    {
        if ($token === '') {
            return '';
        }

        if (strlen($token) <= 4) {
            return '****';
        }

        return substr($token, 0, 2) . '***' . substr($token, -2);
    }

    /**
     * @param  array<string, mixed>  $entry
     * @return array<int, array<string, mixed>>
     */
    private function extractMessagingEvents(array $entry): array
    {
        $events = [];

        $messagingEvents = is_array($entry['messaging'] ?? null) ? $entry['messaging'] : [];
        foreach ($messagingEvents as $event) {
            if (is_array($event)) {
                $events[] = $event;
            }
        }

        $changes = is_array($entry['changes'] ?? null) ? $entry['changes'] : [];
        foreach ($changes as $change) {
            if (! is_array($change)) {
                continue;
            }

            $value = is_array($change['value'] ?? null) ? $change['value'] : [];

            $valueMessaging = is_array($value['messaging'] ?? null) ? $value['messaging'] : [];
            foreach ($valueMessaging as $event) {
                if (is_array($event)) {
                    $events[] = $event;
                }
            }

            $messages = is_array($value['messages'] ?? null) ? $value['messages'] : [];
            foreach ($messages as $message) {
                if (! is_array($message)) {
                    continue;
                }

                $senderId = (string) data_get($value, 'sender.id', (string) ($message['from'] ?? ''));
                $text = trim((string) ($message['text'] ?? ''));

                if ($senderId === '' || $text === '') {
                    continue;
                }

                $events[] = [
                    'sender' => ['id' => $senderId],
                    'message' => ['text' => $text],
                ];
            }
        }

        return $events;
    }

    private function extractUnlockToken(string $text, string $keyword): ?string
    {
        $normalized = trim($text);
        if ($normalized === '') {
            return null;
        }

        $pattern = '/\\b'.preg_quote($keyword, '/').'\\b[\\s:.-]*([A-Z0-9]{4,64})/i';
        if (preg_match($pattern, $normalized, $matches) === 1 && isset($matches[1])) {
            return strtoupper($matches[1]);
        }

        $parts = preg_split('/\s+/', strtoupper($normalized));

        if (! is_array($parts) || count($parts) < 2) {
            return null;
        }

        if ($parts[0] !== strtoupper($keyword)) {
            return null;
        }

        $token = preg_replace('/[^A-Z0-9]/', '', $parts[1] ?? '');
        if (! is_string($token) || $token === '') {
            return null;
        }

        return $token;
    }
}
