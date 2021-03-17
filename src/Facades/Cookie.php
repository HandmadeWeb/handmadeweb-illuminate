<?php

namespace HandmadeWeb\Illuminate\Facades;

use HandmadeWeb\Illuminate\AbstractFacadeClass;
use Illuminate\Cookie\CookieJar;

class Cookie extends AbstractFacadeClass
{
    /**
     * The facaded instance.
     */
    protected static $instance;

    /**
     * Set the instance behind the facade.
     *
     * @return string
     */
    protected static function __setFacadeInstance()
    {
        return new CookieJar;
    }
}
