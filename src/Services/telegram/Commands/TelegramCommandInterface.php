<?php

namespace App\Services\telegram\Commands;

interface TelegramCommandInterface
{
    public function getName(): string;
}