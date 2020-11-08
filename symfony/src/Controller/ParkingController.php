<?php

declare (strict_types=1);

namespace App\Controller;

use App\Entity\ParkingLot;
use App\Repository\ParkingLotRepository;
use App\Service\Validator;
use DateTime;
use ParkingLotValidation;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ParkingController extends AbstractController
{
    protected $repository;
    protected $validator;

    public function __construct(ParkingLotRepository $repository, Validator $validator)
    {
        $this->repository = $repository;
        $this->validator = $validator;
    }

    /**
     * @Route("api/v1/car/access/{type}", methods={"POST"})
     */
    public function getAccess(Request $request, string $type): JsonResponse
    {
        $parkingLotValidation = new ParkingLotValidation($type, $request);
        $errors = $this->validator->validate($parkingLotValidation);
        
        if (!empty($errors)) {
            return new JsonResponse(['errors' => $errors], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }

        $vehicleNumber = $parkingLotValidation->getVehicleNumber();

        if ($parkingLotValidation->isTypeIn()) {
            if ($this->repository->canGetIn($vehicleNumber)) {
                $parkingLot = new ParkingLot();
                $parkingLot->setVehicleNumber($vehicleNumber);
                $parkingLot->setTimeIn(new DateTime());
            } else {
                return new JsonResponse(['is_allowed' => false], JsonResponse::HTTP_OK);
            }
        } else {
            if ($this->repository->canGetOut($vehicleNumber)) {
                $parkingLot = $this->repository->findByVehicleNumber($vehicleNumber);
                $parkingLot->setTimeOut((new DateTime()));
            } else {
                return new JsonResponse(['is_allowed' => false], JsonResponse::HTTP_OK);
            }
        }
        
        $errors = $this->validator->validate($parkingLot);

        if (!empty($errors)) {
            return new JsonResponse(['errors' => $errors], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }
        
        $this->repository->save($parkingLot);       
        
        return new JsonResponse(['is_allowed' => true], JsonResponse::HTTP_OK);
    }
}