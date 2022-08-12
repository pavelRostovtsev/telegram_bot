<?php

declare(strict_types=1);

namespace App\Services\telegram\Commands;

use App\Entity\Url;
use App\Repository\TelegramUserRepository;
use App\Services\telegram\DTO\TelegramDTO;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Exception\ORMException;
use GuzzleHttp\Client;

class SetUrlTelegramCommand extends BaseTelegramCommand implements TelegramCommandInterface
{
    private TelegramUserRepository $telegramUser;
    private EntityManagerInterface $entityManager;

    public function __construct(Client $client, TelegramUserRepository $telegramUser, EntityManagerInterface $entityManager)
    {
        parent::__construct($client);

        $this->telegramUser = $telegramUser;
        $this->entityManager = $entityManager;
    }

    public function getName(): string
    {
        return '/set';
    }

    public function start(TelegramDTO $data):void
    {
        //@todo зарефакторить так как тут может вернуться null
        $user =  $this->telegramUser->find($data->getUserId());

        $url = new Url();
//        потом мб придумаю как красиво сделать
//        $url->setName();
        $url->setUrl($data->getDataCommand());
        $url->setUserId($user);

        $this->entityManager->persist($url);
        $this->entityManager->flush();
    }
}