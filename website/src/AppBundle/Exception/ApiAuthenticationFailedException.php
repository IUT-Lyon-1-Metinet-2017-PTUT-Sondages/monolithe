<?php

namespace AppBundle\Exception;

use Exception;

/**
 * Class ApiAuthenticationFailedException
 * @package AppBundle\Exception
 */
class ApiAuthenticationFailedException extends \Exception
{
    public function __construct($message = "", $code = 403, Exception $previous = null)
    {
        parent::__construct('Api token could not be found or was wrong.', $code, $previous);
    }
}