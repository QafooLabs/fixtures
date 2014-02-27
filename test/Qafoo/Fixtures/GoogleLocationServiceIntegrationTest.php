<?php

namespace Qafoo\Fixtures;

class GoogleLocationServiceTest extends \PHPUnit_Framework_TestCase
{
    private $httpClient;

    private $lookupService;

    public function setUp()
    {
        $this->httpClient = new SimpleHttpClient();
        $this->lookupService = new GoogleLocationService($this->httpClient);
    }

    public function testLookupAddressByZip()
    {
        $actualLocation = $this->lookupService->lookupByAddress('45886 Gelsenkirchen');

        $this->assertEquals(
            new Location(
                7.1215271,
                51.4964248
            ),
            $actualLocation
        );
    }
}
