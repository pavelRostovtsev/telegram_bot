<?php

declare(strict_types=1);

namespace App\Models\telegram\Commands;

use App\Repository\ArticleRepository;
use App\Models\telegram\DTO\TelegramDTO;
use App\Models\telegram\Services\TelegramApi;
use GuzzleHttp\Exception\GuzzleException;

class GetUrlTelegramCommand implements TelegramCommandInterface
{

    private ArticleRepository $urlRepository;
    private TelegramApi $telegramApi;

    public function __construct(ArticleRepository $urlRepository, TelegramApi $telegramApi)
    {
        $this->urlRepository = $urlRepository;
        $this->telegramApi = $telegramApi;
    }

    public function getName(): string
    {
        return '/get';
    }

    /**
     * @throws GuzzleException
     */
    public function start(TelegramDTO $data): void
    {
        $article = $this->urlRepository->getRandomUrl($data->getUserId());
        $responseText = $article ?: 'the vault is empty';
        $this->telegramApi->sendMessage(chatId:$data->getUserId(), text: $responseText);
    }
}
