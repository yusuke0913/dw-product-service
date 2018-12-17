<?php

namespace App\Exceptions;

use Exception;

class BaseException extends Exception
{
    protected function getErrorMessage()
    {
    }

    public function report()
    {
    }

    public function render($request)
    {
        return \Response::json(
            [
                'error' => true,
                'errorMessage' => $this->getErrorMessage(),
            ],
            $this->getStatusCode()
        );
    }
}
