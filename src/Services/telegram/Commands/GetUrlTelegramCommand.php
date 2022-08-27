<?php

declare(strict_types=1);

namespace App\Services\telegram\Commands;

use App\Repository\ArticleRepository;
use App\Services\telegram\DTO\TelegramDTO;

class GetUrlTelegramCommand implements TelegramCommandInterface
{

    private ArticleRepository $urlRepository;

    public function __construct(ArticleRepository $urlRepository)
    {
        $this->urlRepository = $urlRepository;
    }

    public function getName(): string
    {
        return '/get';
    }

    public function start(TelegramDTO $data): void
    {
        $this->urlRepository->getRandomUrl($data->getUserId());

    }
}
