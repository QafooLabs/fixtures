<?php

namespace Qafoo\Fixtures;

abstract class PriceLookup
{
    abstract public function getPrice(Item $item);
}
