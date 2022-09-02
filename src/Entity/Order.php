<?php

namespace Recruitment\Entity;

use Recruitment\Cart\Item;

class Order
{
    /**
     * @var int
     */
    private $id;
    /**
     * @var Item[]
     */
    private $items;

    /**
     * @param int $id
     * @param Item[] $items
     */
    public function __construct(int $id, array $items)
    {
        $this->id = $id;
        $this->items = $items;
    }

    public function getDataForView(): array
    {
        $itemsArray = [];
        foreach ($this->items as $item) {
            $tax = 1 + ($item->getProduct()->getGross() / 100);
            $itemsArray[] = [
                'id' => $item->getProduct()->getId(),
                'quantity' => $item->getQuantity(),
                'total_price' => $item->getProduct()->getUnitPrice() * $item->getQuantity(),
                'gross' => $item->getProduct()->getGross() . '%',
                'grossPrice' => $item->getProduct()->getUnitPrice() * $tax,
                'getTotalPriceGross' => ($item->getQuantity() * $item->getProduct()->getUnitPrice()) * $tax,
            ];
        }
        return [
            'id' => $this->id,
            'items' => $itemsArray,
            'total_price' => $this->getTotalPrice(),
            'total_price_gross' => $this->getTotalPriceGross(),
        ];
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

    private function getTotalPrice(): float
    {
        $sum = 0;
        foreach ($this->items as $item) {
            $sum += $item->getQuantity() * $item->getProduct()->getUnitPrice();
        }
        return $sum;
    }
}
