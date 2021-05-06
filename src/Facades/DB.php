<?php

namespace HandmadeWeb\Illuminate\Facades;

use HandmadeWeb\Illuminate\Facades\Capsule;
use HandmadeWeb\Illuminate\QueryBuilder;

class DB
{
    /**
     * Set the table which the query is targeting.
     *
     * @param  \Closure|\Illuminate\Database\Query\Builder|string  $table
     * @param  string|null  $as
     * @return $this
     */
    public static function table($table, $as = null)
    {
        return (new QueryBuilder(Capsule::getConnection()))->from($table, $as);
    }
}
