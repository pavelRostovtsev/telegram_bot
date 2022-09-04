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

    public function getFullData()
    {
        return $this->telegramDataRequest;
    }

    public function getUserFirstName()
    {
        return  $this->telegramDataRequest['message']['chat']['first_name'];
    }

    public function getUserLastName()
    {
        return  $this->telegramDataRequest['message']['chat']['last_name'];
    }

    public function getUserName()
    {
        return  $this->telegramDataRequest['message']['chat']['username'];
    }

    public function getUserId(): int
    {
        return $this->telegramDataRequest['message']['from']['id'];
    }

    public function getFullTextCommand()
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
        return explode(' ', $this->getFullTextCommand());
    }
}
