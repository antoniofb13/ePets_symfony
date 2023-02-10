<?php

namespace App\Controller;

use App\DTO\AsociacionDTO;
use App\DTO\ConvertersDTO;
use App\DTO\SaveAsociacionDTO;
use App\DTO\UserDto;
use App\Entity\ApiKey;
use App\Entity\User;
use App\Repository\AsociacionesRepository;
use App\Utilities\Utilidades;
use Symfony\Component\HttpFoundation\Request;
use Nelmio\ApiDocBundle\Annotation\Model;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Attributes as OA;
use Doctrine\Persistence\ManagerRegistry;

class AsociacionController extends AbstractController
{

    private ManagerRegistry $doctrine;

    public function __construct(ManagerRegistry $managerRegistry)
    {
        $this-> doctrine = $managerRegistry;
    }

    #[Route('/asociacion', name: 'app_asociacion')]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/AsociacionController.php',
        ]);
    }

    #[Route('api/asociacion/list', name: 'app_asociacion_listar', methods: ['GET'])]
    #[OA\Tag(name: 'Listar')]
    //#[OA\Response(response:200,description:"successful operation" ,content: new OA\JsonContent(type: "array", items: new OA\Items(ref:new Model(type: AsociacionDTO::class))))]
    #[OA\Parameter(name: 'api_key', description: "Api de autentificación", in: "query", required: true, schema: new OA\Schema(type: "string") )]
    public function listarAsociaciones(AsociacionesRepository $asociacionesRepository, Utilidades $utilidades, ConvertersDTO $convertersDTO, Request $request): JsonResponse
    {

        $em = $this-> doctrine->getManager();
        $userRepository = $em->getRepository(User::class);
        $apikeyRepository = $em->getRepository(ApiKey::class);

        $apikey = $request->query->get("api_key");
        $compruebaAcceso = $utilidades->esApiKeyValida($apikey, "ROLE_USER", $apikeyRepository, $userRepository);

        if($compruebaAcceso){
            $listAsociaciones = $asociacionesRepository->findAll();

            $listJson = array();

            foreach ($listAsociaciones as $asociacion){
                $asociacionDTO = $convertersDTO->asociacionToDTO($asociacion);
                $json = $utilidades->toJson($asociacionDTO, null);
                $listJson[] = json_decode($json);
            }

            return new JsonResponse($listJson, 200,[],false);
        }else{
            return $this->json([
                'message' => "No tiene permiso",
            ]);
        }

    }
}
