<?php

namespace Tecnogo\MeliSdk\Request\Exception;

use Throwable;

/**
 * Class ForbiddenResourceException
 *
 * @package Tecnogo\MeliSdk\Request\Exception
 */
final class ForbiddenResourceException extends \Exception implements RequestException
{
    public function __construct($message = 'Forbidden resource,', int $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
