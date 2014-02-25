<?php

namespace Qafoo\Fixtures;

class Checkout
{
    private $priceLookup;

    private $display;

    private $scannedItems = array();

    private $sum = 0;

    public function __construct(PriceLookup $priceLookup, Display $display)
    {
        $this->priceLookup = $priceLookup;
        $this->display = $display;
    }

    public function scan(Item $item)
    {
        if (!isset($this->scannedItems[$item->getId()])) {
            $this->scannedItems[$item->getId()] = 0;
        }
        $this->scannedItems[$item->getId()]++;

        $this->sum += $this->priceLookup->getPrice($item);

        $this->display->update($this->sum);
    }

    public function getSum()
    {
        return $this->sum;
    }

    public function getScannedItems()
    {
        return $this->scannedItems;
    }
}
