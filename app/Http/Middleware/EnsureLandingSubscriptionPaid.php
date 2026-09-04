<?php

namespace App\Http\Middleware;

use App\Services\GraphQLClient;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class EnsureLandingSubscriptionPaid
{
    public function __construct(private readonly GraphQLClient $client)
    {
    }

    public function handle(Request $request, Closure $next): Response
    {
        if ($request->is('up')) {
            return $next($request);
        }

        $isExpiredPage = $request->is('subscription-expired');

        $query = <<<'GRAPHQL'
            query GetLandingSubscriptionAccess {
              GetLandingSubscriptionAccess {
                access_allowed
                subscription_status
                payment_status
                reason
              }
            }
        GRAPHQL;

        try {
            $data = $this->client->queryCached(
                'subscription-access',
                $query,
                [],
                config('landing.graphql.token'),
                config('landing.cache.subscription_ttl', 5)
            );
            $access = $data['GetLandingSubscriptionAccess'] ?? null;

            if (is_array($access)) {
                $accessAllowed = ($access['access_allowed'] ?? false) === true;

                if ($accessAllowed && $isExpiredPage) {
                    return redirect('/');
                }

                if (!$accessAllowed && !$isExpiredPage) {
                    return redirect()->route('landing.subscription.expired');
                }
            }
        } catch (\Throwable $error) {
            // Do not take the public website down when the subscription API is unavailable.
            Log::warning('Landing subscription check failed', [
                'message' => $error->getMessage(),
            ]);
        }

        return $next($request);
    }
}
