<?php

namespace Tecnogo\MeliSdk\Entity\Site\Api;

use Tecnogo\MeliSdk\Api\AbstractTemplateAction;
use Tecnogo\MeliSdk\Cache\CacheStrategy;
use Tecnogo\MeliSdk\Entity\Site\Site;
use Tecnogo\MeliSdk\Request\Exception\NotFoundException;
use Tecnogo\MeliSdk\Request\Method;

/**
 * Class GuessSiteUrl
 *
 * @package Tecnogo\MeliSdk\Entity\Site\Api
 */
final class GuessSiteUrl extends AbstractTemplateAction
{
    /**
     * @var Site
     */
    private $site;

    /**
     * GuessSiteUrl constructor.
     * @param Site $site
     */
    public function __construct(Site $site)
    {
        $this->site = $site;
    }

    /**
     * @param array $result
     * @return array|string
     */
    public function handle(array $result = [])
    {
        if (!isset($result['results'][0])) {
            return null;
        }

        $permalink = $result['results'][0]['permalink'];

        $fragments = explode('/', $permalink);
        $protocol = $fragments[0];
        $domain = preg_replace('/^[a-z]+\./', '', $fragments[2]);

        return "$protocol//$domain";
    }

    /**
     * @param \Exception $e
     * @return mixed|void|null
     * @throws \Exception
     */
    public function handleException(\Exception $e)
    {
        if ($e instanceof NotFoundException) {
            return null;
        }

        throw $e;
    }

    /**
     * @return string
     */
    public function getResource()
    {
        return 'sites/' . $this->site->id() . '/search';
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        return Method::GET;
    }

    /**
     * @return array
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \Tecnogo\MeliSdk\Exception\ContainerException
     * @throws \Tecnogo\MeliSdk\Exception\MissingConfigurationException
     * @throws \Tecnogo\MeliSdk\Request\Exception\RequestException
     * @throws \Tecnogo\MeliSdk\Site\Exception\InvalidSiteIdException
     */
    public function getPayload()
    {
        $category = $this->site->categories()->first();

        return [
            'limit' => 1,
            'category' => $category ? $category->id() : null
        ];
    }

    /**
     * @return string
     */
    public function getCacheStrategy()
    {
        return CacheStrategy::FOREVER;
    }
}
