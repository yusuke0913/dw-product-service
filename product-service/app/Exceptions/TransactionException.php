<?php

namespace App\Exceptions;

use Exception;

class TransactionException extends BaseException
{
    public function report()
    {
        \Log::error($this->getMessage());
        \Log::error($this->getTraceAsString());
    }

    protected function getErrorMessage()
    {
        return 'TRANSACTION_ERROR';
    }

    public function getStatusCode()
    {
        return 500;
    }
}
