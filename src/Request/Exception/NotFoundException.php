<?php

namespace Tecnogo\MeliSdk\Request\Exception;


use Throwable;

final class NotFoundException extends \Exception implements RequestException
{
    public function __construct($message = 'Not found.', int $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}