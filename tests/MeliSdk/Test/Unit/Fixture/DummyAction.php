<?php

namespace Tecnogo\MeliSdk\Test\Unit\Fixture;

use Tecnogo\MeliSdk\Api\AbstractTemplateAction;
use Tecnogo\MeliSdk\Request\Method;

class DummyAction extends AbstractTemplateAction
{
    /**
     * @var array
     */
    private $payload;
    /**
     * @var string
     */
    private $resource;

    /**
     * @param string $resource
     * @param array $payload
     */
    public function __construct($resource = 'foo', array $payload = [])
    {
        $this->payload = $payload;
        $this->resource = $resource;
    }

    /**
     * @return string
     */
    public function getResource()
    {
        return $this->resource;
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        return Method::GET;
    }

    public function getPayload()
    {
        return $this->payload;
    }
}
