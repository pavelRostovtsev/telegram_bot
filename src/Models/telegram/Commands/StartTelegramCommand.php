<?php

declare(strict_types=1);

namespace App\Models\telegram\Commands;

use App\Entity\TelegramUser;
use App\Repository\TelegramUserRepository;
use App\Models\telegram\DTO\TelegramDTO;
use App\Models\telegram\Services\TelegramUserService;
use Doctrine\ORM\EntityManagerInterface;

class StartTelegramCommand implements TelegramCommandInterface
{
    private TelegramUserService $telegramUserService;

    public function __construct(TelegramUserService $telegramUserService)
    {
        $this->telegramUserService = $telegramUserService;
    }

    public function getName(): string
    {
        return '/start';
    }

    public function start(TelegramDTO $data): void
    {
        if (!$this->telegramUserService->checkingExistUser($data->getUserId())) {
            $this->telegramUserService->createUser($data);
        }
    }
}
