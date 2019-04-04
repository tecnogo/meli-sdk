<?php

namespace Tecnogo\MeliSdk\Request\Exception;

use Throwable;

/**
 * Class MissingTokenException
 *
 * @package Tecnogo\MeliSdk\Request\Exception
 */
final class MissingAccessTokenException extends \Exception implements RequestException
{
    public function __construct($message = 'Missing access token', int $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}