<?php

namespace App\Controller;

use App\Entity\Usuario;
use App\Repository\UsuarioRepository;
use App\Utilities\Utilidades;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    public function __construct(private ManagerRegistry $doctrine) {}

    #[Route('/user', name: 'app_user')]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/UserController.php',
        ]);
    }

    #[Route('/usuario/listar', name: 'app_usuario_listar', methods: ['GET'])]
    public function listar(UsuarioRepository $usuarioRepository, Utilidades $utilidades): JsonResponse
    {
        $listUsuarios= $usuarioRepository->findAll();

        $listJson = $utilidades->toJson($listUsuarios);

        return new JsonResponse($listJson, 200,[],true);

    }

    #[Route('/usuario/save', name: 'app_user_save', methods: ['POST'])]
    public function save(Request $request): JsonResponse
    {

        //Obtener Json del body
        $json  = json_decode($request->getContent(), true);

        //CREAR NUEVO USUARIO A PARTIR DEL JSON
        $usuarioNuevo = new Usuario();
        $usuarioNuevo->setUsername($json['username']);
        $usuarioNuevo->setPassword($json['password']);
        $usuarioNuevo->setEmail($json['email']);
        $usuarioNuevo->setTelefono($json['telefono']);


        //GUARDAR
        $em = $this-> doctrine->getManager();
        $em->persist($usuarioNuevo);
        $em-> flush();

        return new JsonResponse("{ mensaje: Usuario creado correctamente }", 200, [], true);


    }
}
