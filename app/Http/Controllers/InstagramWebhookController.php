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

        if ($mode === 'subscribe' && $token !== '' && hash_equals($configuredToken, $token)) {
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

        foreach ($entries as $entry) {
            if (! is_array($entry)) {
                continue;
            }

            $messagingEvents = is_array($entry['messaging'] ?? null) ? $entry['messaging'] : [];

            foreach ($messagingEvents as $event) {
                if (! is_array($event)) {
                    continue;
                }

                $igsid = (string) data_get($event, 'sender.id', '');
                $text = trim((string) data_get($event, 'message.text', ''));

                if ($igsid === '' || $text === '') {
                    continue;
                }

                $token = $this->extractUnlockToken($text, $keyword);

                if ($token === null) {
                    continue;
                }

                $unlockRequest = InstagramUnlockRequest::where('unlock_token', $token)->first();

                if (! $unlockRequest) {
                    Log::info('Instagram unlock token not found', ['token' => $token]);
                    continue;
                }

                $verification = $verifier->verifyByIgsid($igsid);

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
            }
        }

        return response()->json(['ok' => true]);
    }

    private function extractUnlockToken(string $text, string $keyword): ?string
    {
        $normalized = trim($text);
        if ($normalized === '') {
            return null;
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
