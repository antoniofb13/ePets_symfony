<?php

namespace App\Controller;

use App\DTO\ConvertersDTO;
use App\Entity\Asociaciones;
use App\Entity\Comentarios;
use App\Entity\Publicaciones;
use App\Entity\User;
use App\Utilities\Utilidades;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\Request;

#[Route('/api/buscador')]
class BuscadorController extends AbstractController
{

    public function __construct(private ManagerRegistry $doctrine)
    {
    }

    #[Route('/username', methods: ['GET'])]
    #[OA\Tag(name: 'Buscador')]
    #[OA\Parameter(name: 'username', description: "Buscar por username", in: "query", required: true, schema: new OA\Schema(type: "string"))]
    public function buscarPorUsername(Request $request, Utilidades $utilidades, ConvertersDTO $convertersDTO)
    {

        //CARGA DATOS
        $em = $this->doctrine->getManager();
        $userRepository = $em->getRepository(User::class);


        $username = $request->query->get("username");
        $listUser = $userRepository->findLikeUsername($username);

        if ($listUser != null) {
            foreach ($listUser as $user) {
                $userDTO = $convertersDTO->userToDTO($user);
                $json = $utilidades->toJson($userDTO, null);
                $listJson[] = json_decode($json);

            }

        } else {
            return $this->json([
                'mensaje' => "No se han encontrado usuarios",
            ]);
        }
        return $this->json($listJson);
    }

    #[Route('/asociacion', methods: ['GET'])]
    #[OA\Tag(name: 'Buscador')]
    #[OA\Parameter(name: 'username', description: "Buscar por protectora animal", in: "query", required: true, schema: new OA\Schema(type: "string"))]
    public function buscarPorAsociacion(Request $request, Utilidades $utilidades, ConvertersDTO $convertersDTO)
    {

        //CARGA DATOS
        $em = $this->doctrine->getManager();
        $userRepository = $em->getRepository(User::class);
        $asociacionRepository = $em->getRepository(Asociaciones::class);

        $username = $request->query->get("username");
        //$user = $userRepository->findLikeUsername($username);

        $listAsociacion = $asociacionRepository->findLikeUsername($username);
        if ($listAsociacion != null) {
            foreach ($listAsociacion as $asociacion){
                $asociacionDTO = $convertersDTO->asociacionToDTO($asociacion);
                $json = $utilidades->toJson($asociacionDTO, null);
                $listJson[] = json_decode($json);
            }
            return new JsonResponse($listJson, 200, [], false);
        } else {
            return $this->json([
                'mensaje' => "Asociación no encontrada",
            ]);
        }
    }
}
