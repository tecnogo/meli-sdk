<?php

namespace Tecnogo\MeliSdk\Request\Exception;

use Throwable;

/**
 * Class InvalidTokenException
 *
 * @package Tecnogo\MeliSdk\Request\Exception
 */
final class InvalidTokenException extends \Exception implements RequestException
{
    public function __construct($message = 'Invalid access token.', int $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
