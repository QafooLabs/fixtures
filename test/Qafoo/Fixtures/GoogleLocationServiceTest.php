<?php

namespace Qafoo\Fixtures;

class GoogleLocationServiceTest extends \PHPUnit_Framework_TestCase
{
    private $httpClient;

    private $lookupService;

    public function setUp()
    {
        $this->httpClient = $this->createHttpClient();
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

    protected function createHttpClient()
    {
        switch($this->getTestMode()) {
            case 'play':
                return $this->createHttpClientMock();
                break;

            case 'record':
                return new SpyingHttpClient(new SimpleHttpClient());
                break;

            case 'production':
                return new SimpleHttpClient();
                break;

            default:
                throw new \RuntimeException('Unknown RECORD_PLAY_MODE.');
        }
    }

    protected function createHttpClientMock()
    {
        $httpClientMock = $this->getMockBuilder('Qafoo\\Fixtures\\HttpClient')
            ->disableOriginalConstructor()
            ->getMock();

        $httpClientMock->expects($this->any())
            ->method('get')
            ->will(
                $this->returnValue(
                    $this->loadFixture()
                )
            );

        return $httpClientMock;
    }

    protected function tearDown()
    {
        if ($this->getTestMode() === 'record') {
            file_put_contents(
                $this->getFixtureFile(),
                $this->httpClient->getLastResponse()
            );
        }
    }

    protected function getTestMode()
    {
        if (getenv('RECORD_PLAY_MODE')) {
            return getenv('RECORD_PLAY_MODE');
        }
        return 'play';
    }

    protected function loadFixture()
    {
        return file_get_contents(
            $this->getFixtureFile()
        );
    }

    protected function storeFixture($fixture)
    {
        file_put_contents(
            $this->getFixtureFile(),
            $fixture
        );
    }

    protected function getFixtureFile()
    {
        // $this->getName() = name of currently running test
        return __DIR__ . '/_fixtures/' . $this->getName() . '.txt';
    }
}
