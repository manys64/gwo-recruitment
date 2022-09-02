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
            $itemsArray[] = [
                'id' => $item->getProduct()->getId(),
                'quantity' => $item->getQuantity(),
                'total_price' => $item->getProduct()->getUnitPrice() * $item->getQuantity(),
                'gross' => $item->getProduct()->getGross() . '%',
                'grossPrice' => $item->getProduct()->getUnitPrice()
                    + ($item->getProduct()->getUnitPrice() * $item->getProduct()->getGross()),
                'getTotalPriceGross' => $this->getTotalPriceGross(),
            ];
        }
        return [
            'id' => $this->id,
            'items' => $itemsArray,
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
}