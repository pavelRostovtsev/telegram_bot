<?php

namespace App\Controller;

use App\Services\telegram\Services\CommandService;
use GuzzleHttp\Exception\GuzzleException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class TelegramController extends AbstractController
{

    private CommandService $commandService;

    public function __construct(CommandService $commandService)
    {
        $this->commandService = $commandService;
    }

    /**
     * @Route("/telegram", name="app_telegram")
     * @throws GuzzleException
     */
    public function index(): JsonResponse
    {
        $command = $this->commandService->getCommand('TestTelegramCommand');
        $response =  $command->sendMessage('helloWord', '886485500');
        return $this->json($response->getStatusCode());
    }

    /**
     * @Route("/test", name="app_test")
     */
    public function test(): JsonResponse
    {
        return $this->json('');
    }
}
