<?php

namespace Tecnogo\MeliSdk\Entity\Currency;

use Tecnogo\MeliSdk\Collection\ListCollection;

/**
 * Class Collection
 *
 * @package Tecnogo\MeliSdk\Entity\Currency
 *
 * @method Currency first
 * @method Currency last
 *
 * @internal
 */
final class Collection extends ListCollection
{
    /**
     * @return array
     */
    public function raw()
    {
        return $this
            ->map(function (Currency $currency) {
                return $currency->raw();
            })
            ->toArray();
    }
}
