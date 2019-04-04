<?php

namespace Tecnogo\MeliSdk\Request\Exception;

use Throwable;

/**
 * Class BadRequestException
 *
 * @package Tecnogo\MeliSdk\Request\Exception
 */
final class BadRequestException extends \Exception implements RequestException
{
    public function __construct(string $message = 'Bad request.', int $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
