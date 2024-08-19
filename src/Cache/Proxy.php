<?php

namespace App\Cache;

use Symfony\Component\Cache\Adapter\RedisAdapter;

class Proxy
{
    private mixed $cache;
    private int $ttl = 5;

    public function __construct()
    {
        $this->cache = RedisAdapter::createConnection('redis://redis:6379');
    }

    public function checkCache(array $response): array
    {
        $cacheKey = md5(serialize($response));

        $data = $this->cache->get($cacheKey);

        if (!$data) {
            $data = $response;
            $this->cache->set($cacheKey, $data, $this->ttl);
        }

        return $data;
    }
}
