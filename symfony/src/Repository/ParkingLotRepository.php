<?php

namespace App\Repository;

use App\Entity\ParkingLot;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Throwable;

class ParkingLotRepository extends ServiceEntityRepository
{
    protected const CAPACITY = 500;

    protected $entityManager;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ParkingLot::class);

        $this->entityManager = $this->getEntityManager();
    }

    public function getAllOccupied(): int 
    {
        $query = $this->entityManager->createQuery(
            'SELECT count(pl.id)
            FROM App\Entity\ParkingLot pl
            WHERE pl.timeOut is null
            '
        );

        return $query->getSingleScalarResult();
    }

    public function canGetIn(string $vehicleNumber): bool
    {
        $total = (int)$this->entityManager->createQuery(
            'SELECT count(pl.id)
            FROM App\Entity\ParkingLot pl
            WHERE pl.vehicleNumber = :vehicleNumber
            AND pl.timeOut is null
            '
        )
            ->setParameter('vehicleNumber', $vehicleNumber)
            ->getSingleScalarResult();

        return $total === 0 && $this->hasFreeLots();
    }

    public function canGetOut(string $vehicleNumber): bool
    {
        $total = (int)$this->entityManager->createQuery(
            'SELECT count(pl.id)
            FROM App\Entity\ParkingLot pl
            WHERE pl.vehicleNumber = :vehicleNumber
            AND pl.timeOut is null
            '
        )
            ->setParameter('vehicleNumber', $vehicleNumber)
            ->getSingleScalarResult();

        return $total !== 0;
    }

    public function save(ParkingLot $parkingLot): void
    {
        $this->entityManager->persist($parkingLot);
        $this->entityManager->flush();
    }

    /**
     * @return ParkingLot
     */
    public function findByVehicleNumber(string $vehicleNumber): ParkingLot
    {
        $parkingLot = $this->findOneBy([
            'vehicleNumber' => $vehicleNumber,
            'timeOut' => null,
        ]);
        
        return $parkingLot;
    }

    /**
     * @return ParkingLot[]
     */
    public function getAll(): array
    {
        $qb = $this->createQueryBuilder('pl')
                ->orderBy('pl.timeIn');
        
        return $qb->getQuery()->execute();
    }

    private function hasFreeLots(): bool
    {
        $total = $this->entityManager->createQuery(
            'SELECT count(pl.id)
            FROM App\Entity\ParkingLot pl
            WHERE pl.timeOut is null
            '
        )->getSingleScalarResult();

        return $total <= self::CAPACITY;
    }
}