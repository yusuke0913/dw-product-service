<?php

namespace App\Exceptions;

use Exception;

class InvalidParameterException extends BaseException
{
    protected function getErrorMessage()
    {
        return 'INVALID_PARAMETER';
    }

    public function getStatusCode()
    {
        return 500;
    }
}
