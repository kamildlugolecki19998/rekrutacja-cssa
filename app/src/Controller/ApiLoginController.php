<?php

namespace App\Controller;

use App\DTO\UserLoginRequestPayload;
use App\Repository\UserRepository;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

class ApiLoginController extends AbstractController
{
    #[Route('/api/login', name: 'app_api_login', methods: ['POST'])]
    public function index(
        #[MapRequestPayload] UserLoginRequestPayload $userLoginRequestPayload,
        JWTTokenManagerInterface                     $jwtManager,
        UserPasswordHasherInterface                  $passwordEncoder,
        UserRepository                               $userRepository
    ): JsonResponse
    {
        $user = $userRepository->findOneBy(['email' => $userLoginRequestPayload->getEmail()]);

        if (!$user || !$passwordEncoder->isPasswordValid($user, $userLoginRequestPayload->getPassword())) {
            return $this->json([
                'message' => 'Invalid credentials',
            ], Response::HTTP_UNAUTHORIZED);
        }

        $token = $jwtManager->create($user);

        return $this->json([
            'token' => $token,
        ]);
    }
}
