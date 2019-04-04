<?php

namespace Tecnogo\MeliSdk\Request;


interface Request
{
    /**
     * @return mixed
     */
    public function exec();

    /**
     * @return mixed
     */
    public function getPayload();

    /**
     * @return string
     * @see Method
     */
    public function getMethod();

    /**
     * @return string
     */
    public function __toString();
}