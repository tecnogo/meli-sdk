<?php

namespace Tecnogo\MeliSdk\Test\Unit;

use PHPUnit\Framework\TestCase;
use Psr\SimpleCache\CacheInterface;
use Symfony\Component\Cache\Simple\FilesystemCache;
use Symfony\Component\Cache\Simple\NullCache;
use Tecnogo\MeliSdk\Client;

class CacheFactoryTest extends TestCase
{
    /**
     * @throws \Tecnogo\MeliSdk\Exception\ContainerException
     * @throws \Tecnogo\MeliSdk\Exception\MissingConfigurationException
     * @throws \Tecnogo\MeliSdk\Site\Exception\InvalidSiteIdException
     */
    public function testComplianceWithPsr16()
    {
        $factory = (Client::create())->getFactory();
        $cache = $factory->cache(__CLASS__);

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
     * @throws \Tecnogo\MeliSdk\Exception\ContainerException
     * @throws \Tecnogo\MeliSdk\Exception\MissingConfigurationException
     * @throws \Tecnogo\MeliSdk\Site\Exception\InvalidSiteIdException
     */
    public function testCacheApi()
    {
        $factory = (Client::create())->getFactory();
        $cache = $factory->cache(__CLASS__);

        $key = 'value';
        $value = sha1(rand(1, 1000));

        $this->assertTrue($cache->set($key, $value));
        $this->assertTrue($cache->has($key));
        $this->assertEquals($cache->get($key), $value);

    }
}