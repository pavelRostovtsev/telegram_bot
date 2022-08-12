<?php

declare(strict_types=1);

namespace App\Services\telegram\Commands;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;

class BaseTelegramCommand
{
    protected Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @throws GuzzleException
     */
    public function sendMessage(string $text, int $chatId): ResponseInterface
    {
        return $this->client->post('sendMessage', [
            'form_params' => [
                'chat_id' => $chatId,
                'text' => $text,
            ]
        ]);
    }
}