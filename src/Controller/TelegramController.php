<?php

namespace App\Controller;

use App\Services\telegram\DTO\TelegramDTO;
use App\Services\telegram\Exceptions\TelegramCommandNotFoundException;
use App\Services\telegram\Services\CommandService;
use App\Services\telegram\Services\TelegramApi;
use App\Services\telegram\Services\TelegramUserService;
use Exception;
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
        $this->telegramApi->sendMessage(
            $data->getUserId(),
            $data->getCommand()
        );return new JsonResponse();
//        if (!$this->telegramUserService->checkingExistUser($data->getUserId())) {
//            $this->telegramUserService->createUser($data);
//        }
//        //@todo нужно в отдельный сервис вынести
//        $responseData = '';
//
//        try {
//            $command = $this->commandService->getCommand($data->getCommand());
//            $command->start($data);
//        } catch (TelegramCommandNotFoundException) {
//            $responseData = 'command ' . $data->getFullTextCommand() . ' not found';
//
//            $this->telegramApi->sendMessage(
//                $data->getUserId(),
//                $responseData
//            );
//        } catch (Exception) {
//            $this->telegramApi->sendMessage(
//                $data->getUserId(),
//                'что-то пошло не так'
//            );
//        }
//
//        return new JsonResponse($responseData ?: null);
    }

    #[Route('/test', name: 'app_test')]
    public function test(): JsonResponse
    {
        return $this->json('Maks ruina');
    }
}
