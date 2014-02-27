<?php

namespace Qafoo\Fixtures;

abstract class LocationService
{
    abstract public function lookupByAddress($address);
}
