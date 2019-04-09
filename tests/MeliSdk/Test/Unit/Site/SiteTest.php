<?php

namespace Tecnogo\MeliSdk\Test\Unit\Site;

use PHPUnit\Framework\TestCase;
use Tecnogo\MeliSdk\Site\Exception\InvalidSiteIdException;
use Tecnogo\MeliSdk\Site\Site;

class SiteTest extends TestCase
{
    public function testAll()
    {
        $all = Site::all();

        $this->assertIsArray($all);

        $expected = [
            'MLA',
            'MLB',
            'MCO',
            'MCR',
            'MEC',
            'MLC',
            'MLM',
            'MLU',
            'MLV',
            'MPA',
            'MPE',
            'MPT',
            'MRD',
        ];

        sort($all);
        sort($expected);

        $this->assertEquals($all, $expected);
    }

    public function testAssert()
    {
        foreach (Site::all() as $siteId) {
            Site::assert($siteId);
        }

        $this->expectException(InvalidSiteIdException::class);

        Site::assert('wubba_lubba_dub');
    }
}