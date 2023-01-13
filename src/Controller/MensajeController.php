<?php

namespace App\Controller;

use App\Repository\MensajeRepository;
use App\Utilities\Utilidades;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class MensajeController extends AbstractController
{
    #[Route('/mensaje', name: 'app_mensaje')]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/MensajeController.php',
        ]);
    }

    #[Route('/mensaje/list', name: 'app_mensaje')]
    public function listMensajes(MensajeRepository $mensajeRepository, Utilidades $utilidades): JsonResponse
    {
        //Obtenemos los datos
        $list_articulos = $mensajeRepository->findAll();

        //Transformar a Json
        $json = $utilidades->toJson($list_articulos);

        return new JsonResponse($json, 200, [], true);
    }

}
