<?php

declare(strict_types=1);

namespace App\Models\telegram\Services;

use App\Models\telegram\Storage\StorageInterface;
use Redis;
use RedisException;

class ProcessService
{
    private StorageInterface $storage;

    public function __construct(StorageInterface $storage)
    {
        $this->storage = $storage;
    }

    /**
     * @throws RedisException
     */
    public function checkProcess(string $keyProcess): bool
    {
        return $this->storage->exist($keyProcess);
    }

    private function setProcess()
    {

    }

    private function removeProcess()
    {

    }

}