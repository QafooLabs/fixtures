<?php

namespace Qafoo\Fixtures;

class SimpleHttpClient extends HttpClient
{
    public function get($url)
    {
        return file_get_contents($url);
    }
}
