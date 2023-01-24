<?php

namespace App\Controller;

use App\Entity\ApiKey;
use App\Entity\Rol;
use App\Entity\User;
use App\Repository\RolRepository;
use App\Utilities\Utilidades;
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
    public function save(ManagerRegistry $managerRegistry, Request $request, Utilidades $utilidades): JsonResponse
    {
        //CARGA DATOS
        $em = $this-> doctrine->getManager();
        $userRepository = $em->getRepository(User::class);
        $rolRepository = $em->getRepository(Rol::class);
        $apiKeyRepository = $em->getRepository(ApiKey::class);

        //Obtener Json del body
        $json  = json_decode($request->getContent(), true);

        //CREAR NUEVO USUARIO A PARTIR DEL JSON
        $usuarioNuevo = new User();
        $usuarioNuevo->setEmail($json['email']);
        $usuarioNuevo->setPassword($utilidades->hashPassword($json['password']));
        $usuarioNuevo->setNombre($json['nombre']);
        $usuarioNuevo->setApellidos($json['apellidos']);
        $usuarioNuevo->setUsername($json['username']);
        $usuarioNuevo->setTelefono($json['telefono']);
        $usuarioNuevo->setProtectora($json['protectora']);
        $rolname = $json['id_rol'];
        if($rolname == null){
            $roluser = $rolRepository->find(1);
            $usuarioNuevo->setIdRol($roluser);
        }
        $usuarioNuevo->setIdRol($managerRegistry->getRepository(Rol::class)->findOneBy(array("tipo"=>$rolname)));

        //GUARDAR
        $userRepository->save($usuarioNuevo, true);

        //GENERAR TOKEN
        $utilidades->generateApiToken($usuarioNuevo, $apiKeyRepository);


        return new JsonResponse("{ mensaje: Usuario creado correctamente }", 200, [], true);
    }
}
