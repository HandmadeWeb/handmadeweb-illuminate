<?php

namespace HandmadeWeb\Illuminate\Facades;

use HandmadeWeb\Illuminate\AbstractFacadeClass;
use Illuminate\Cache\DatabaseStore;

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
        return new DatabaseStore(DB::__getFacadeInstance()->connection(), 'illuminate_cache', $prefix = '', $lockTable = 'cache_locks', $lockLottery = [2, 100]);
    }
}
