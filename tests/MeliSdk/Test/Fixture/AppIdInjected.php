<?php

namespace Tecnogo\MeliSdk\Test\Fixture;

use Tecnogo\MeliSdk\Config\AppId;

/**
 * Class AppIdInjected
 *
 * @package Tecnogo\MeliSdk\Test\Fixture
 *
 * @internal
 */
final class AppIdInjected
{
    public function __construct(AppId $appId)
    {
    }
}