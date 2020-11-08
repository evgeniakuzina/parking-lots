<?php

declare (strict_types=1);

namespace App\Service;

use Psr\Log\LoggerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class Validator 
{
    protected $validator;
    protected $logger;

    public function __construct(ValidatorInterface $validator, LoggerInterface $logger)
    {
        $this->validator = $validator;
        $this->logger = $logger;
    }

    public function validate($class): string
    {
        $errors = $this->validator->validate($class);

        return (string)$errors;
    }
}