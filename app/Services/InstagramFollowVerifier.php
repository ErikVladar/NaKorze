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

        if ($accessToken === '') {
            return [
                'verified' => false,
                'username' => null,
                'payload' => null,
                'reason' => 'missing_access_token',
            ];
        }

        $endpoint = sprintf('https://graph.instagram.com/%s/%s', $graphVersion, $igsid);

        $response = Http::timeout(10)->get($endpoint, [
            'fields' => 'name,username,profile_pic,follower_count,is_user_follow_business,is_business_follow_user',
            'access_token' => $accessToken,
        ]);

        if (! $response->ok()) {
            Log::warning('Instagram follow verification request failed', [
                'status' => $response->status(),
                'body' => $response->json(),
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

        return [
            'verified' => (bool) ($payload['is_user_follow_business'] ?? false),
            'username' => isset($payload['username']) ? (string) $payload['username'] : null,
            'payload' => $payload,
            'reason' => null,
        ];
    }
}
