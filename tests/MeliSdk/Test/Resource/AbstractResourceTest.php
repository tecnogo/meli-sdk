<?php

namespace Tecnogo\MeliSdk\Test\Resource;

use PHPUnit\Framework\TestCase;
use Tecnogo\MeliSdk\Client;
use Tecnogo\MeliSdk\Request\Exception\BadRequestException;
use Tecnogo\MeliSdk\Request\Exception\ForbiddenResourceException;
use Tecnogo\MeliSdk\Request\Exception\InvalidTokenException;
use Tecnogo\MeliSdk\Request\Exception\MalformedJsonResponseException;
use Tecnogo\MeliSdk\Request\Exception\NotFoundException;
use Tecnogo\MeliSdk\Request\Exception\UnexpectedHttpResponseCodeException;
use Tecnogo\MeliSdk\Request\Get;
use Tecnogo\MeliSdk\Test\Mock\FixedResultGetRequest;

abstract class AbstractResourceTest extends TestCase
{
    use CreateFixedResponseGetRequest;

    abstract protected function triggerRequestForErrorResponses(Client $client);

    /**
     * @throws \Tecnogo\MeliSdk\Exception\ContainerException
     * @throws \Tecnogo\MeliSdk\Exception\MissingConfigurationException
     * @throws \Tecnogo\MeliSdk\Site\Exception\InvalidSiteIdException
     */
    public function testMalformedJsonResponse()
    {
        $client = $this->getClientWithFixedGetResponse(200, 'not_json!{');

        $this->expectException(MalformedJsonResponseException::class);
        $this->triggerRequestForErrorResponses($client);
    }

    /**
     * @throws \Tecnogo\MeliSdk\Exception\ContainerException
     * @throws \Tecnogo\MeliSdk\Exception\MissingConfigurationException
     * @throws \Tecnogo\MeliSdk\Site\Exception\InvalidSiteIdException
     */
    public function testNotFoundResponse()
    {
        $client = $this->getClientWithFixedGetResponse(404, '');

        $this->expectException(NotFoundException::class);
        $this->triggerRequestForErrorResponses($client);
    }

    /**
     * @throws \Tecnogo\MeliSdk\Exception\ContainerException
     * @throws \Tecnogo\MeliSdk\Exception\MissingConfigurationException
     * @throws \Tecnogo\MeliSdk\Site\Exception\InvalidSiteIdException
     */
    public function testServerErrorResponse()
    {
        $client = $this->getClientWithFixedGetResponse(500, '');

        $this->expectException(UnexpectedHttpResponseCodeException::class);
        $this->triggerRequestForErrorResponses($client);
    }

    /**
     * @throws \Tecnogo\MeliSdk\Exception\ContainerException
     * @throws \Tecnogo\MeliSdk\Exception\MissingConfigurationException
     * @throws \Tecnogo\MeliSdk\Site\Exception\InvalidSiteIdException
     */
    public function testNonHandledHttpCodeResponse()
    {
        $client = $this->getClientWithFixedGetResponse('wubba dubba lub', '');

        $this->expectException(UnexpectedHttpResponseCodeException::class);
        $this->triggerRequestForErrorResponses($client);
    }

    /**
     * @throws \Tecnogo\MeliSdk\Exception\ContainerException
     * @throws \Tecnogo\MeliSdk\Exception\MissingConfigurationException
     * @throws \Tecnogo\MeliSdk\Site\Exception\InvalidSiteIdException
     */
    public function testForbiddenResourceErrorResponse()
    {
        $client = $this->getClientWithFixedGetResponse(403, '');

        $this->expectException(ForbiddenResourceException::class);
        $this->triggerRequestForErrorResponses($client);
    }

    /**
     * @throws \Tecnogo\MeliSdk\Exception\ContainerException
     * @throws \Tecnogo\MeliSdk\Exception\MissingConfigurationException
     * @throws \Tecnogo\MeliSdk\Site\Exception\InvalidSiteIdException
     */
    public function testHttpCode400InvalidTokenException()
    {
        $client = $this->getClientWithFixedGetResponse(400, '{"message":"Failed to validate token"}');

        $this->expectException(InvalidTokenException::class);
        $this->triggerRequestForErrorResponses($client);
    }

    /**
     * @throws \Tecnogo\MeliSdk\Exception\ContainerException
     * @throws \Tecnogo\MeliSdk\Exception\MissingConfigurationException
     * @throws \Tecnogo\MeliSdk\Site\Exception\InvalidSiteIdException
     */
    public function testHttpCode401InvalidTokenException()
    {
        $client = $this->getClientWithFixedGetResponse(401, '');

        $this->expectException(InvalidTokenException::class);
        $this->triggerRequestForErrorResponses($client);
    }

    /**
     * @throws \Tecnogo\MeliSdk\Exception\ContainerException
     * @throws \Tecnogo\MeliSdk\Exception\MissingConfigurationException
     * @throws \Tecnogo\MeliSdk\Site\Exception\InvalidSiteIdException
     */
    public function testBadRequestException()
    {
        $client = $this->getClientWithFixedGetResponse(400, '{"message":"Bad Request"}');

        $this->expectException(BadRequestException::class);
        $this->triggerRequestForErrorResponses($client);
    }
}