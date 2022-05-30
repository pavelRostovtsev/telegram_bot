<?php

declare(strict_types=1);

namespace App\Services\telegram\Commands;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;

class TestTelegramCommand implements TelegramCommandInterface
{
    private Client $client;

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
                'parse_mode'
            ]
        ]);
    }
//нужно разобраться как газл шлет файлы https://qna.habr.com/q/827583
//    public function sendDocument(string $text, resource $document)
//    {
//        return $this->client->post('sendDocument', [
//            'form_params' => [
//                'chat_id' => $chatId,
//                'document' => $document,
//
//            ]
//        ]);
//    }

    public function getName(): string
    {
        return 'TestTelegramCommand';
    }
}