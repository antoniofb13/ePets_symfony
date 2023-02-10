<?php

namespace App\Controller;

use App\DTO\AsociacionDTO;
use App\DTO\ComentariosDTO;
use App\DTO\UserDto;
use App\Entity\Comentarios;
use App\Entity\Publicaciones;
use App\Entity\User;
use DateTime;
use Doctrine\Persistence\ManagerRegistry;
use Nelmio\ApiDocBundle\Annotation\Model;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Attributes as OA;


class ComentariosController extends AbstractController
{

    public function __construct(private ManagerRegistry $doctrine) {}

    #[Route('api/comentarios/saveComen', name: 'app_comentarios_savecomentario', methods: ['POST'])]
    #[OA\Tag(name: 'Comentarios')]
    #[OA\RequestBody(description: "Dto de Registro", content: new OA\JsonContent(ref: new Model(type: ComentariosDTO::class)))]
    #[OA\Parameter(name: 'id_pub', description: "Id de publicacion a la que pertenece el comentario", in: "query", required: true, schema: new OA\Schema(type: "string") )]
    #[OA\Parameter(name: 'username', description: "Nombre de usuario que va a hacer el comentario", in: "query", required: true, schema: new OA\Schema(type: "string") )]
    public function saveComentario(Request $request){

        //CARGA DATOS
        $em = $this-> doctrine->getManager();
        $userRepository = $em->getRepository(User::class);
        $comentariosRepository = $em->getRepository(Comentarios::class);
        $publicacionesRepository = $em->getRepository(Publicaciones::class);

        //Obtener Json del body
        $json  = json_decode($request->getContent(), true);

        //Buscamos la publicacion
        $idPub = $request->query->get("id_pub");
        $publicacion = $publicacionesRepository->findOneBy(array("id"=>$idPub));

        //Buscamos el usuario
        $username = $request->query->get("username");
        $usuario = $userRepository->findOneBy(array("username"=>$username));

        //Buscamos la fecha actual
        $fechaActual = date("Y-m-d H:i:s");
        $fecha = DateTime::createFromFormat('Y-m-d H:i:s', $fechaActual);


        if($publicacion && $usuario){
            $comentarioNuevo = new Comentarios();
            $comentarioNuevo->setUser($usuario);
            $comentarioNuevo->setMensaje($json["mensaje"]);
            $comentarioNuevo->setFechaCom($fecha);
            $comentarioNuevo->setPublicacion($publicacion);

            $comentariosRepository->save($comentarioNuevo, true);

            return $this->json([
                'message' => "Comentario creado correctamente",
            ]);
        }else{
            return $this->json([
            'message'=>"Usuario o publicacion incorrectos"
            ]);
        }

    }
}
