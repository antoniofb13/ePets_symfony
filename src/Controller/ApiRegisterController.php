<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class ApiRegisterController extends AbstractController
{

    public function __construct(private ManagerRegistry $doctrine) {}

    #[Route('/api/register', name: 'app_api_register')]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/ApiRegisterController.php',
        ]);
    }

    #[Route('/usuario/save', name: 'app_usuario_crear', methods: ['POST'])]
    public function save(Request $request, UserPasswordHasherInterface $passwordHasher): JsonResponse
    {

        //Obtener Json del body
        $json  = json_decode($request->getContent(), true);

        //CREAR NUEVO USUARIO A PARTIR DEL JSON
        $usuarioNuevo = new User();
        $plaintextPassword = $json['password'];

        $hashedPassword = $passwordHasher->hashPassword(
            $usuarioNuevo,
            $plaintextPassword
        );

        $usuarioNuevo->setEmail($json['email']);
        $usuarioNuevo->setPassword($hashedPassword);

        //GUARDAR
        $em = $this-> doctrine->getManager();
        $em->persist($usuarioNuevo);
        $em-> flush();

        return new JsonResponse("{ mensaje: Usuario creado correctamente }", 200, [], true);

    }
}
