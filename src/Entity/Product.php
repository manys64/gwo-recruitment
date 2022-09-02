<?php

namespace Recruitment\Entity;

use InvalidArgumentException;
use Recruitment\Entity\Exception\InvalidUnitPriceException;

class Product
{
    private $id;
    private $name;
    private $unitPrice;
    private $minimumQuantity;
    private $gross = 0;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getUnitPrice(): float
    {
        return $this->unitPrice;
    }

    /**
     * @throws InvalidUnitPriceException
     */
    public function setUnitPrice(float $unitPrice): self
    {
        if ($unitPrice <= 0) {
            throw new InvalidUnitPriceException;
        }
        $this->unitPrice = $unitPrice;
        return $this;
    }

    public function getMinimumQuantity(): int
    {
        return $this->minimumQuantity;
    }

    public function setMinimumQuantity(int $minimumQuantity): self
    {
        if ($minimumQuantity <= 0) {
            throw new InvalidArgumentException;
        }
        $this->minimumQuantity = $minimumQuantity;
        return $this;
    }

    public function getGross(): int
    {
        return $this->gross;
    }

    public function setGross(int $gross): self
    {
        $this->gross = $gross;
        return $this;
    }
}