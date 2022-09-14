<?php

namespace App\Models\telegram\Commands;

use App\Models\telegram\DTO\TelegramDTO;

interface TelegramCommandInterface
{
    public function getName(): string;

    public function start(TelegramDTO $data): void;
}