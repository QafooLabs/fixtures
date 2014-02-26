<?php

namespace Qafoo\Fixtures;

class InvoiceLog
{
    private $logDirectory;

    private $globber;

    public function __construct($logDirectory)
    {
        $this->logDirectory = $logDirectory;

        $this->globber = new Globber();
    }

    public function store($invoiceId, array $log)
    {
        file_put_contents(
            $this->logDirectory . '/' . $invoiceId . '.log',
            implode("\n", $log)
        );
    }

    public function listInvoiceIds()
    {
        $logFiles = $this->globber->glob(
            $this->logDirectory . '/*.log'
        );
        $invoiceIds = array();
        foreach ($logFiles as $logFile) {
            $invoiceIds[] = basename($logFile, '.log');
        }
        return $invoiceIds;
    }

    public function setGlobber(Globber $globber)
    {
        $this->globber = $globber;
    }
}
