<?php

namespace App\Controller;

use App\DTO\ConvertersDTO;
use App\Entity\User;
use App\Repository\AsociacionesRepository;
use App\Utilities\Utilidades;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class AsociacionController extends AbstractController
{
    #[Route('/asociacion', name: 'app_asociacion')]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/AsociacionController.php',
        ]);
    }

    #[Route('/asociacion/list', name: 'app_asociacion_listar', methods: ['GET'])]
    public function listarAsociaciones(AsociacionesRepository $asociacionesRepository, Utilidades $utilidades, ConvertersDTO $convertersDTO): JsonResponse
    {
        $listAsociaciones = $asociacionesRepository->findAll();

        $listJson = array();

        foreach ($listAsociaciones as $asociacion){
            $asociacionDTO = $convertersDTO->asociacionToDTO($asociacion);
            $json = $utilidades->toJson($asociacionDTO, null);
            $listJson[] = json_decode($json);
        }

        return new JsonResponse($listJson, 200,[],false);
    }
}
