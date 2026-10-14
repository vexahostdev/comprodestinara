<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Throwable;

class CoreSystemClient
{
    protected string $baseUrl;

    protected string $apiUrl;

    protected int $timeout = 5;

    protected int $cacheTtl = 600; // 10 minutes (SPEC §16.2)

    public function __construct()
    {
        $this->baseUrl = rtrim((string) config('services.core_system.url', 'https://layanan.destinara.my.id'), '/');
        $this->apiUrl = rtrim((string) config('services.core_system.api_url', 'https://layanan.destinara.my.id/api/v1/public'), '/');
    }

    public function getBaseUrl(): string
    {
        return $this->baseUrl;
    }

    public function getApiUrl(): string
    {
        return $this->apiUrl;
    }

    /**
     * Ambil daftar destinasi dengan filter, pagination, dan fallback stale cache
     */
    public function getDestinations(array $params = []): array
    {
        $cacheKey = 'compro_destinations_'.md5(http_build_query($params));
        $staleKey = $cacheKey.'_stale';

        try {
            $response = Cache::remember($cacheKey, $this->cacheTtl, function () use ($params, $staleKey) {
                $res = Http::timeout($this->timeout)
                    ->acceptJson()
                    ->get("{$this->apiUrl}/destinations", $params);

                if ($res->successful()) {
                    $json = $res->json();
                    Cache::forever($staleKey, $json);

                    return $json;
                }

                throw new \RuntimeException("Core API response error [{$res->status()}]: ".$res->body());
            });

            return $response ?? ['data' => [], 'meta' => []];
        } catch (Throwable $e) {
            Log::error('Gagal menghubungi Destinara Core API [destinations]: '.$e->getMessage());

            return Cache::get($staleKey, ['data' => [], 'meta' => []]);
        }
    }

    /**
     * Ambil detail destinasi berdasarkan slug dengan fallback stale cache
     */
    public function getDestination(string $slug): ?array
    {
        $cacheKey = 'compro_destination_'.$slug;
        $staleKey = $cacheKey.'_stale';

        try {
            $response = Cache::remember($cacheKey, $this->cacheTtl, function () use ($slug, $staleKey) {
                $res = Http::timeout($this->timeout)
                    ->acceptJson()
                    ->get("{$this->apiUrl}/destinations/{$slug}");

                if ($res->successful()) {
                    $json = $res->json();
                    Cache::forever($staleKey, $json);

                    return $json;
                }

                if ($res->status() === 404) {
                    return null;
                }

                throw new \RuntimeException("Core API response error [{$res->status()}]: ".$res->body());
            });

            return $response['data'] ?? $response ?? null;
        } catch (Throwable $e) {
            Log::error("Gagal menghubungi Destinara Core API [destination/{$slug}]: ".$e->getMessage());
            $stale = Cache::get($staleKey);

            return $stale['data'] ?? $stale ?? null;
        }
    }

    /**
     * Ambil daftar kategori aktif
     */
    public function getCategories(): array
    {
        $cacheKey = 'compro_categories';
        $staleKey = $cacheKey.'_stale';

        try {
            $response = Cache::remember($cacheKey, $this->cacheTtl, function () use ($staleKey) {
                $res = Http::timeout($this->timeout)
                    ->acceptJson()
                    ->get("{$this->apiUrl}/categories");

                if ($res->successful()) {
                    $json = $res->json();
                    Cache::forever($staleKey, $json);

                    return $json;
                }

                throw new \RuntimeException("Core API response error [{$res->status()}]: ".$res->body());
            });

            return $response['data'] ?? [];
        } catch (Throwable $e) {
            Log::error('Gagal menghubungi Destinara Core API [categories]: '.$e->getMessage());
            $stale = Cache::get($staleKey, []);

            return $stale['data'] ?? [];
        }
    }

    /**
     * Ambil metrik ringkasan dampak riil dari sistem core
     */
    public function getStats(): array
    {
        $cacheKey = 'compro_stats';
        $staleKey = $cacheKey.'_stale';

        try {
            $response = Cache::remember($cacheKey, $this->cacheTtl, function () use ($staleKey) {
                $res = Http::timeout($this->timeout)
                    ->acceptJson()
                    ->get("{$this->apiUrl}/stats");

                if ($res->successful()) {
                    $json = $res->json();
                    Cache::forever($staleKey, $json);

                    return $json;
                }

                throw new \RuntimeException("Core API response error [{$res->status()}]: ".$res->body());
            });

            return $response['data'] ?? [];
        } catch (Throwable $e) {
            Log::error('Gagal menghubungi Destinara Core API [stats]: '.$e->getMessage());
            $stale = Cache::get($staleKey, []);

            return $stale['data'] ?? [];
        }
    }
}
