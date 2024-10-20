<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Firebase\JWT\JWT;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

class ApiAuthController extends AbstractController
{
    #[Route('/api/auth/register', name: 'api_auth_register', methods: ['POST'])]
    public function register(
        Request $request,
        UserPasswordHasherInterface $passwordHasher,
        UserRepository $userRepository,
    ): JsonResponse
    {
        $payload = $request->getPayload();
        $email = $payload->get('email');
        $plainPassword = $payload->get('password');

        $user = User::createNewWithEmail($email);
        $user->setPassword($passwordHasher->hashPassword($user, $plainPassword));

        try {
            $userRepository->save($user);
        } catch (UniqueConstraintViolationException $exception) {
            throw new BadRequestException('Email already in use');
        }

        return new JsonResponse([
            'success' => true,
        ]);
    }

    #[Route('/api/auth/login', name: 'api_auth_login', methods: ['POST'])]
    public function login(string $jwtSecret): JsonResponse {
        $user = $this->getUser();
        if (!$user instanceof User) {
            throw new \Exception('Invalid user type');
        }

        $payload = [
            'iat' => time(),
            'exp' => time() + 3600 * 24,
            'sub' => $user->getId()
        ];


        return new JsonResponse(
            [
                'token' => JWT::encode($payload, $jwtSecret, 'HS256')
            ],
        );
    }
}
