<?php

namespace Qafoo\Fixtures;

class GoogleLocationService extends LocationService
{
    const URL_TEMPLATE = 'https://maps.googleapis.com/maps/api/geocode/json?sensor=false&address=%s';

    private $httpClient;

    public function __construct(HttpClient $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    public function lookupByAddress($address)
    {
        $json = $this->httpClient->get(
            sprintf(self::URL_TEMPLATE, urlencode($address))
        );
        $response = json_decode($json, true);

        return new Location(
            (float) $response['results'][0]['geometry']['location']['lng'],
            (float) $response['results'][0]['geometry']['location']['lat']
        );
    }
}
