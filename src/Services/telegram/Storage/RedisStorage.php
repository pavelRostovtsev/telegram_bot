<?php

declare(strict_types=1);

namespace App\Services\telegram\Storage;

use Redis;
use RedisException;

class RedisStorage implements StorageInterface
{
    private Redis $redis;

    public function __construct(Redis $redis)
    {
        $this->redis = $redis;
    }

    /**
     * @throws RedisException
     */
    public function exist(string $key): bool
    {
        return (bool)$this->redis->exists($key);
    }
}