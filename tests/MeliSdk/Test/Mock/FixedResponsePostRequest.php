<?php

namespace Tecnogo\MeliSdk\Test\Mock;

use Tecnogo\MeliSdk\Request\Method;

class FixedResponsePostRequest extends AbstractFixedResponseRequest
{
    /**
     * @return string
     * @see Method
     */
    public function getMethod()
    {
        return Method::POST;
    }
}
