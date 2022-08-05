<?php

declare(strict_types=1);

namespace App\Services\telegram\DTO;

use Symfony\Component\HttpFoundation\Request;

class TelegramDTO
{

    private array $telegramDataRequest;

    public function __construct(Request $request)
    {
        $this->telegramDataRequest = json_decode($request->getContent(), true, 512, JSON_UNESCAPED_UNICODE);
    }

    public function getUserId(): int
    {
        return $this->telegramDataRequest['message']['from']['id'];
    }

    public function getFullText()
    {
        return $this->telegramDataRequest['message']['text'];
    }

    public function getCommand(): string
    {
        return $this->getFullDataCommand()[0];
    }

    public function getDataCommand(): string
    {
        return $this->getFullDataCommand()[1];
    }

    private function getFullDataCommand(): array
    {
        return explode(' ', $this->getFullText());
    }

}