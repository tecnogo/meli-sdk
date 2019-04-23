<?php

namespace Tecnogo\MeliSdk\Test\Unit\Category;

use PHPUnit\Framework\TestCase;
use Tecnogo\MeliSdk\Client;
use Tecnogo\MeliSdk\Entity\Category\Settings;

class CategorySettingsTest extends TestCase
{
    public function testSettingsHydration()
    {
        $client = Client::create();

        $settings = $client->make(Settings::class)->hydrate([
            'price' => false,
            'stock' => true,
            'tags' => []
        ]);

        $this->assertInstanceOf(Settings::class, $settings);
        $this->assertFalse($settings->price());
        $this->assertTrue($settings->stock());
        $this->assertIsArray($settings->tags());
        $this->assertEmpty($settings->tags());
    }
}
