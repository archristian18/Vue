<?php

namespace App\Exceptions;

use Exception;

class InquiryNotFoundException extends Exception
{
    /** @var string */
    public $errorType = 'invalid_password';

    /**
     * InvalidUserPasswordException constructor.
     * @param string $message
     */
    public function __construct()
    {
        $message = __('exception.inquiry_is_empty');
        parent::__construct($message);
    }
}
