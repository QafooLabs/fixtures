<?php

namespace Qafoo\Fixtures;

use org\bovigo\vfs\vfsStream;

class InvoiceLogTest extends \PHPUnit_Framework_TestCase
{
    private $invoiceLog;

    private $vfsRoot;

    public function setup()
    {
        $this->vfsRoot = vfsStream::setup('logDir');

        $this->invoiceLog = new InvoiceLog(vfsStream::url('logDir'));
    }

    public function testStore()
    {
        $this->invoiceLog->store(23, array('2 x AT-ST Walker'));

        $this->assertTrue(
            $this->vfsRoot->hasChild('23.log')
        );
    }

    public function testListInvoiceIds()
    {
        $globberMock = $this->getMockBuilder('Qafoo\\Fixtures\\Globber')
            ->disableOriginalConstructor()
            ->getMock();

        $globberMock->expects($this->any())
            ->method('glob')
            ->will(
                $this->returnValue(
                    array('23.log', '42.log')
                )
            );

        $this->invoiceLog->setGlobber($globberMock);

        $this->assertEquals(
            array(23, 42),
            $this->invoiceLog->listInvoiceIds()
        );
    }
}
