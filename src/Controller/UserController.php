<?php

namespace App\Controller;

use App\DTO\ConvertersDTO;
use App\Entity\Publicaciones;
use App\Entity\User;
use App\Utilities\Utilidades;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Attributes as OA;
#[Route("/api/usuario")]
class UserController extends AbstractController
{
    public function __construct(private ManagerRegistry $doctrine)
    {
    }
    #[Route('/verPerfil', name: 'app_user_verperfilypublicaciones', methods: ['GET'])]
    #[OA\Tag(name: 'Perfil')]
    #[OA\Parameter(name: 'idUser', description: "Id del Usuario", in: "query", required: true, schema: new OA\Schema(type: "string") )]
    public function verPerfilyPublicaciones(Utilidades $utilidades, ConvertersDTO $convertersDTO, Request $request): JsonResponse
    {
        //CARGA DATOS
        $em = $this->doctrine->getManager();
        $publicacionesRepository = $em->getRepository(Publicaciones::class);
        $usuarioRepository = $em->getRepository(User::class);

        $idUser = $request->query->get("idUser");

        $user =$usuarioRepository->findOneBy(array("id"=>$idUser));

        if ($user){

            $listPublicaciones = $publicacionesRepository->buscarPorIdUser($idUser);

            $userDto = $convertersDTO->userToDTO($user);


            if($listPublicaciones!=null){
                $listJson = array();

                foreach ($listPublicaciones as $publicacion) {
                    $publicacionDTO = $convertersDTO->publicacionDTO($publicacion);
                    $json = $utilidades->toJson($publicacionDTO, null);
                    $listJson[] = json_decode($json);
                }
            }else{
                return new JsonResponse("{ mensaje: No hay publicaciones de este usuario }", 200, [], true);
            }
        }else{
            return new JsonResponse("{ mensaje: No se ha encontrado el usuario }", 200, [], true);
        }

        return $this->json([
            'user' => $userDto,
            'publicaciones' => $listJson
        ]);
    }
}
