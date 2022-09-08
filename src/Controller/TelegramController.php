<?php

namespace App\Controller;

use App\Services\telegram\DTO\TelegramDTO;
use App\Services\telegram\Exceptions\TelegramCommandNotFoundException;
use App\Services\telegram\Services\CommandService;
use App\Services\telegram\Services\TelegramApi;
use App\Services\telegram\Services\TelegramUserService;
use Exception;
use Redis;
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
    private Redis $redis;

    public function __construct(
        CommandService $commandService,
        TelegramUserService $telegramUserService,
        TelegramApi $telegramApi,
        Redis $redis

    ) {
        $this->commandService = $commandService;
        $this->telegramUserService = $telegramUserService;
        $this->telegramApi = $telegramApi;
        $this->redis = $redis;
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

    /**
     * @throws RedisException
     */
    #[Route('/abracadabra', name:'app_abracadabra')]
    public function abracadabra(): JsonResponse
    {
        $this->redis->hSet('id:12345', 'test', json_encode([1, 2, 3, 4], JSON_THROW_ON_ERROR));
        dump(json_decode($this->redis->hGet('id:12345', 'test')));
        die;
    }
}
