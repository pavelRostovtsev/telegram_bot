<?php

namespace App\Controller;

use App\Services\telegram\DTO\TelegramDTO;
use App\Services\telegram\Services\CommandService;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class TelegramController extends AbstractController
{

    private CommandService $commandService;
    private LoggerInterface $logger;

    public function __construct(CommandService $commandService, LoggerInterface $logger)
    {
        $this->commandService = $commandService;
//        перенести logger мб?
//        запили асинхронность
        $this->logger = $logger;
    }


    #[Route('/webhook', name: 'webhookAction', methods: 'POST')]
    public function webhookAction(Request $request): JsonResponse
    {
        $data = new TelegramDTO($request);
        $command = $this->commandService->getCommand($data->getCommand());
        $command->start($data);
        return new JsonResponse();
    }

    #[Route('/test', name: 'app_test')]
    public function test(): JsonResponse
    {
        return $this->json('Maks ruina');
    }
}
