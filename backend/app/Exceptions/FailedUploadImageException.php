<?php

namespace App\Exceptions;

use Exception;

class FailedUploadImageException extends Exception
{
    protected $message = 'Failed upload image';
}
