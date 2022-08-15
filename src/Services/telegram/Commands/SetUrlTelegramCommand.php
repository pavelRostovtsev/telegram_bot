<?php

declare(strict_types=1);

namespace App\Services\telegram\Commands;

use App\Entity\Url;
use App\Repository\TelegramUserRepository;
use App\Repository\UrlRepository;
use App\Services\telegram\DTO\TelegramDTO;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Exception\ORMException;
use GuzzleHttp\Client;

class SetUrlTelegramCommand extends BaseTelegramCommand implements TelegramCommandInterface
{
    private TelegramUserRepository $telegramUser;
    private UrlRepository $urlRepository;

    public function __construct(Client $client, TelegramUserRepository $telegramUser, UrlRepository $urlRepository)
    {
        parent::__construct($client);

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
        $url = new Url();
        $url->setUrl($data->getDataCommand());
        $url->setUserId($user);

        $this->urlRepository->add($url, true);

    }
}
