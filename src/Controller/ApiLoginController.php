<?php

namespace App\Controller;

use App\DTO\ConvertersDTO;
use App\DTO\UserDto;
use App\Entity\ApiKey;
use App\Entity\User;
use App\Repository\UserRepository;
use App\Utilities\Utilidades;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use OpenApi\Attributes as OA;
use Nelmio\ApiDocBundle\Annotation\Model;



class ApiLoginController extends AbstractController
{

    private ManagerRegistry $doctrine;

    public function __construct(ManagerRegistry $managerRegistry)
    {
        $this->doctrine = $managerRegistry;
    }

    #[Route('/api/login', name: 'app_api_login', methods: ['POST'])]
    public function index(Request $request, Utilidades $utilidades): JsonResponse
    {
        //CARGAR REPOSITORIOS
        $em = $this->doctrine->getManager();
        $userRepository = $em->getRepository(User::class);
        $apikeyRepository = $em->getRepository(ApiKey::class);

        $json = json_decode($request->getContent(), true);

        //Datos Usuario
        $username = $json["username"];
        $password = $json["password"];

        //Validar que los credenciales son correcto
        if ($username != null and $password != null) {

            $user = $userRepository->findOneBy(array("username" => $username));

            if ($user != null) {
                $verify = $utilidades->verify($password, $user->getPassword());
                if ($verify) {

                    $token = $apikeyRepository->findApiKeyValida($user);

                    if ($token != null) {
                        return $this->json([
                            'token' => $token->getToken()
                        ]);
                    } else {
                        $tokenNuevo = $utilidades->generateApiToken($user, $apikeyRepository);
                        return $this->json([
                            'token' => $tokenNuevo
                        ]);
                    }
                } else {
                    return $this->json([
                        'message' => "Contraseña no válida",
                    ]);
                }
            }
            return $this->json([
                'message' => "Usuario no válido",
            ]);


        } else {
            return $this->json([
                'message' => "No ha indicado usuario y contraseña",
            ]);

        }
    }


    #[Route('api/usuario/list', name: 'app_usuario_listar', methods: ['GET'])]
    #[OA\Tag(name: 'Listar')]
    #[OA\Response(response:200,description:"successful operation" ,content: new OA\JsonContent(type: "array", items: new OA\Items(ref:new Model(type: UserDto::class))))]
    public function listar(UserRepository $usuarioRepository, Utilidades $utilidades, ConvertersDTO $convertersDTO): JsonResponse
    {
        $listUsuarios = $usuarioRepository->findAll();

        $listJson = array();

        foreach ($listUsuarios as $user){
            $userDto = $convertersDTO->userToDTO($user);
            $json = $utilidades->toJson($userDto, null);
            $listJson[] = json_decode($json);
        }

        return new JsonResponse($listJson, 200,[],false);
    }

}
