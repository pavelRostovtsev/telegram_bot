<?php

namespace App\Controller;

use App\Services\telegram\Services\CommandService;
use GuzzleHttp\Exception\GuzzleException;
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
        $this->logger = $logger;
    }

    #[Route('/webhook', name: 'webhookAction', methods: 'POST')]
    public function webhookAction(Request $request): JsonResponse
    {
        $this->logger->info((string)$request->request->all(), 'telegram');
        return new JsonResponse('kek', 200);
    }

    #[Route('/test', name: 'app_test')]
    public function test(): JsonResponse
    {
        return $this->json('Maks ruina');
    }
}
