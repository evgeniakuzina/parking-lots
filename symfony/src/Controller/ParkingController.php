<?php

declare (strict_types=1);

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ParkingController 
{
    /**
     * @Route("api/v1/car/access", methods={"POST"})
     */
    public function getAccess(Request $request): JsonResponse
    {
        return new JsonResponse(['has_access' => true], JsonResponse::HTTP_OK);
    }
}