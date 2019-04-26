<?php

namespace Tecnogo\MeliSdk\Test\Unit\Cache;

use PHPUnit\Framework\TestCase;
use Psr\SimpleCache\CacheInterface;
use Symfony\Component\Cache\Simple\ArrayCache;
use Symfony\Component\Cache\Simple\FilesystemCache;
use Symfony\Component\Cache\Simple\NullCache;
use Tecnogo\MeliSdk\Client;
use Tecnogo\MeliSdk\Test\Resource\CreateMapResponseGetRequest;

class CacheFactoryTest extends TestCase
{
    use CreateMapResponseGetRequest;

    /**
     * @throws \Tecnogo\MeliSdk\Exception\ContainerException
     * @throws \Tecnogo\MeliSdk\Exception\MissingConfigurationException
     * @throws \Tecnogo\MeliSdk\Site\Exception\InvalidSiteIdException
     */
    public function testComplianceWithPsr16()
    {
        $factory = Client::create()->getFactory();
        $cache = $factory->cache();

        $this->assertInstanceOf(CacheInterface::class, $cache);
    }

    /**
     * @throws \Tecnogo\MeliSdk\Exception\ContainerException
     * @throws \Tecnogo\MeliSdk\Exception\MissingConfigurationException
     * @throws \Tecnogo\MeliSdk\Site\Exception\InvalidSiteIdException
     */
    public function testSharedCacheOverride()
    {
        $myCache = new NullCache();
        $factory = Client::create([
            'cache' => [
                'shared' => $myCache
            ]
        ])->getFactory();

        $this->assertSame($factory->cache('foo'), $myCache);
    }

    /**
     * @throws \Tecnogo\MeliSdk\Exception\ContainerException
     * @throws \Tecnogo\MeliSdk\Exception\MissingConfigurationException
     * @throws \Tecnogo\MeliSdk\Site\Exception\InvalidSiteIdException
     */
    public function testNamespaceCacheOverride()
    {
        $myCache = new NullCache();
        $factory = Client::create([
            'cache' => [
                'foo' => $myCache
            ]
        ])->getFactory();

        $this->assertSame($factory->cache('foo'), $myCache);
    }

    /**
     * @throws \Tecnogo\MeliSdk\Exception\ContainerException
     * @throws \Tecnogo\MeliSdk\Exception\MissingConfigurationException
     * @throws \Tecnogo\MeliSdk\Site\Exception\InvalidSiteIdException
     */
    public function testCacheSharedForNamespace()
    {
        $factory = Client::create()->getFactory();
        $first = $factory->cache(__CLASS__);
        $second = $factory->cache(__CLASS__);

        $this->assertSame($first, $second);
    }

    /**
     * @throws \Tecnogo\MeliSdk\Exception\ContainerException
     * @throws \Tecnogo\MeliSdk\Exception\MissingConfigurationException
     * @throws \Tecnogo\MeliSdk\Site\Exception\InvalidSiteIdException
     */
    public function testCacheSharedForNonOverridedNamespaces()
    {
        $factory = Client::create()->getFactory();
        $first = $factory->cache('foo');
        $second = $factory->cache('bar');

        $this->assertSame($first, $second);
    }

    /**
     * @throws \Tecnogo\MeliSdk\Exception\ContainerException
     * @throws \Tecnogo\MeliSdk\Exception\MissingConfigurationException
     * @throws \Tecnogo\MeliSdk\Site\Exception\InvalidSiteIdException
     */
    public function testCacheNotSharedForOverridedNamespace()
    {
        $factory = Client::create([
            'cache' => [
                'foo' => new FilesystemCache()
            ]
        ])->getFactory();

        $first = $factory->cache('foo');
        $second = $factory->cache('bar');

        $this->assertNotSame($first, $second);
    }

    /**
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \Tecnogo\MeliSdk\Cache\Exception\InvalidCacheStrategy
     * @throws \Tecnogo\MeliSdk\Exception\ContainerException
     * @throws \Tecnogo\MeliSdk\Exception\MissingConfigurationException
     * @throws \Tecnogo\MeliSdk\Request\Exception\RequestException
     * @throws \Tecnogo\MeliSdk\Site\Exception\InvalidSiteIdException
     */
    public function testCacheClear()
    {
        $cache = new ArrayCache();

        $client = $this->getClientWithMapGetResponse([
            'sites'=> [200, '[]']
        ], ['cache' => ['shared' => $cache]]);

        $this->assertEmpty($cache->getValues());

        $client->sites();
        $this->assertCount(1, $cache->getValues());

        $client->clearCache();
        $this->assertEmpty($cache->getValues());
    }
}