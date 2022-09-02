<?php

namespace Recruitment\Cart;

use OutOfBoundsException;
use Recruitment\Cart\Exception\QuantityTooLowException;
use Recruitment\Entity\Order;
use Recruitment\Entity\Product;
use Throwable;

class Cart
{
    /**
     * @var Item[]
     */
    private $items = [];

    /**
     * @throws QuantityTooLowException
     */
    public function addProduct(Product $product, int $quantity = 1): self
    {
        foreach ($this->items as $key => $item) {
            if ($product->getId() === $item->getProduct()->getId()) {
                $this->items[$key]->setQuantity($this->items[$key]->getQuantity() + $quantity);
                return $this;
            }
        }
        $this->items[] = new Item($product, $quantity);
        return $this;
    }

    public function removeProduct(Product $product): void
    {
        if ($product->getId() === null) {
            return;
        }
        foreach ($this->items as $key => $item) {
            if ($product->getId() === $item->getProduct()->getId()) {
                array_splice($this->items, $key, 1);
            }
        }
    }

    /**
     * @return Item[]
     */
    public function getItems(): array
    {
        return $this->items;
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

    /**
     * @throws QuantityTooLowException
     */
    public function setQuantity(Product $product, int $quantity): void
    {
        foreach ($this->items as $key => $item) {
            if ($product->getId() === $item->getProduct()->getId()) {
                $this->items[$key]->setQuantity($quantity);
                return;
            }
        }
        $this->addProduct($product, $quantity);
    }

    public function checkout(int $id): Order
    {
        $order = new Order($id, $this->items);
        $this->items = [];
        return $order;
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
