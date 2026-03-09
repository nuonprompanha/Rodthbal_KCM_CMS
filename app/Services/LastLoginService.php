<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class LastLoginService
{
    /**
     * Get a short browser name from the request User-Agent.
     */
    public static function getBrowserFromRequest(Request $request): ?string
    {
        $ua = $request->userAgent();
        if (empty($ua)) {
            return null;
        }
        if (stripos($ua, 'Edg/') !== false) {
            return 'Edge';
        }
        if (stripos($ua, 'Chrome') !== false) {
            return 'Chrome';
        }
        if (stripos($ua, 'Firefox') !== false) {
            return 'Firefox';
        }
        if (stripos($ua, 'Safari') !== false && stripos($ua, 'Chrome') === false) {
            return 'Safari';
        }
        if (stripos($ua, 'Opera') !== false || stripos($ua, 'OPR') !== false) {
            return 'Opera';
        }
        if (stripos($ua, 'MSIE') !== false || stripos($ua, 'Trident') !== false) {
            return 'Internet Explorer';
        }

        return 'Other';
    }

    /**
     * Get country name from IP using a free API.
     * Returns null on failure. Returns 'Local' for private/local IPs.
     */
    public static function getLocationFromIp(string $ip): ?string
    {
        if (empty($ip)) {
            return null;
        }
        if (self::isPrivateOrLocalIp($ip)) {
            return 'Local';
        }

        try {
            $response = Http::timeout(2)->get("http://ip-api.com/json/{$ip}", [
                'fields' => 'status,country',
            ]);

            if (! $response->successful()) {
                return null;
            }

            $data = $response->json();
            if (($data['status'] ?? '') !== 'success') {
                return null;
            }

            return $data['country'] ?? null;
        } catch (\Throwable $e) {
            return null;
        }
    }

    /**
     * Check if IP is private or local (no point querying geo API).
     */
    protected static function isPrivateOrLocalIp(string $ip): bool
    {
        return $ip === '127.0.0.1'
            || $ip === '::1'
            || str_starts_with($ip, '10.')
            || str_starts_with($ip, '192.168.')
            || preg_match('/^172\.(1[6-9]|2[0-9]|3[0-1])\./', $ip);
    }

    /**
     * Build last login data from the current request.
     */
    public static function getLastLoginData(Request $request): array
    {
        $ip = $request->ip();

        return [
            'last_login_at' => now(),
            'last_login_ip' => $ip,
            'last_login_browser' => self::getBrowserFromRequest($request),
            'last_login_location' => self::getLocationFromIp($ip ?? ''),
        ];
    }
}
