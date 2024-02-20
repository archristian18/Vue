<?php

namespace App\Exceptions;

use Exception;

class MenuNotFoundException extends Exception
{
    /** @var string */
    public $errorType = 'menu_not_found';

    /**
     * CustomerOrderNotFoundException constructor.
     * @param string $message
     */
    public function __construct()
    {
        $message = 'Unable to retrieve menu';
        parent::__construct($message);
    }
}
