<?php

declare(strict_types=1);

namespace App\Models\telegram\Commands;

use App\Entity\Article;
use App\Repository\TelegramUserRepository;
use App\Repository\ArticleRepository;
use App\Models\telegram\DTO\TelegramDTO;

class SetUrlTelegramCommand implements TelegramCommandInterface
{
    private const STATE_START = 0;
    private const STATE_IN_PROCESS = 1;
    private const STATE_END = 2;

    private const STATE = [
        self::STATE_START,
        self::STATE_IN_PROCESS,
        self::STATE_END,
    ];

    private TelegramUserRepository $telegramUser;
    private ArticleRepository $urlRepository;

    private string $link;
    private string|null $name = null;
    private array $tags = [];
    private int $currentState;

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
