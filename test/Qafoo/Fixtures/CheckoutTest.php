<?php

namespace Qafoo\Fixtures;

class CheckoutTests extends \PHPUnit_Framework_TestCase
{
    public function testCalculatesSumForSingleArticle()
    {
        $priceLookupMock = $this->getMockBuilder('Qafoo\\Fixtures\\PriceLookup')
            ->disableOriginalConstructor()
            ->getMock();
        $priceLookupMock->expects($this->once())
            ->method('getPrice')
            ->with($this->isInstanceOf('Qafoo\\Fixtures\\Item'))
            ->will($this->returnValue(23.42));

        $displayMock = $this->getMockBuilder('Qafoo\\Fixtures\\Display')
            ->disableOriginalConstructor()
            ->getMock();
        $displayMock->expects($this->once())
            ->method('update')
            ->with(23.42);

        $checkout = new Checkout($priceLookupMock, $displayMock);

        $checkout->scan(new Item('AT-ST Walker'));

        $this->assertEquals(23.42, $checkout->getSum());
    }

    public function testCalculatesSumForMultipleArticles()
    {
        $priceLookupMock = $this->getMockBuilder('Qafoo\\Fixtures\\PriceLookup')
            ->disableOriginalConstructor()
            ->getMock();
        $priceLookupMock->expects($this->exactly(2))
            ->method('getPrice')
            ->with($this->isInstanceOf('Qafoo\\Fixtures\\Item'))
            ->will(
                $this->onConsecutiveCalls(23.42, 42.23)
            );

        $displayMock = $this->getMockBuilder('Qafoo\\Fixtures\\Display')
            ->disableOriginalConstructor()
            ->getMock();
        $displayMock->expects($this->at(0))
            ->method('update')
            ->with($this->equalTo(23.42));
        $displayMock->expects($this->at(1))
            ->method('update')
            ->with($this->equalTo(65.65));

        $checkout = new Checkout($priceLookupMock, $displayMock);

        $checkout->scan(new Item('AT-ST Walker'));
        $checkout->scan(new Item('Lightsaber (green)'));

        $this->assertEquals(65.65, $checkout->getSum());
    }
}
