<?php

namespace Tecnogo\MeliSdk\Entity\LoggedUser;

use Tecnogo\MeliSdk\Client;
use Tecnogo\MeliSdk\Entity\Item\Status;
use Tecnogo\MeliSdk\Entity\LoggedUser\Api\GetRawUserItems;

/**
 * Class ItemSearch
 *
 * @package Tecnogo\MeliSdk\Entity\LoggedUser
 *
 * @internal
 */
final class ItemSearch
{
    const DEFAULT_PAGE_SIZE = 50;

    private $parameters = [];

    /**
     * @var Client
     */
    private $client;
    /**
     * @var int
     */
    private $page = 1;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @return ItemSearchResult
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \Tecnogo\MeliSdk\Exception\ContainerException
     * @throws \Tecnogo\MeliSdk\Exception\MissingConfigurationException
     * @throws \Tecnogo\MeliSdk\Request\Exception\RequestException
     */
    public function get()
    {
        $rawResult = $this->client->exec(GetRawUserItems::class, [
            'payload' => $this->computePayload()
        ]);

        return $this->client
            ->make(ItemSearchResult::class)
            ->hydrate($rawResult);
    }

    /**
     * @param string $query
     * @return $this
     */
    public function search($query)
    {
        $this->query = $query;

        return $this;
    }

    /**
     * @return ItemSearch
     */
    public function active()
    {
        return $this->set('status', Status::ACTIVE);
    }

    /**
     * @return ItemSearch
     */
    public function pending()
    {
        return $this->set('status', Status::PENDING);
    }

    /**
     * @return ItemSearch
     */
    public function paused()
    {
        return $this->set('status', Status::PAUSED);
    }

    /**
     * @return ItemSearch
     */
    public function closed()
    {
        return $this->set('status', Status::CLOSED);
    }

    /**
     * @param int $page
     * @return ItemSearch
     */
    public function page($page)
    {
        $this->page = $page;

        return $this;
    }

    /**
     * @param int $pageSize
     * @return ItemSearch
     */
    public function pageSize($pageSize)
    {
        return $this->set('limit', $pageSize);
    }

    /**
     * @param string $filter
     * @param mixed $value
     * @return $this
     */
    public function set($filter, $value)
    {
        $this->parameters[$filter] = $value;

        return $this;
    }

    /**
     * @return array
     */
    private function computePayload()
    {
        $payload = $this->parameters;

        $pageSize = $this->parameters['limit'] ?? static::DEFAULT_PAGE_SIZE;
        $page = $this->page;

        $payload['limit'] = $pageSize;
        $payload['offset'] = ($page - 1) * $pageSize;

        return $payload;
    }
}
