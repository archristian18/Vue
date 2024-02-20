<?php

namespace App\Exceptions;

use Exception;

class CustomerOrderNotFoundException extends Exception
{
    /** @var string */
    public $errorType = 'exception.create_customer_order_not_found';

    /**
     * CustomerOrderNotFoundException constructor.
     * @param string $message
     */
    public function __construct()
    {
        $message = __('exception.create_customer_order_not_found');
        parent::__construct($message);
    }
}
