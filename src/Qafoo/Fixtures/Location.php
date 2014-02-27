<?php

namespace Qafoo\Fixtures;

class Location
{
    public $longitude;

    public $latitude;

    public function __construct($longitude, $latitude)
    {
        $this->longitude = $longitude;
        $this->latitude = $latitude;
    }
}
