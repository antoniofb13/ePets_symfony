<?php

namespace App\Controller;

use App\DTO\ConvertersDTO;
use App\DTO\PublicacionSaveDTO;
use App\DTO\SaveChatDTO;
use App\Entity\Chat;
use App\Entity\Publicaciones;
use App\Entity\User;
use App\Utilities\Utilidades;
use DateTime;
use Doctrine\Persistence\ManagerRegistry;
use Nelmio\ApiDocBundle\Annotation\Model;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Attributes as OA;

#[Route('/api/chat')]
class ChatController extends AbstractController
{

    public function __construct(private ManagerRegistry $doctrine)
    {
    }

    #[Route('/send', name: 'app_chat_enviarmensaje', methods: ['POST'])]
    #[OA\Tag(name: 'Chat')]
    #[OA\Parameter(name: 'idEmisor', description: "Id del Usuario emisor", in: "query", required: true, schema: new OA\Schema(type: "string"))]
    #[OA\RequestBody(description: "Dto de chat", content: new OA\JsonContent(ref: new Model(type: SaveChatDTO::class)))]
    public function enviarMensaje(Request $request){

        //CARGA DATOS
        $em = $this->doctrine->getManager();
        $userRepository = $em->getRepository(User::class);
        $chatRepository = $em->getRepository(Chat::class);

        $idEmisor = $request->query->get("idEmisor");

        $emisor = $userRepository->findOneBy(array("id"=>$idEmisor));

        //Obtener Json del body
        $json = json_decode($request->getContent(), true);

        if($emisor){
            $id_receptor = $json["idReceptor"];
            $receptor = $userRepository->findOneBy(array("id"=>$id_receptor));

            $fechaActual = date("Y-m-d H:i:s");
            $fecha = DateTime::createFromFormat('Y-m-d H:i:s', $fechaActual);


            $chatNuevo = new Chat();
            if($receptor){
                $chatNuevo->setReceptor($receptor);
                $chatNuevo->setCuerpo($json["cuerpo"]);
                $chatNuevo->setEmisor($emisor);
                $chatNuevo->setFecha($fecha);
            }else{
                return $this->json([
                    "error"=>"no existe este receptor",
                ]);
            }

        }else{
            return $this->json([
                "error"=>"no existe este usuario"
            ]);
        }
        //GUARDAR
        $chatRepository->save($chatNuevo, true);

        return $this->json([
           "message"=>"Mensaje enviado correctamente",
        ]);
    }

    #[Route('/listMensajes', name: 'app_chat_vermensajes', methods: ['GET'])]
    #[OA\Tag(name: 'Chat')]
    #[OA\Parameter(name: 'idUser', description: "Id del Usuario que quiere ver sus chats", in: "query", required: true, schema: new OA\Schema(type: "string"))]
    public function verMensajes(Utilidades $utilidades, ConvertersDTO $convertersDTO, Request $request){
        //CARGA DATOS
        $em = $this->doctrine->getManager();
        $userRepository = $em->getRepository(User::class);
        $chatRepository = $em->getRepository(Chat::class);

        $idUser = $request->query->get("idUser");
        $user = $userRepository->findOneBy(array("id"=>$idUser));

        if($user){
            $listMensajes = $chatRepository->findByUser($idUser);

            if($listMensajes!=null){
                $listJson = array();
                foreach ($listMensajes as $mensaje){
                    $chatDTO = $convertersDTO->chatToDTO($mensaje);
                    $json = $utilidades->toJson($chatDTO, null);
                    $listJson[] = json_decode($json);
                }
            }else{
                return $this->json([
                    "error"=>"No hay mensajes disponibles",
                ]);
            }
        }else{
            return $this->json([
                "error"=>"este usuario receptor no existe",
            ]);
        }
        return $this->json([
            "mensajes"=>$listJson
        ]);
    }
}
