<?php

namespace HandmadeWeb\Illuminate\Facades;

use HandmadeWeb\Illuminate\Class\Cache as IlluminateCache;
use HandmadeWeb\Illuminate\Static\Abstract\AbstractFacadeClass;

class Cache extends AbstractFacadeClass
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
        return new IlluminateCache('illuminate_cache ', '');
    }
}
