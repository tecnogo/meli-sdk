<?php

namespace Tecnogo\MeliSdk\Test\Unit\Cache;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Cache\Simple\ArrayCache;
use Tecnogo\MeliSdk\Client;

class CacheWarmupTest extends TestCase
{
    /**
     * @throws \Tecnogo\MeliSdk\Exception\ContainerException
     * @throws \Tecnogo\MeliSdk\Exception\MissingConfigurationException
     * @throws \Tecnogo\MeliSdk\Site\Exception\InvalidSiteIdException
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function testWarmup()
    {
        $client = Client::create(['cache' => ['shared' => new ArrayCache()]])->warmUp([
            'foo' => 'bar'
        ]);

        $cache = $client->getFactory()->cache();

        $this->assertTrue($cache->has('foo'));
        $this->assertEquals($cache->get('foo'), 'bar');
        $this->assertFalse($cache->has('blah'));
    }
}
