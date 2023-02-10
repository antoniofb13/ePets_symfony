<?php

namespace App\Controller;

use App\DTO\CambiarEstadoPubDTO;
use App\DTO\ConvertersDTO;
use App\DTO\PublicacionesDTO;
use App\DTO\PublicacionSaveDTO;
use App\Entity\Comentarios;
use App\Entity\Publicaciones;
use App\Entity\User;
use App\Repository\PublicacionesRepository;
use App\Utilities\Utilidades;
use DateTime;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Attributes as OA;
use Nelmio\ApiDocBundle\Annotation\Model;


#[Route("/api/publicaciones")]
class PublicacionController extends AbstractController
{

    public function __construct(private ManagerRegistry $doctrine)
    {
    }

    #[Route('/save', name: 'app_publicacion', methods: ['POST'])]
    #[OA\Tag(name: 'Publicaciones')]
    #[OA\RequestBody(description: "Dto de publicacion", content: new OA\JsonContent(ref: new Model(type: PublicacionSaveDTO::class)))]
    public function savePublicacion(Request $request)
    {
        //CARGA DATOS
        $em = $this->doctrine->getManager();
        $userRepository = $em->getRepository(User::class);
        $publicacionRepository = $em->getRepository(Publicaciones::class);

        //Obtener Json del body
        $json = json_decode($request->getContent(), true);

        //CREO UNA NUEVA ASOCIACION
        $publicacionNueva = new Publicaciones();

        //BUSCAMOS EL USUARIO QUE VA A CREAR LA NUEVA PUBLICACION
        $username = $json["username"];
        $user = $userRepository->findOneBy(array("username" => $username));
        //$idUser = $user->getId();

        //OBTENGO LA FECHA ACTUAL
        $fechaActual = date("Y-m-d H:i:s");
        $fecha = DateTime::createFromFormat('Y-m-d H:i:s', $fechaActual);


        //COMPLETAMOS DATOS DE LA ASOCIACION A TRAVES DEL JSON
        $publicacionNueva->setUser($user);
        $publicacionNueva->setCuerpo($json["cuerpo"]);
        $publicacionNueva->setFechaPub($fecha);
        $publicacionNueva->setLikes(0);

        //GUARDAR
        $publicacionRepository->save($publicacionNueva, true);

        return new JsonResponse("{ mensaje: Publicacion creada correctamente }", 200, [], true);
    }

    #[Route('/list', name: 'app_publicacion_listarpublicaciones', methods: ['GET'])]
    #[OA\Tag(name: 'Listar')]
    public function listarPublicaciones(Utilidades $utilidades, ConvertersDTO $convertersDTO): JsonResponse
    {
        //CARGA DATOS
        $em = $this->doctrine->getManager();
        $publicacionesRepository = $em->getRepository(Publicaciones::class);
        //$comentariosRepository = $em->getRepository(Comentarios::class);

        $listPublicaciones = $publicacionesRepository->buscarPorEstado();

        $listJson = array();

        foreach ($listPublicaciones as $publicacion) {
            $publicacionDTO = $convertersDTO->publicacionDTO($publicacion);
            $json = $utilidades->toJson($publicacionDTO, null);
            $listJson[] = json_decode($json);
        }

        /*foreach ($listPublicaciones as $publicacion) {
            $listComentarios = $comentariosRepository->findAll();
            foreach ($listComentarios as $comentario) {
                if ($comentario->getPublicacion()->getId() == $publicacion->getId()) {
                    $publicacionDTO = $convertersDTO->publicacionListDTO($publicacion, $comentario);
                    $json = $utilidades->toJson($publicacionDTO, null);
                    $listJson[] = json_decode($json);
                } else {
                    $publicacionDTO = $convertersDTO->publicacionListNoComentDTO($publicacion);
                    $json = $utilidades->toJson($publicacionDTO, null);
                    $listJson[] = json_decode($json);
                }
            }
        }*/

        return new JsonResponse($listJson, 200, [], false);
    }


    #[Route('/list/acabadas', name: 'app_publicacion_listarpublicacionesacabadasporusuario', methods: ['GET'])]
    #[OA\Tag(name: 'Listar')]
    #[OA\Parameter(name: 'idUser', description: "Id del Usuario", in: "query", required: true, schema: new OA\Schema(type: "string") )]
    public function listarPublicacionesAcabadasPorUsuario(Utilidades $utilidades, ConvertersDTO $convertersDTO, Request $request): JsonResponse
    {
        //CARGA DATOS
        $em = $this->doctrine->getManager();
        $publicacionesRepository = $em->getRepository(Publicaciones::class);
        //$comentariosRepository = $em->getRepository(Comentarios::class);

        $idUser = $request->query->get("idUser");


        $listPublicaciones = $publicacionesRepository->buscarPorEstadoCerradoAndUser($idUser);

        if($listPublicaciones!=null){
            $listJson = array();

            foreach ($listPublicaciones as $publicacion) {
                $publicacionDTO = $convertersDTO->publicacionDTO($publicacion);
                $json = $utilidades->toJson($publicacionDTO, null);
                $listJson[] = json_decode($json);
            }
        }else{
            return new JsonResponse("{ mensaje: No hay publicaciones acabadas }", 200, [], true);
        }


        return new JsonResponse($listJson, 200, [], false);
    }


    #[Route('/cambiar', name: '', methods: ['PUT'])]
    #[OA\Tag(name: 'Actualizar')]
    #[OA\RequestBody(description: "Dto de cambiar Estado", content: new OA\JsonContent(ref: new Model(type: CambiarEstadoPubDTO::class)))]
    #[OA\Parameter(name: 'idPub', description: "Id de la Publicacion", in: "query", required: true, schema: new OA\Schema(type: "string") )]
    public function cambiarEstadoPub(Utilidades $utilidades, ConvertersDTO $convertersDTO, Request $request):JsonResponse{
        //CARGA DATOS
        $em = $this->doctrine->getManager();
        $publicacionesRepository = $em->getRepository(Publicaciones::class);

        $idPub = $request->query->get("idPub");

        $publicacion = $publicacionesRepository->findOneBy(array("id"=>$idPub));


        //Obtener Json del body
        $json  = json_decode($request->getContent(), true);
        if($publicacion){
            $listJson = array();

            $publicacion->setEstado($json["estado"]);
            $em->persist($publicacion);
            $em->flush();

            $publicacionDTO = $convertersDTO->publicacionDTO($publicacion);
            $json = $utilidades->toJson($publicacionDTO, null);
            $listJson[] = json_decode($json);

            return new JsonResponse($listJson, 200, [], false);
        }else{
            return new JsonResponse("{ mensaje: No se encuentra la publicacion }", 200, [], false);
        }

    }
}
