<?php

namespace App\Controller;

use App\Services\telegram\DTO\TelegramDTO;
use App\Services\telegram\Exceptions\TelegramCommandNotFoundException;
use App\Services\telegram\Services\CommandService;
use App\Services\telegram\Services\TelegramApi;
use App\Services\telegram\Services\TelegramUserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class TelegramController extends AbstractController
{
    private CommandService $commandService;
    private TelegramUserService $telegramUserService;
    private TelegramApi $telegramApi;

    public function __construct(
        CommandService $commandService,
        TelegramUserService $telegramUserService,
        TelegramApi $telegramApi
    ) {
        $this->commandService = $commandService;
        $this->telegramUserService = $telegramUserService;
        $this->telegramApi = $telegramApi;
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
            $this->telegramApi->sendMessage(
                $data->getUserId(),
                'команда ' . $data->getFullTextCommand() . ' не найдена'
            );

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
