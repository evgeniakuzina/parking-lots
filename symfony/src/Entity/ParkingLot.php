<?php

declare (strict_types=1);

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Index;

/**
 * @ORM\Entity
 * @ORM\Table("parking_lots", indexes={@Index(name="vehicle_number_idx", columns={"vehicle_number"})})
 */
class ParkingLot 
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=15)
     */
    private $vehicleNumber;

    /**
     * @ORM\Column(type="datetime")
     * 
     * @Assert\NotNull
     * @var string A "Y-m-d H:i:s" formatted value
     */
    private $timeIn;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * 
     * @var string A "Y-m-d H:i:s" formatted value
     */
    private $timeOut;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getVehicleNumber(): ?string
    {
        return $this->vehicleNumber;
    }

    public function setVehicleNumber(string $vehicleNumber): self
    {
        $this->vehicleNumber = $vehicleNumber;

        return $this;
    }

    public function getTimeIn(): ?\DateTimeInterface
    {
        return $this->timeIn;
    }

    public function setTimeIn(\DateTimeInterface $timeIn): self
    {
        $this->timeIn = $timeIn;

        return $this;
    }

    public function getTimeOut(): ?\DateTimeInterface
    {
        return $this->timeOut;
    }

    public function setTimeOut(?\DateTimeInterface $timeOut): self
    {
        $this->timeOut = $timeOut;

        return $this;
    }
}