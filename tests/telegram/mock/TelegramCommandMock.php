<?php

namespace App\Tests\telegram\mock;

use App\Services\telegram\Commands\TelegramCommandInterface;

class TelegramCommandMock implements TelegramCommandInterface
{
    public function getName(): string
    {
        return 'TelegramCommandMock';
    }
}