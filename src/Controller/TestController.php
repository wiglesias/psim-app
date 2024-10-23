<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class TestController extends AbstractController
{
    #[Route('/api/ping', name: 'ping')]
    public function index(): JsonResponse
    {
        return new JsonResponse([
            'pong' => true,
        ]);
    }
}
