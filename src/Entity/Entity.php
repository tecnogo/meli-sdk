<?php

namespace Tecnogo\MeliSdk\Entity;

use Tecnogo\MeliSdk\Client;

interface Entity
{
    public function __construct(Client $client);

    /**
     * @param mixed $source
     * @return $this
     */
    public function hydrate($source);

    /**
     * @return array
     */
    public function raw();

    /**
     * @param int $options
     * @return string
     */
    public function toJson($options = 0);
}
