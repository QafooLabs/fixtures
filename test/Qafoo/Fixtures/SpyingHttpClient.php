<?php

namespace Qafoo\Fixtures;

class SpyingHttpClient extends HttpClient
{
    private $innerHttpClient;

    private $lastResponse;

    public function __construct(HttpClient $innerHttpClient)
    {
        $this->innerHttpClient = $innerHttpClient;
    }

    public function get($url)
    {
        $this->lastResponse = $this->innerHttpClient->get($url);
        return $this->lastResponse;
    }

    public function getLastResponse()
    {
        return $this->lastResponse;
    }
}
