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
        $prefix = '';
        $cacheTable = 'illuminate_cache';
        $lockTable = 'illuminate_cache_locks';
        $lockLottery = [2, 100];

        return new DatabaseStore(DB::__getFacadeInstance()->connection(), $cacheTable, $prefix, $lockTable, $lockLottery);
    }
}
