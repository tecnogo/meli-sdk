<?php

namespace Tecnogo\MeliSdk\Test\Mock;


use Tecnogo\MeliSdk\Request\AbstractRequest;
use Tecnogo\MeliSdk\Request\Exception\BadRequestException;
use Tecnogo\MeliSdk\Request\Exception\ForbiddenResourceException;
use Tecnogo\MeliSdk\Request\Exception\InvalidTokenException;
use Tecnogo\MeliSdk\Request\Exception\MalformedJsonResponseException;
use Tecnogo\MeliSdk\Request\Exception\MissingAppIdException;
use Tecnogo\MeliSdk\Request\Exception\MissingAccessTokenException;
use Tecnogo\MeliSdk\Request\Exception\NotFoundException;
use Tecnogo\MeliSdk\Request\Exception\UnexpectedHttpResponseCodeException;
use Tecnogo\MeliSdk\Request\Method;

class FixedResultGetRequest extends AbstractRequest
{
    private $callback;
    /**
     * @return string
     * @see Method
     */
    public function getMethod()
    {
        return Method::GET;
    }

    /**
     * @return mixed
     * @throws InvalidTokenException
     * @throws MissingAppIdException
     * @throws MissingAccessTokenException
     * @throws NotFoundException
     * @throws ForbiddenResourceException
     * @throws UnexpectedHttpResponseCodeException
     * @throws BadRequestException
     * @throws MalformedJsonResponseException
     */
    public function exec()
    {
        $callable = $this->callback;

        if (!$callable || !is_callable($callable)) {
            throw new \InvalidArgumentException('Invalid callback');
        }

        return $callable();
    }

    public function setCallback($callback)
    {
        $this->callback = $callback;
    }
}
