<?php

namespace App\Exceptions;

use Exception;

class OrderListNotFoundException extends Exception
{
    /** @var string */
    public $errorType = 'exception.create_order_list_not_found';

    /**
     * CustomerOrderNotFoundException constructor.
     * @param string $message
     */
    public function __construct()
    {
        $message = __('exception.create_order_list_not_found');
        parent::__construct($message);
    }
}
