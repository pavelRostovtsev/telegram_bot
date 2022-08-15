<?php

declare(strict_types=1);

namespace App\Services\telegram\Services;

use App\Entity\TelegramUser;
use App\Repository\TelegramUserRepository;
use App\Services\telegram\DTO\TelegramDTO;

class TelegramUserService
{
    private TelegramUserRepository $telegramUserRepository;

    public function __construct(TelegramUserRepository $telegramUserRepository)
    {
        $this->telegramUserRepository = $telegramUserRepository;
    }

    public function checkingExistUser(int $id): bool
    {
        return $this->telegramUserRepository->find($id) !== null;
    }

    public function createUser(TelegramDTO $data): void
    {
        $user = new TelegramUser();
        $user->setId($data->getUserId());
        $user->setFirstName($data->getUserFirstName());
        $user->setLastName($data->getUserLastName());
        $user->setUsername($data->getUserName());

        $this->telegramUserRepository->add($user, true);

    }
}
