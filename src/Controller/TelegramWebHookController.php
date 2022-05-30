<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class TelegramWebHookController extends AbstractController
{
    /**
     * @Route("/telegram/web/hook", name="app_telegram_web_hook")
     */
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/TelegramWebHookController.php',
        ]);
    }
}
