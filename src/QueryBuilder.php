<?php

namespace HandmadeWeb\Illuminate;

use Illuminate\Database\Query\Builder;

class QueryBuilder extends Builder
{
    /**
     * Run the query as a "select" statement against the connection.
     *
     * @return array
     */
    protected function runSelect()
    {
        global $wpdb;

        $sql = str_replace('?', '%s', $this->toSql());

        return $wpdb->get_results($wpdb->prepare($sql, $this->getBindings()));
    }
}
