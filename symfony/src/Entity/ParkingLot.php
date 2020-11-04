<?php

declare (strict_types=1);

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table("parking_lots")
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
     * 
     * @Assert\NotNull
     * @Assert\Length(
     *      min = 5,
     *      max = 10,
     *      allowEmptyString = false
     * )
     */
    private $vehicleNumber;

    /**
     * @ORM\Column(type="datetime")
     * 
     * @Assert\NotNull
     * @Assert\DateTime
     * @var string A "Y-m-d H:i:s" formatted value
     */
    private $timeIn;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * 
     * @Assert\DateTime
     * @var string A "Y-m-d H:i:s" formatted value
     */
    private $timeOut;
}