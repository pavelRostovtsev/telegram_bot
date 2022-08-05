<?php

declare(strict_types=1);

namespace App\Services\telegram\Commands;

use App\Services\telegram\DTO\TelegramDTO;

class SetUrlTelegramCommand extends BaseTelegramCommand implements TelegramCommandInterface
{
    public function getName(): string
    {
        return '/get';
    }

    public function start(TelegramDTO $data)
    {

    }
}