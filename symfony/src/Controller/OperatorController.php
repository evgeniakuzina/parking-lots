<?php

declare (strict_types=1);

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class OperatorController 
{
    /**
     * @Route("api/v1/operator/lots", methods={"GET"})
     */
    public function getOccupiedLots(): JsonResponse
    {
        return new JsonResponse(['total_occupied' => 1], JsonResponse::HTTP_OK);
    }

    /**
     * @Route("api/v1/operator/history", methods={"GET"})
     */
    public function history(): JsonResponse
    {
        return new JsonResponse(['history' => 'history'], JsonResponse::HTTP_OK);
    }
}