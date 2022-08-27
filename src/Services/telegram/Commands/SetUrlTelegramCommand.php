<?php

declare(strict_types=1);

namespace App\Services\telegram\Commands;

use App\Entity\Article;
use App\Repository\TelegramUserRepository;
use App\Repository\ArticleRepository;
use App\Services\telegram\DTO\TelegramDTO;

class SetUrlTelegramCommand implements TelegramCommandInterface
{
    private TelegramUserRepository $telegramUser;
    private ArticleRepository $urlRepository;

    public function __construct(TelegramUserRepository $telegramUser, ArticleRepository $urlRepository)
    {
        $this->telegramUser = $telegramUser;
        $this->urlRepository = $urlRepository;
    }

    public function getName(): string
    {
        return '/set';
    }

    public function start(TelegramDTO $data):void
    {
        $user =  $this->telegramUser->find($data->getUserId());
        $url = new Article();
        $url->setUrl($data->getDataCommand());
        $url->setUserId($user);

        $this->urlRepository->add($url, true);

    }
}
