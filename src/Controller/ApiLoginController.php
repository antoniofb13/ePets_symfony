<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Utilities\Utilidades;
use http\Env\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

class ApiLoginController extends AbstractController
{
    #[Route('/api/login', name: 'app_api_login', methods: ['POST'])]
    public function index(Request $request, UserRepository $userRepository): JsonResponse
    {
        $json = json_decode($request->getContent(), true);
        $user = $userRepository->findOneBy(['email'=>$json['email']]);

        if (null === $user) {
            return $this->json([
            'message' => 'missing credentials',
            ]);
        }

        $token = 234567; // somehow create an API token for $user

        return $this->json([
            'user'  => $user->getUserIdentifier(),
            'token' => $token,
        ]);
    }

    #[Route('/usuario/list', name: 'app_usuario_listar', methods: ['GET'])]
    public function listar(#[CurrentUser] ?User $user, UserRepository $usuarioRepository, Utilidades $utilidades): JsonResponse
    {
        $listUsuarios= $usuarioRepository->findAll();

        $listJson = $utilidades->toJson($listUsuarios);

        return $this->json([
            'user'  => $user->getUserIdentifier(),
            'lista' => $listJson,
        ]);

    }

}
