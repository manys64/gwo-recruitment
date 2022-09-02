<?php

namespace Recruitment\Cart;

use OutOfBoundsException;
use Recruitment\Entity\Order;
use Recruitment\Entity\Product;
use Throwable;

class Cart
{
    /**
     * @var Item[]
     */
    private $items = [];
    
    public function addProduct(Product $product, int $quantity = 1): self
    {
        $key = array_search($product, $this->items, true);
        if ($key !== false) {
            $this->items[$key]->setQuantity($this->items[$key]->getQuantity() + $quantity);
            return $this;
        }
        $this->items[] = new Item($product, $quantity);;
        return $this;
    }

    public function removeProduct(Product $product): void
    {
        $key = array_search($product, $this->items, true);
        if($key !== FALSE) {
            unset($this->items[$key]);
        }
    }

    public function getItems(): int
    {
        return count($this->items);
    }

    public function getItem(int $index): Item
    {
        try {
            return $this->items[$index];
        } catch (Throwable $ex) {
            throw new OutOfBoundsException;
        }
    }

    public function getTotalPrice(): float
    {
        $sum = 0;
        foreach ($this->items as $item) {
            $sum += $item->getQuantity() * $item->getProduct()->getUnitPrice();
        }
        return $sum;
    }

    public function setQuantity(Product $product, int $quantity): void
    {
        $this->addProduct($product, $quantity);
    }

    public function checkout(int $id): Order
    {
        return new Order($id, $this->items);
    }

    public function getTotalPriceGross()
    {
        $sum = 0;
        foreach ($this->items as $item) {
            $tax = 1 + ($item->getProduct()->getGross() / 100);
            $sum += ($item->getQuantity() * $item->getProduct()->getUnitPrice()) * $tax;
        }
        return $sum;
    }
}