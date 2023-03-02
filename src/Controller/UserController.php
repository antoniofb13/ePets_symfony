<?php

namespace App\Controller;

use App\DTO\CambiarEstadoPubDTO;
use App\DTO\ConvertersDTO;
use App\DTO\editarUserDTO;
use App\DTO\saveUserDTO;
use App\Entity\Publicaciones;
use App\Entity\User;
use App\Utilities\Utilidades;
use Doctrine\Persistence\ManagerRegistry;
use Nelmio\ApiDocBundle\Annotation\Model;
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
    #[OA\Parameter(name: 'idUser', description: "Id del Usuario", in: "query", required: true, schema: new OA\Schema(type: "string"))]
    public function verPerfilyPublicaciones(Utilidades $utilidades, ConvertersDTO $convertersDTO, Request $request): JsonResponse
    {
        //CARGA DATOS
        $em = $this->doctrine->getManager();
        $publicacionesRepository = $em->getRepository(Publicaciones::class);
        $usuarioRepository = $em->getRepository(User::class);

        $idUser = $request->query->get("idUser");

        $user = $usuarioRepository->findOneBy(array("id" => $idUser));

        if ($user) {

            $listPublicaciones = $publicacionesRepository->buscarPorIdUser($idUser);

            $userDto = $convertersDTO->userToDTO($user);


            if ($listPublicaciones != null) {
                $listJson = array();

                foreach ($listPublicaciones as $publicacion) {
                    $publicacionDTO = $convertersDTO->publicacionDTO($publicacion);
                    $json = $utilidades->toJson($publicacionDTO, null);
                    $listJson[] = json_decode($json);
                }
            } else {
                return $this->json([
                    'user' => $userDto,
                ]);
            }
        } else {
            return new JsonResponse("{ mensaje: No se ha encontrado el usuario }", 200, [], true);
        }

        return $this->json([
            'user' => $userDto,
            'publicaciones' => $listJson
        ]);
    }

    #[Route('/editarPerfil', name: 'app_user_editarperfil', methods: ['PUT'])]
    #[OA\Tag(name: 'Perfil')]
    #[OA\RequestBody(description: "Dto de Perfil de User", content: new OA\JsonContent(ref: new Model(type: editarUserDTO::class)))]
    #[OA\Parameter(name: 'idUser', description: "Id del Usuario", in: "query", required: true, schema: new OA\Schema(type: "string"))]
    public function editarPerfil(Utilidades $utilidades, ConvertersDTO $convertersDTO, Request $request)
    {
        //CARGA DATOS
        $em = $this->doctrine->getManager();
        $usuarioRepository = $em->getRepository(User::class);

        $idUser = $request->query->get("idUser");

        $user = $usuarioRepository->findOneBy(array("id" => $idUser));

        if ($user) {
            $json = json_decode($request->getContent(), true);
            if ($json["username"] != null) {
                $username = $json["username"];
                $userRepo = $usuarioRepository->findOneBy(array("username" => $username));

                if ($userRepo == null) {
                    $user->setUsername($json["username"]);
                    if ($json["nombre"] == null) {
                        $user->setNombre($user->getNombre());

                    } elseif ($json["nombre"] != null) {
                        $user->setNombre($json["nombre"]);

                    } elseif ($json["apellidos"] == null) {
                        $user->setApellidos($user->getApellidos());

                    }elseif ($json["apellidos"]!=null){
                        $user->setApellidos($json["apellidos"]);

                    } elseif ($json["telefono"] == null) {
                        $user->setTelefono($user->getTelefono());

                    }elseif ($json["telefono"]!=null){
                        $user->setTelefono($json["telefono"]);

                    } elseif ($json["imagen"] == null) {
                        $user->setImagen($user->getImagen());

                    }elseif ($json["imagen"]!= null){
                        $user->setImagen($json["imagen"]);
                    } else {
                        return $this->json([
                            "error" => "este nombre de usuario ya existe",
                        ]);
                    }

                    $em->persist($user);
                    $em->flush();

                }else{
                    if ($json["nombre"] == null) {
                        $user->setNombre($user->getNombre());

                    } elseif ($json["nombre"] != null) {
                        $user->setNombre($json["nombre"]);

                    } elseif ($json["apellidos"] == null) {
                        $user->setApellidos($user->getApellidos());

                    }elseif ($json["apellidos"]!=null){
                        $user->setApellidos($json["apellidos"]);

                    } elseif ($json["telefono"] == null) {
                        $user->setTelefono($user->getTelefono());

                    }elseif ($json["telefono"]!=null){
                        $user->setTelefono($json["telefono"]);

                    } elseif ($json["imagen"] == null) {
                        $user->setImagen($user->getImagen());

                    }elseif ($json["imagen"]!= null){
                        $user->setImagen($json["imagen"]);
                    }if ($json["nombre"] == null) {
                        $user->setNombre($user->getNombre());

                    } elseif ($json["nombre"] != null) {
                        $user->setNombre($json["nombre"]);

                    } elseif ($json["apellidos"] == null) {
                        $user->setApellidos($user->getApellidos());

                    }elseif ($json["apellidos"]!=null){
                        $user->setApellidos($json["apellidos"]);

                    } elseif ($json["telefono"] == null) {
                        $user->setTelefono($user->getTelefono());

                    }elseif ($json["telefono"]!=null){
                        $user->setTelefono($json["telefono"]);

                    } elseif ($json["imagen"] == null) {
                        $user->setImagen($user->getImagen());

                    }elseif ($json["imagen"]!= null){
                        $user->setImagen($json["imagen"]);
                    }
                    $em->persist($user);
                    $em->flush();
                }

            }

        } else {
            return $this->json([
                "error" => "No se ha encontrado el usuario",
            ]);
        }
        return $this->json([
            "message" => "Perfil modificado con éxito",
        ]);
    }
}
