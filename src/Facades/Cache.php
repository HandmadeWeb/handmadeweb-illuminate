<?php

namespace HandmadeWeb\Illuminate\Facades;

use HandmadeWeb\Illuminate\AbstractFacadeClass;
use HandmadeWeb\Illuminate\Cache as IlluminateCache;

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
        $prefix = '';
        $cacheTable = 'illuminate_cache';

        return new IlluminateCache($cacheTable, $prefix);
    }
}
