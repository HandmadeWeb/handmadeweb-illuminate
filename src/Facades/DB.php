<?php

namespace HandmadeWeb\Illuminate\Facades;

use HandmadeWeb\Illuminate\Class\QueryBuilder;
use HandmadeWeb\Illuminate\Facades\Capsule;

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
        $queryBuilder = new QueryBuilder(Capsule::getConnection());

        return $queryBuilder->from($table, $as);
    }
}
