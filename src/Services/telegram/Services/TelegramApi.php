<?php

declare(strict_types=1);

namespace App\Services\telegram\Services;

use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Client\ClientInterface;

class TelegramApi
{
    private ClientInterface $httpClient;

    public function __construct(ClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * @throws GuzzleException
     */
    public function sendMessage(int $chatId, string $text): void
    {
        $this->httpClient->post('sendMessage', [
            'form_params' => [
                'chat_id' => $chatId,
                'text' => $text,
            ]
        ]);
    }
}