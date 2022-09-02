<?php

namespace Recruitment\Cart;

use InvalidArgumentException;
use Recruitment\Cart\Exception\QuantityTooLowException;
use Recruitment\Entity\Product;

class Item
{
    private $product;
    private $quantity;

    public function __construct(Product $product, int $quantity)
    {
        if ($product->getMinimumQuantity() > $quantity) {
            throw new InvalidArgumentException;
        }
        $this->product = $product;
        $this->quantity = $quantity;
    }

    public function getProduct(): Product
    {
        return $this->product;
    }

    public function setProduct(Product $product): self
    {
        $this->product = $product;
        return $this;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    /**
     * @throws QuantityTooLowException
     */
    public function setQuantity(int $quantity): self
    {
        if ($this->product->getMinimumQuantity() > $quantity) {
            throw new QuantityTooLowException($quantity);
        }
        $this->quantity = $quantity;
        return $this;
    }

    public function getTotalPrice()
    {
        return $this->product->getUnitPrice() * $this->quantity;
    }
}
