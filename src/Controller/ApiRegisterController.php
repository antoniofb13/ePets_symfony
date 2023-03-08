<?php

namespace App\Controller;

use App\DTO\AsociacionDTO;
use App\DTO\SaveAsociacionDTO;
use App\DTO\saveUserDTO;
use App\DTO\UserDto;
use App\Entity\ApiKey;
use App\Entity\Asociaciones;
use App\Entity\Rol;
use App\Entity\User;
use App\Repository\RolRepository;
use App\Utilities\Utilidades;
use ReallySimpleJWT\Token;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;
use function Symfony\Component\VarDumper\Dumper\esc;


class ApiRegisterController extends AbstractController
{

    public function __construct(private ManagerRegistry $doctrine)
    {
    }

    #[Route('/register', name: 'app_api_register')]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/ApiRegisterController.php',
        ]);
    }

    #[Route('api/usuario/save', name: 'app_usuario_crear', methods: ['POST'])]
    #[OA\Tag(name: 'Registro')]
    #[OA\RequestBody(description: "Dto de Registro", content: new OA\JsonContent(ref: new Model(type: saveUserDTO::class)))]
    #[OA\Response(response: 200, description: "Usuario creado correctamente")]
    #[OA\Response(response: 101, description: "No ha indicado usario y contraseña")]
    public function save(ManagerRegistry $managerRegistry, Request $request, Utilidades $utilidades): JsonResponse
    {
        //CARGA DATOS
        $em = $this->doctrine->getManager();
        $userRepository = $em->getRepository(User::class);
        $rolRepository = $em->getRepository(Rol::class);
        $apiKeyRepository = $em->getRepository(ApiKey::class);

        //Obtener Json del body
        $json = json_decode($request->getContent(), true);

        //CREAR NUEVO USUARIO A PARTIR DEL JSON
        $usuarioNuevo = new User();
        $usuarioNuevo->setEmail($json['email']);
        $usuarioNuevo->setPassword($utilidades->hashPassword($json['password']));
        $usuarioNuevo->setNombre($json['nombre']);
        $usuarioNuevo->setApellidos($json['apellidos']);
        $usuarioNuevo->setUsername($json['username']);
        $usuarioNuevo->setTelefono($json['telefono']);
        $usuarioNuevo->setProtectora(false);
        $imagen = $json['imagen'];
        if ($imagen == null or $imagen == "string") {
            $usuarioNuevo->setImagen("https://th.bing.com/th/id/R.6b0022312d41080436c52da571d5c697?rik=ejx13G9ZroRrcg&riu=http%3a%2f%2fpluspng.com%2fimg-png%2fuser-png-icon-young-user-icon-2400.png&ehk=NNF6zZUBr0n5i%2fx0Bh3AMRDRDrzslPXB0ANabkkPyv0%3d&risl=&pid=ImgRaw&r=0");
        } else {
            $usuarioNuevo->setImagen($json['imagen']);
        }
        $rolname = $json['rol'];
        if ($rolname == null) {
            $roluser = $rolRepository->find(1);
            $usuarioNuevo->setIdRol($roluser);
        }
        $usuarioNuevo->setIdRol($managerRegistry->getRepository(Rol::class)->findOneBy(array("tipo" => $rolname)));

        //GUARDAR
        $userRepository->save($usuarioNuevo, true);

        //GENERAR TOKEN
        $utilidades->generateApiToken($usuarioNuevo, $apiKeyRepository);


        return $this->json([
            'message' => "Usuario creado correctamente",
        ]);
    }

    #[Route('api/usuario/saveProtectora', name: 'app_apiregister_saveprotectora', methods: ['POST'])]
    #[OA\Tag(name: 'Registro')]
    #[OA\RequestBody(description: "Dto de Registro de Protectora", content: new OA\JsonContent(ref: new Model(type: SaveAsociacionDTO::class)))]
    public function saveProtectora(Request $request, Utilidades $utilidades)
    {

        //CARGA DATOS
        $em = $this->doctrine->getManager();
        $userRepository = $em->getRepository(User::class);
        $asociacionRepository = $em->getRepository(Asociaciones::class);

        //Obtener Json del body
        $json = json_decode($request->getContent(), true);

        //Obtener token de header
        $token = $request->headers->get('token');
        $valido = $utilidades->esApiKeyValida($token, null);

        if (!$valido) {
            return $this->json([
                "prohibido" => "no tiene permisos para acceder a este sitio"
            ]);
        } else {
            //CREO UNA NUEVA ASOCIACION
            $asociacionNueva = new Asociaciones();

            //BUSCAMOS EL USUARIO QUE VA A CREAR LA NUEVA ASOCIACION
            $idUsuario = Token::getPayload($token)['user_id'];
            $user = $userRepository->findOneBy(array("id" => $idUsuario));
            if ($user) {
                $user->setProtectora(1);
                //COMPLETAMOS DATOS DE LA ASOCIACION A TRAVES DEL JSON
                $asociacionNueva->setUser($user);
                $asociacionNueva->setDireccion($json["direccion"]);
                $asociacionNueva->setCapacidad($json["capacidad"]);
                $logo = $json['logo'];
                if ($logo == null or $logo == "string") {
                    $asociacionNueva->setLogo("https://cdn.domestika.org/c_limit,dpr_auto,f_auto,q_auto,w_820/v1478201084/content-items/001/761/909/Captura_de_pantalla_2016-10-30_a_las_12.17.35-original.png?1478201084");
                } else {
                    $asociacionNueva->setLogo($json['logo']);
                }
                //GUARDAR
                $asociacionRepository->save($asociacionNueva, true);

                return $this->json([
                    "message" => "asociacion creada correctamente"
                ]);
            } else {
                return $this->json([
                    "error" => "usuario asociado a la protectora no encontrado"
                ]);
            }
        }
    }
}
