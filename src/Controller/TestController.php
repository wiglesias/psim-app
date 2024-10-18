<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
}
