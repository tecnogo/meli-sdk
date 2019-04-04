<?php

namespace Tecnogo\MeliSdk\Request\Exception;

use Throwable;

/**
 * Class MalformedJsonResponseException
 *
 * @package MeliSdk\Request\Exception
 */
final class MalformedJsonResponseException extends \Exception implements RequestException
{
    public function __construct($message = 'Malformed JSON response', int $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}