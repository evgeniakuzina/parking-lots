<?php

declare (strict_types=1);

namespace App\Controller;

use App\Repository\ParkingLotRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class OperatorController extends AbstractController
{
    protected $repository;

    public function __construct(ParkingLotRepository $repository)
    {
        $this->repository = $repository;
    }
    /**
     * @Route("operator/lots", methods={"GET"}, name="occupied.lots")
     */
    public function getOccupiedLots()
    {
        $totalOccupied = $this->repository->getAllOccupied();

        return $this->render('total-occupied.html.twig', [
            'total_occupied' => $totalOccupied,
        ]);
    }

    /**
     * @Route("operator/history", methods={"GET"}, name="parking.history")
     */
    public function history()
    {
        return $this->render('history.html.twig',[
            'history' => $this->repository->getAll(),
        ]);
    }
}