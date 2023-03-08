<?php

namespace App\Controller;
use App\DTO\AsociacionDTO;
use App\DTO\ConvertersDTO;
use App\DTO\SaveAsociacionDTO;
use App\DTO\UserDto;
use App\Entity\ApiKey;
use App\Entity\Asociaciones;
use App\Entity\Publicaciones;
use App\Entity\User;
use App\Repository\AsociacionesRepository;
use App\Utilities\Utilidades;
use ReallySimpleJWT\Token;
use Symfony\Component\HttpFoundation\Request;
use Nelmio\ApiDocBundle\Annotation\Model;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Attributes as OA;
use Doctrine\Persistence\ManagerRegistry;


#[Route('/api/asociacion')]
class AsociacionController extends AbstractController
{

    private ManagerRegistry $doctrine;

    public function __construct(ManagerRegistry $managerRegistry)
    {
        $this-> doctrine = $managerRegistry;
    }


    #[Route('/list', name: 'app_asociacion_listar', methods: ['GET'])]
    #[OA\Tag(name: 'Listar')]
    //#[OA\Response(response:200,description:"successful operation" ,content: new OA\JsonContent(type: "array", items: new OA\Items(ref:new Model(type: AsociacionDTO::class))))]
  //  #[OA\Parameter(name: 'api_key', description: "Api de autentificación", in: "query", required: true, schema: new OA\Schema(type: "string") )]
    public function listarAsociaciones(AsociacionesRepository $asociacionesRepository, Utilidades $utilidades, ConvertersDTO $convertersDTO, Request $request): JsonResponse
    {

        $em = $this-> doctrine->getManager();
        $userRepository = $em->getRepository(User::class);
     //   $apikeyRepository = $em->getRepository(ApiKey::class);

       // $apikey = $request->query->get("api_key");
       // $compruebaAcceso = $utilidades->esApiKeyValida($apikey, "ROLE_USER", $apikeyRepository, $userRepository);

        //if($compruebaAcceso){
            $listAsociaciones = $asociacionesRepository->findAll();

            $listJson = array();

            foreach ($listAsociaciones as $asociacion){
                $asociacionDTO = $convertersDTO->asociacionToDTO($asociacion);
                $json = $utilidades->toJson($asociacionDTO, null);
                $listJson[] = json_decode($json);
            }

            return new JsonResponse($listJson, 200,[],false);
        //}else{
          //  return $this->json([
            //    'message' => "No tiene permiso",
            //]);
        //}

    }

    #[Route('/verAsociacion', name: 'app_asociacion_verperfilasocypublicaciones', methods: ['GET'])]
    #[OA\Tag(name: 'Perfil')]
    #[OA\Parameter(name: 'idAsociacion', description: "Id de la Asociacion", in: "query", required: true, schema: new OA\Schema(type: "string"))]
    public function verPerfilAsocYPublicaciones(Utilidades $utilidades, ConvertersDTO $convertersDTO, Request $request)
    {
        //CARGA DATOS
        $em = $this->doctrine->getManager();
        $publicacionesRepository = $em->getRepository(Publicaciones::class);
        $usuarioRepository = $em->getRepository(User::class);
        $asociacionRepository = $em->getRepository(Asociaciones::class);

        $idAsociacion = $request->query->get("idAsociacion");

        $asociacion = $asociacionRepository->findOneBy(array("id"=>$idAsociacion));

        if($asociacion){
            $idUserAsoc = $asociacion->getUser()->getId();
            $user = $usuarioRepository->findOneBy(array("id"=>$idUserAsoc));

            if($user){
                $listPublicaciones = $publicacionesRepository->buscarPorIdUser($idUserAsoc);

                $asocDTO = $convertersDTO->asociacionToDTO($asociacion);

                if ($listPublicaciones != null) {
                    $listJson = array();

                    foreach ($listPublicaciones as $publicacion) {
                        $publicacionDTO = $convertersDTO->publicacionDTO($publicacion);
                        $json = $utilidades->toJson($publicacionDTO, null);
                        $listJson[] = json_decode($json);
                    }
                }else{
                    return $this->json([
                        'asociacion' => $asocDTO,
                        'publicaciones'=> 'No hay publicaciones de esta asociacion'
                    ]);
                }
            }else{
                return $this->json([
                    "error"=> "No se encuentra el usuario asociado a esta protectora."
                ]);
            }

        }else{
            return $this->json([
                "error"=> "No se encuentra esta asociacion"
            ]);
        }
        return $this->json([
            "asociacion"=>$asocDTO,
            "publicaciones"=>$listJson
        ]);
    }

    #[Route('/deleteProtectora', name: 'app_asociacion_dejarserprotectora', methods: ['DELETE'])]
    #[OA\Tag(name: 'Protectora')]
    //#[OA\Parameter(name: 'idAsociacion', description: "Id de la Asociacion", in: "query", required: true, schema: new OA\Schema(type: "string"))]
    public function dejarSerProtectora(Request $request, Utilidades $utilidades){
        //CARGA DATOS
        $em = $this->doctrine->getManager();
        $usuarioRepository = $em->getRepository(User::class);
        $asociacionRepository = $em->getRepository(Asociaciones::class);

        //Obtener token de header
        $token = $request->headers->get('token');
        $valido = $utilidades->esApiKeyValida($token, null);

        if (!$valido) {
            return $this->json([
                "prohibido" => "no tiene permisos para acceder a este sitio"
            ]);
        }else{
            //Buscamos el usuario
            $idUsuario = Token::getPayload($token)['user_id'];
            $user = $usuarioRepository->findOneBy(array("id"=>$idUsuario));

            if($user){
                $asociacion = $asociacionRepository->findOneBy(array("user"=>$user));
                $user->setProtectora(0);
                $em->persist($user);
                $em->flush();
                if($asociacion){
                    $asociacionRepository->remove($asociacion);
                    $em->flush();
                }else{
                    return $this->json([
                        "error"=>"asociacion no encontrada"
                    ]);
                }
            }else{
                return $this->json([
                    "error"=>"usuario no encontrado"
                ]);
            }
        }
        return $this->json([
            "message"=>"este usuario ya no es una protectora"
        ]);
    }
}
