<?php

namespace App\Controller;

use App\DTO\AsociacionDTO;
use App\DTO\ConvertersDTO;
use App\DTO\PublicacionesDTO;
use App\Entity\Publicaciones;
use App\Entity\User;
use App\Repository\AsociacionesRepository;
use App\Repository\PublicacionesRepository;
use App\Utilities\Utilidades;
use DateTime;
use DateTimeImmutable;
use Doctrine\Persistence\ManagerRegistry;
use Nelmio\ApiDocBundle\Annotation\Model;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Attributes as OA;

class PublicacionController extends AbstractController
{

    public function __construct(private ManagerRegistry $doctrine) {}

    #[Route('/publicacion', name: 'app_publicacion')]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/PublicacionController.php',
        ]);
    }

    #[Route('/publicacion/save', name: 'app_publicacion')]
    public function savePublicacion(Request $request)
    {
        //CARGA DATOS
        $em = $this-> doctrine->getManager();
        $userRepository = $em->getRepository(User::class);
        $publicacionRepository = $em->getRepository(Publicaciones::class);

        //Obtener Json del body
        $json  = json_decode($request->getContent(), true);

        //CREO UNA NUEVA ASOCIACION
        $publicacionNueva = new Publicaciones();

        //BUSCAMOS EL USUARIO QUE VA A CREAR LA NUEVA PUBLICACION
        $username = $json["username"];
        $user = $userRepository->findOneBy(array("username"=>$username));
        //$idUser = $user->getId();

        //OBTENGO LA FECHA ACTUAL
        $fechaActual = date("Y-m-d H:i:s");
        $fecha = DateTime::createFromFormat('Y-m-d H:i:s', $fechaActual);


        //COMPLETAMOS DATOS DE LA ASOCIACION A TRAVES DEL JSON
        $publicacionNueva->setUser($user);
        $publicacionNueva->setCuerpo($json["cuerpo"]);
        $publicacionNueva->setFechaPub($fecha);

        //GUARDAR
        $publicacionRepository->save($publicacionNueva, true);

        return new JsonResponse("{ mensaje: Publicacion creada correctamente }", 200, [], true);
    }

    #[Route('api/publicacion/list', name: 'app_publicacion_listarpublicaciones', methods: ['GET'])]
    #[OA\Tag(name: 'Listar')]
    #[OA\Response(response:200,description:"successful operation" ,content: new OA\JsonContent(type: "array", items: new OA\Items(ref:new Model(type: PublicacionesDTO::class))))]
    #[OA\Parameter(name: 'api_key', description: "Api de autentificación", in: "query", required: true, schema: new OA\Schema(type: "string") )]
    public function listarPublicaciones(PublicacionesRepository $publicacionesRepository, Utilidades $utilidades, ConvertersDTO $convertersDTO): JsonResponse
    {
        $listPublicaciones = $publicacionesRepository->findAll();

        $listJson = array();

        foreach ($listPublicaciones as $publicacion){
            $publicacionDTO = $convertersDTO->publicacionDTO($publicacion);
            $json = $utilidades->toJson($publicacionDTO, null);
            $listJson[] = json_decode($json);
        }

        return new JsonResponse($listJson, 200,[],false);
    }
}
