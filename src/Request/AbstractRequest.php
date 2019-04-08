<?php

namespace Tecnogo\MeliSdk\Request;

use Tecnogo\MeliSdk\Request\Exception\MalformedJsonResponseException;
use Tecnogo\MeliSdk\Request\Exception\BadRequestException;
use Tecnogo\MeliSdk\Request\Exception\InvalidTokenException;
use Tecnogo\MeliSdk\Request\Exception\MissingAppIdException;
use Tecnogo\MeliSdk\Request\Exception\MissingAccessTokenException;
use Tecnogo\MeliSdk\Request\Exception\NotFoundException;
use Tecnogo\MeliSdk\Request\Exception\ForbiddenResourceException;
use Tecnogo\MeliSdk\Request\Exception\RequestErrorException;
use Tecnogo\MeliSdk\Request\Exception\UnexpectedHttpResponseCodeException;

/**
 * Class AbstractRequest
 *
 * @package Tecnogo\MeliSdk\Request
 *
 * @internal
 */
abstract class AbstractRequest implements Request
{
    const SUCCESSFUL_HTTP_CODES = [200, 201];
    /**
     * @var string
     */
    private $resource;
    /**
     * cURL options
     * @var array
     */
    private $options;
    /**
     * @var array
     */
    private $payload;

    /**
     * AbstractRequest constructor.
     *
     * @param string $resource
     * @param $payload
     * @param array $options
     */
    public function __construct($resource, array $payload = [], array $options = [])
    {
        $this->options = $options;
        $this->payload = $payload;
        $this->resource = $resource;
    }

    /**
     * @return array
     */
    protected function getOptions()
    {
        return $this->options + [
                CURLOPT_USERAGENT => 'TECNOGO-MELI-SDK-0.0.1',
                CURLOPT_SSL_VERIFYPEER => true,
                CURLOPT_CONNECTTIMEOUT => 10,
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_TIMEOUT => 60
            ];
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
     * @throws RequestErrorException
     */
    public function exec()
    {
        list($httpCode, $response) = $this->doRequest($this->resource);

        $body = json_decode($response, true);

        if (in_array($httpCode, static::SUCCESSFUL_HTTP_CODES) && !is_array($body)) {
            throw new MalformedJsonResponseException($response);
        }

        return $this->handledResult($httpCode, $body);
    }

    /**
     * @param $httpCode
     * @param array|null $result
     * @return mixed
     * @throws BadRequestException
     * @throws ForbiddenResourceException
     * @throws InvalidTokenException
     * @throws MissingAppIdException
     * @throws NotFoundException
     * @throws UnexpectedHttpResponseCodeException
     * @throws RequestErrorException
     */
    protected function handledResult($httpCode, $result)
    {
        $message = $result['message'] ?? 'No message.';
        $resource = $this->resource;

        switch ($httpCode) {
            case 200:
            case 201:
                return $result;
            case 400:
                return $this->handleHttpCode400($result ?? []);
            case 401:
                throw new InvalidTokenException($message);
            case 403:
                throw new ForbiddenResourceException($message);
            case 404:
                throw new NotFoundException($message);
            default:
                throw new UnexpectedHttpResponseCodeException("$httpCode: $message ($resource)");
        }
    }

    /**
     * @return false|string
     */
    public function __toString()
    {
        return json_encode([
            'class' => get_called_class(),
            'resource' => $this->resource,
            'method' => $this->getMethod(),
            'payload' => $this->getPayload()
        ]);
    }

    /**
     * @return array
     */
    public function getPayload()
    {
        return $this->payload;
    }

    /**
     * @param array $payload
     * @throws MissingAppIdException
     * @throws UnexpectedHttpResponseCodeException
     * @throws InvalidTokenException
     * @throws BadRequestException
     * @throws RequestErrorException
     */
    private function handleHttpCode400(array $payload)
    {
        $message = trim($payload['message'] ?? 'No message.');

        switch ($message) {
            case ErrorMessageDictionary::MESSAGES_RETRIEVE_REQUIRED_APP_ID:
                throw new MissingAppIdException($message);
            case ErrorMessageDictionary::FAILED_TO_VALIDATE_TOKEN:
                throw new InvalidTokenException($message);
            case 'Bad Request':
                throw new BadRequestException($message);
            default:
                throw new RequestErrorException($message);
        }
    }

    /**
     * @param string $url
     * @return array
     */
    protected function doRequest($url)
    {
        $ch = curl_init($url);
        curl_setopt_array($ch, $this->getOptions());

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        return [$httpCode, $response];
    }

    /**
     * @return string
     */
    public function getResource()
    {
        return $this->resource;
    }
}
