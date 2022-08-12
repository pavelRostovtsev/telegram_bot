<?php

namespace App\Services\telegram\Commands;

use App\Services\telegram\DTO\TelegramDTO;

interface TelegramCommandInterface
{
    public function getName(): string;

    public function start(TelegramDTO $data): void;
}