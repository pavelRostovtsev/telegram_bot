<?php

namespace App\Controller;

use App\Services\telegram\DTO\TelegramDTO;
use App\Services\telegram\Exceptions\TelegramCommandNotFoundException;
use App\Services\telegram\Services\CommandService;
use App\Services\telegram\Services\TelegramUserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class TelegramController extends AbstractController
{
    private CommandService $commandService;
    private TelegramUserService $telegramUserService;

    public function __construct(CommandService $commandService, TelegramUserService $telegramUserService)
    {
        $this->commandService = $commandService;
        $this->telegramUserService = $telegramUserService;
    }

    #[Route('/webhook', name: 'app_webhook', methods: 'POST')]
    public function webhookAction(Request $request): JsonResponse
    {
        $data = new TelegramDTO($request);

        if (!$this->telegramUserService->checkingExistUser($data->getUserId())) {
            $this->telegramUserService->createUser($data);
        }

        try {
            $command = $this->commandService->getCommand($data->getCommand());

        } catch (TelegramCommandNotFoundException) {
            $this->commandService->sendMessageCommandNotFound($data->getUserId(), $data->getFullTextCommand());

            return new JsonResponse(400);
        }

        $command->start($data);

        return new JsonResponse();
    }

    #[Route('/test', name: 'app_test')]
    public function test(): JsonResponse
    {
        return $this->json('Maks ruina');
    }
}
