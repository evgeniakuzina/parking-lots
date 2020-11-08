<?php

declare (strict_types=1);

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;

class ParkingLotValidation 
{
    /**
     * @Assert\Choice(
     *      choices = { "in", "out"},
     *      message = "Choose a valid accessType: in or out"
     * )
     */
    private $accessType;

    /**
     * @Assert\NotNull
     * @Assert\Length(
     *      min = 5,
     *      max = 15
     * )
     */
    private $vehicleNumber;

    public function __construct($accessType, Request $request)
    {
        $this->accessType = $accessType;

        $request = json_decode($request->getContent(), true);
        $vehicleNumber = isset($request['vehicle_number']) ? $request['vehicle_number'] : null;
        $this->vehicleNumber = $vehicleNumber;
    }

    public function getAccessType()
    {
        return $this->accessType;
    }

    public function getVehicleNumber()
    {
        return $this->vehicleNumber;
    }

    public function isTypeIn(): bool 
    {
        return $this->accessType === 'in';
    }
}