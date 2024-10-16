<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class TestController extends AbstractController
{
    #[Route('/api/ping', name: 'ping')]
    public function index(): Response
    {
        return $this->json([
            'pong' => true,
        ]);
    }

    #[Route('/api/login', name: 'api_login', methods: ['POST'])]
    public function login(): JsonResponse
    {
        $user = $this->getUser();

        return new JsonResponse(
            [
                'user' => $user->getUserIdentifier() ?? null,
            ], $user ? 200: 401
        );
    }
}
