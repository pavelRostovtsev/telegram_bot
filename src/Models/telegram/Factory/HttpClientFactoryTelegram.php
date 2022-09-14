<?php

declare(strict_types=1);

namespace App\Models\telegram\Factory;

use GuzzleHttp\Client;

class HttpClientFactoryTelegram
{
    private string $token;
    private string $telegramUrl;

    public function __construct(string $telegramUrl, string $token)
    {
        $this->telegramUrl = $telegramUrl;
        $this->token = $token;
    }

    public function createHttpClient(): Client
    {
        return new Client([
            'base_uri' => $this->telegramUrl . $this->token . '/',
        ]);
    }
}
