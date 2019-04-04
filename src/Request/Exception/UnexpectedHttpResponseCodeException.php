<?php

namespace Tecnogo\MeliSdk\Request\Exception;

use Throwable;

/**
 * Class UnexpectedHttpResponseCodeException
 *
 * @package Tecnogo\MeliSdk\Request\Exception
 */
final class UnexpectedHttpResponseCodeException extends \Exception implements RequestException
{
    public function __construct($message = 'Unexpected HTTP code response', int $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
