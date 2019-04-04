<?php

namespace Tecnogo\MeliSdk\Test\Resource\Category;

use Tecnogo\MeliSdk\Client;
use Tecnogo\MeliSdk\Test\Resource\AbstractResourceTest;

class CategoriesTest extends AbstractResourceTest
{
    /**
     * @param Client $client
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \Tecnogo\MeliSdk\Exception\ContainerException
     * @throws \Tecnogo\MeliSdk\Exception\MissingConfigurationException
     * @throws \Tecnogo\MeliSdk\Request\Exception\BadRequestException
     * @throws \Tecnogo\MeliSdk\Request\Exception\ForbiddenResourceException
     * @throws \Tecnogo\MeliSdk\Request\Exception\InvalidTokenException
     * @throws \Tecnogo\MeliSdk\Request\Exception\NotFoundException
     * @throws \Tecnogo\MeliSdk\Request\Exception\UnexpectedHttpResponseCodeException
     * @throws \Tecnogo\MeliSdk\Request\Exception\UnknownHttpMethodException
     */
    protected function triggerRequestForErrorResponses(Client $client)
    {
        $client->categories();
    }
}