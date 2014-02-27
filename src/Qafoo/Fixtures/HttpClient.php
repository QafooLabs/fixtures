<?php

namespace Qafoo\Fixtures;

abstract class HttpClient
{
    abstract public function get($url);
}
