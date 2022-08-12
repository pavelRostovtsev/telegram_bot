<?php

declare(strict_types=1);

namespace App\Services\telegram\Commands;

use App\Entity\TelegramUser;
use App\Repository\TelegramUserRepository;
use App\Services\telegram\DTO\TelegramDTO;
use Doctrine\ORM\EntityManagerInterface;

class StartTelegramCommand implements TelegramCommandInterface
{
    private TelegramUserRepository $telegramUserRepository;
    private EntityManagerInterface $entityManager;

    public function __construct(TelegramUserRepository $telegramUserRepository, EntityManagerInterface $entityManager)
    {
        $this->telegramUserRepository = $telegramUserRepository;
        $this->entityManager = $entityManager;
    }

    public function getName(): string
    {
        return '/start';
    }

    public function start(TelegramDTO $data): void
    {
        if (is_null($this->telegramUserRepository->find($data->getUserId()))) {
            $user = new TelegramUser();
            $user->setId($data->getUserId());
            $user->setFirstName($data->getUserFirstName());
            $user->setLastName($data->getUserLastName());
            $user->setUsername($data->getUserName());

            $this->entityManager->persist($user);
            $this->entityManager->flush($user);
        }
    }

}
