<?php

namespace App\Controller;

use App\DTO\ConvertersDTO;
use App\DTO\GuardarTagDTO;
use App\DTO\PublicacionSaveDTO;
use App\Entity\Publicaciones;
use App\Entity\Tags;
use App\Utilities\Utilidades;
use Doctrine\Persistence\ManagerRegistry;
use Nelmio\ApiDocBundle\Annotation\Model;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Attributes as OA;
use \Doctrine\ORM\EntityManager;


#[Route("/api/tags")]
class TagsController extends AbstractController
{

    public function __construct(private ManagerRegistry $doctrine)
    {
    }

    #[Route('/save', name: 'app_tags_savetag', methods: ['POST'])]
    #[OA\Tag(name: 'Tags')]
    #[OA\Parameter(name: 'idPub', description: "Id de la publicacion", in: "query", required: true, schema: new OA\Schema(type: "string") )]
    #[OA\RequestBody(description: "Dto de tags", content: new OA\JsonContent(ref: new Model(type: GuardarTagDTO::class)))]
    public function establecerTag(Request $request, Utilidades $utilidades){

        //CARGA DATOS
        $em = $this->doctrine->getManager();
        $tagRepository = $em->getRepository(Tags::class);
        $publicacionRepository = $em->getRepository(Publicaciones::class);

        $idPub = $request->query->get('idPub');

        //Busco la publicacion
        $publicacion = $publicacionRepository->findOneBy(array("id"=>$idPub));

        if($publicacion){

            //Obtener Json del body
            $json = json_decode($request->getContent(), true);

            $nombreTag = $json["nombre"];
            $tag = $tagRepository->findOneBy(array("nombre"=>$nombreTag));
            if($tag){
                $idTag = $tag->getId();
                $sql = "INSERT INTO tags_publicaciones (tags_id, publicaciones_id) VALUES ($idTag, $idPub)";
                $utilidades->exSQL($sql);


            }else{
                return $this->json([
                    'message' => "Esta etiqueta no existe",
                ]);
            }

        }else{
            return $this->json([
                'message' => "Esta publicacion no existe",
            ]);
        }
        return $this->json([
            'exito' => "Etiqueta asignada con éxito",
        ]);
    }

    #[Route('/listar', name: 'app_tags_listaretiquetas', methods: ['GET'])]
    #[OA\Tag(name: 'Tags')]
    public function listarEtiquetas(Utilidades $utilidades, ConvertersDTO $convertersDTO){

        //CARGA DATOS
        $em = $this->doctrine->getManager();
        $tagRepository = $em->getRepository(Tags::class);

        $listTags = $tagRepository->findAll();

        if($listTags){
            foreach ($listTags as $tag){
                $tagDTO = $convertersDTO->tagsToDTO($tag);
                $json = $utilidades->toJson($tagDTO, null);
                $listJson[] = json_decode($json);
            }
        }else{
            return $this->json([
                'error' => 'No hay tags disponibles',
            ]);
        }
        return $this->json($listJson);
    }
}
