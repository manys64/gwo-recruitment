<?php

namespace Recruitment\Cart\Exception;

use Exception;
use Throwable;

class QuantityTooLowException extends Exception
{
    public function __construct(int $quantity)
    {
        parent::__construct("The entered quantity [$quantity] is too low", 400);
    }
}
