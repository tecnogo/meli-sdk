<?php

namespace Tecnogo\MeliSdk\Request\Exception;

use Throwable;

/**
 * Class UnknownHttpMethodException
 *
 * @package Tecnogo\MeliSdk\Request\Exception
 */
final class UnknownHttpMethodException extends \Exception implements RequestException
{
    public function __construct($message = 'Unknown HTTP method', int $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}