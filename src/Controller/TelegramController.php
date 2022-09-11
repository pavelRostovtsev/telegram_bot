<?php

namespace App\Controller;

use App\Services\telegram\DTO\TelegramDTO;
use App\Services\telegram\Exceptions\TelegramCommandNotFoundException;
use App\Services\telegram\Services\CommandService;
use App\Services\telegram\Services\ProcessService;
use App\Services\telegram\Services\TelegramApi;
use App\Services\telegram\Services\TelegramUserService;
use Exception;
use RedisException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class TelegramController extends AbstractController
{
    private CommandService $commandService;
    private TelegramUserService $telegramUserService;
    private TelegramApi $telegramApi;
    private ProcessService $processService;

    public function __construct(
        CommandService $commandService,
        TelegramUserService $telegramUserService,
        TelegramApi $telegramApi,
        ProcessService $processService
    ) {
        $this->commandService = $commandService;
        $this->telegramUserService = $telegramUserService;
        $this->telegramApi = $telegramApi;
        $this->processService = $processService;
    }

    #[Route('/webhook', name: 'app_webhook', methods: 'POST')]
    public function webhookAction(Request $request): JsonResponse
    {
        $data = new TelegramDTO($request);

        if (!$this->telegramUserService->checkingExistUser($data->getUserId())) {
            $this->telegramUserService->createUser($data);
        }
        //@todo нужно в отдельный сервис вынести
        $responseData = '';

        try {
            $command = $this->commandService->getCommand($data->getCommand());
            $command->start($data);
        } catch (TelegramCommandNotFoundException) {
            $responseData = 'command ' . $data->getFullTextCommand() . ' not found';

            $this->telegramApi->sendMessage(
                $data->getUserId(),
                $responseData
            );
        } catch (Exception) {
            $this->telegramApi->sendMessage(
                $data->getUserId(),
                'что-то пошло не так'
            );
        }

        return new JsonResponse($responseData ?: null);
    }

    #[Route('/test', name: 'app_test')]
    public function test(): JsonResponse
    {
        return $this->json('Maks ruina');
    }

    #[Route('/abracadabra', name:'app_abracadabra')]
    public function abracadabra(): JsonResponse
    {
        dd(1);die;
    }
}
