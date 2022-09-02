<?php

namespace Recruitment\Entity\Exception;

use Exception;

class InvalidUnitPriceException extends Exception
{
    public function __construct()
    {
        parent::__construct("Product price must be greater than 0", 400);
    }
}
