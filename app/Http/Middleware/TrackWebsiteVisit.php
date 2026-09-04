<?php

namespace App\Http\Middleware;

use App\Services\GraphQLClient;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class TrackWebsiteVisit
{
    private const BOT_PATTERN = '/bot|crawler|spider|slurp|preview|facebookexternalhit|whatsapp/i';

    public function handle(Request $request, Closure $next): Response
    {
        $request->attributes->set('landing_visit_started_at', microtime(true));

        return $next($request);
    }

    public function terminate(Request $request, Response $response): void
    {
        if (!$this->shouldTrack($request, $response)) {
            return;
        }

        $mutation = <<<'GRAPHQL'
            mutation RecordLandingPageVisit($input: WebTrafficInput!) {
              CreateWebTraffic(input: $input) {
                success
              }
            }
        GRAPHQL;

        $userAgent = (string) $request->userAgent();
        $startedAt = (float) $request->attributes->get('landing_visit_started_at', microtime(true));
        $content = method_exists($response, 'getContent') ? (string) $response->getContent() : '';

        $input = [
            'ip_address' => (string) ($request->ip() ?: 'unknown'),
            'user_agent' => $userAgent ?: 'unknown',
            'url' => $request->path() === '/' ? '/' : '/' . ltrim($request->path(), '/'),
            'method' => 'GET',
            'referrer' => $request->headers->get('referer'),
            'query_params' => $request->query(),
            'headers' => [
                'accept-language' => $request->headers->get('accept-language'),
                'host' => $request->getHost(),
            ],
            'status_code' => $response->getStatusCode(),
            'response_time' => max(0, (int) round((microtime(true) - $startedAt) * 1000)),
            'response_size' => strlen($content),
            'traffic_type' => $this->trafficType((string) $request->headers->get('referer'), $request),
            'is_bot' => false,
            'is_mobile' => (bool) preg_match('/mobile|android|iphone|ipad|tablet/i', $userAgent),
            'session_id' => $request->hasSession() ? $request->session()->getId() : null,
            'page_views' => 1,
            'access_time' => now()->toIso8601String(),
        ];

        try {
            (new GraphQLClient())->query(
                $mutation,
                ['input' => $input],
                config('landing.graphql.token')
            );
        } catch (\Throwable $error) {
            Log::warning('Landing page visit gagal dicatat', [
                'path' => $input['url'],
                'message' => $error->getMessage(),
            ]);
        }
    }

    private function shouldTrack(Request $request, Response $response): bool
    {
        if (!config('landing.traffic_tracking_enabled', true)) {
            return false;
        }
        if (!$request->isMethod('GET') || $response->getStatusCode() >= 400) {
            return false;
        }

        $contentType = (string) $response->headers->get('Content-Type');
        if (!str_contains(strtolower($contentType), 'text/html')) {
            return false;
        }

        return !preg_match(self::BOT_PATTERN, (string) $request->userAgent());
    }

    private function trafficType(string $referrer, Request $request): string
    {
        if ($referrer === '') {
            return 'direct';
        }

        $source = strtolower($referrer . ' ' . $request->getQueryString());
        if (preg_match('/google|bing|yahoo|duckduckgo|baidu/', $source)) {
            return 'organic';
        }
        if (preg_match('/utm_medium=(cpc|paid)|gclid=|fbclid=/', $source)) {
            return 'paid';
        }
        if (preg_match('/facebook|instagram|twitter|x\.com|linkedin|youtube|tiktok/', $source)) {
            return 'social';
        }
        if (preg_match('/mail|email|utm_medium=email/', $source)) {
            return 'email';
        }

        return 'referral';
    }
}
