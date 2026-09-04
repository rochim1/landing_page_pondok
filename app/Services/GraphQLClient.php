<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Client\ConnectionException;

class GraphQLClient
{
    protected string $endpoint;

    public function __construct()
    {
        $this->endpoint = str_replace(
            '://localhost:',
            '://127.0.0.1:',
            config('landing.graphql.endpoint', 'http://localhost:8080/graphql')
        );
    }

    public function query(string $query, array $variables = [], ?string $token = null): ?array
    {
        $token ??= config('landing.graphql.token');
        $instansiId = config('landing.instansi_id');
        $headers = [
            'Content-Type' => 'application/json',
            'apps' => config('landing.graphql.apps_header', 'landing'),
            'lang' => config('landing.graphql.lang', 'id'),
            'x-client-origin' => request()->getSchemeAndHttpHost(),
        ];

        if ($instansiId) {
            $headers['instansi_id'] = $instansiId;
            $headers['x-iid'] = $instansiId;
        }

        $http = Http::connectTimeout(config('landing.graphql.connect_timeout', 3))
            ->timeout(config('landing.graphql.timeout', 10))
            ->withHeaders($headers);
        if ($token) {
            $http = $http->withHeaders(['Authorization' => 'Bearer ' . $token]);
        }

        $payload = [
            'query' => $query,
            // Apollo expects an object for `variables`; PHP encodes an empty
            // array as [] unless it is explicitly converted to an object.
            'variables' => empty($variables) ? (object) [] : $variables,
        ];

        try {
            $response = $http->post($this->endpoint, $payload);
        } catch (ConnectionException $e) {
            $fallbackEndpoint = str_replace('://localhost:', '://127.0.0.1:', $this->endpoint);
            if ($fallbackEndpoint === $this->endpoint) {
                throw $e;
            }

            $response = $http->post($fallbackEndpoint, $payload);
        }

        if ($response->successful()) {
            $body = $response->json();
            if (isset($body['errors'])) {
                if (isset($body['data']) && is_array($body['data'])) {
                    Log::warning('GraphQL returned partial data', $body['errors']);
                    return $body['data'];
                }

                Log::error('GraphQL errors', $body['errors']);
                throw new \Exception($body['errors'][0]['message'] ?? 'GraphQL error');
            }
            return $body['data'] ?? null;
        }

        Log::error('GraphQL request failed', ['status' => $response->status(), 'body' => $response->body()]);
        throw new \Exception('GraphQL request failed with status ' . $response->status());
    }

    public function queryCached(
        string $namespace,
        string $query,
        array $variables = [],
        ?string $token = null,
        ?int $ttl = null
    ): ?array {
        $ttl ??= (int) config('landing.cache.content_ttl', 60);

        if (!config('landing.cache.enabled', true) || $ttl <= 0) {
            return $this->query($query, $variables, $token);
        }

        $cacheKey = implode(':', [
            config('landing.cache.prefix', 'landing:v1'),
            config('landing.instansi_id', 'unknown'),
            $namespace,
            sha1($query . '|' . json_encode($variables, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE)),
        ]);

        return Cache::remember(
            $cacheKey,
            $ttl,
            fn (): ?array => $this->query($query, $variables, $token)
        );
    }
}
