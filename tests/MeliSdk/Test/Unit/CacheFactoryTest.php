<?php

namespace Tecnogo\MeliSdk\Test\Unit;

use PHPUnit\Framework\TestCase;
use Psr\SimpleCache\CacheInterface;
use Tecnogo\MeliSdk\Client;

class CacheFactoryTest extends TestCase
{
    public function testComplianceWithPsr16()
    {
        $factory = (new Client())->getFactory();
        $cache = $factory->cache(__CLASS__);

        $this->assertInstanceOf(CacheInterface::class, $cache);
    }

    public function testCacheSharedForNamespace()
    {
        $factory = (new Client())->getFactory();
        $first = $factory->cache(__CLASS__);
        $second = $factory->cache(__CLASS__);

        $this->assertSame($first, $second);
    }

    public function testCacheNotSharedForDifferentNamespaces()
    {
        $factory = (new Client())->getFactory();
        $first = $factory->cache('foo');
        $second = $factory->cache('bar');

        $this->assertNotEquals($first, $second);
    }

    public function testCacheApi()
    {
        $factory = (new Client())->getFactory();
        $cache = $factory->cache(__CLASS__);

        $key = 'value';
        $value = sha1(rand(1, 1000));

        $this->assertTrue($cache->set($key, $value));
        $this->assertTrue($cache->has($key));
        $this->assertEquals($cache->get($key), $value);

    }
}