<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class InstagramFollowVerifier
{
    /**
     * @return array{verified: bool, username: string|null, payload: array<string, mixed>|null, reason: string|null}
     */
    public function verifyByIgsid(string $igsid): array
    {
        $accessToken = (string) config('services.instagram.access_token');
        $graphVersion = (string) config('services.instagram.graph_version', 'v25.0');
        $graphBaseUrl = rtrim((string) config('services.instagram.graph_base_url', 'https://graph.instagram.com'), '/');

        Log::info('dm_unlock.verifier.start', [
            'igsid' => $igsid,
            'graph_base_url' => $graphBaseUrl,
            'graph_version' => $graphVersion,
            'token_present' => $accessToken !== '',
            'token_length' => strlen($accessToken),
        ]);

        if ($accessToken === '') {
            Log::warning('dm_unlock.verifier.missing_access_token', [
                'igsid' => $igsid,
            ]);

            return [
                'verified' => false,
                'username' => null,
                'payload' => null,
                'reason' => 'missing_access_token',
            ];
        }

        $primaryEndpoint = sprintf('%s/%s/%s', $graphBaseUrl, $graphVersion, $igsid);

        $response = Http::withToken($accessToken)->timeout(10)->get($primaryEndpoint, [
            'fields' => 'name,username,profile_pic,follower_count,is_user_follow_business,is_business_follow_user',
        ]);

        Log::info('dm_unlock.verifier.primary_response', [
            'igsid' => $igsid,
            'status' => $response->status(),
            'endpoint' => $primaryEndpoint,
        ]);

        if (! $response->ok() && str_contains($graphBaseUrl, 'graph.instagram.com')) {
            $fallbackEndpoint = sprintf('https://graph.facebook.com/%s/%s', $graphVersion, $igsid);
            $fallbackResponse = Http::withToken($accessToken)->timeout(10)->get($fallbackEndpoint, [
                'fields' => 'name,username,profile_pic,follower_count,is_user_follow_business,is_business_follow_user',
            ]);

            Log::info('dm_unlock.verifier.fallback_response', [
                'igsid' => $igsid,
                'status' => $fallbackResponse->status(),
                'endpoint' => $fallbackEndpoint,
            ]);

            if ($fallbackResponse->ok()) {
                $response = $fallbackResponse;
            }
        }

        if (! $response->ok()) {
            Log::warning('Instagram follow verification request failed', [
                'status' => $response->status(),
                'body' => $response->json(),
                'igsid' => $igsid,
                'graph_version' => $graphVersion,
                'graph_base_url' => $graphBaseUrl,
            ]);

            return [
                'verified' => false,
                'username' => null,
                'payload' => $response->json(),
                'reason' => 'request_failed',
            ];
        }

        /** @var array<string, mixed> $payload */
        $payload = $response->json();

        $verified = (bool) ($payload['is_user_follow_business'] ?? false);

        Log::info('dm_unlock.verifier.success', [
            'igsid' => $igsid,
            'verified' => $verified,
            'username' => isset($payload['username']) ? (string) $payload['username'] : null,
            'payload_keys' => array_keys($payload),
        ]);

        return [
            'verified' => $verified,
            'username' => isset($payload['username']) ? (string) $payload['username'] : null,
            'payload' => $payload,
            'reason' => null,
        ];
    }
}
