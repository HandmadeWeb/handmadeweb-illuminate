<?php

namespace HandmadeWeb\Illuminate;

use Closure;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Arr;

class QueryBuilder extends Builder
{
    /**
     * Run the query as a "select" statement.
     *
     * @return array|object|null Database query results.
     */
    protected function runSelect()
    {
        global $wpdb;

        if (empty($this->getBindings())) {
            return $wpdb->get_results($this->toSql());
        }

        return $wpdb->get_results($wpdb->prepare(str_replace('?', '%s', $this->toSql()), $this->getBindings()));
    }

    /**
     * Insert new records into the database.
     *
     * @param  array  $values
     * @return bool|array|object|null Database query results.
     */
    public function insert(array $values)
    {
        global $wpdb;

        // Since every insert gets treated like a batch insert, we will make sure the
        // bindings are structured in a way that is convenient when building these
        // inserts statements by verifying these elements are actually an array.
        if (empty($values)) {
            return true;
        }

        if (! is_array(reset($values))) {
            $values = [$values];
        }

        // Here, we will sort the insert keys for every record so that each insert is
        // in the same order for the record. We need to make sure this is the case
        // so there are not any errors or problems when inserting these records.
        else {
            foreach ($values as $key => $value) {
                ksort($value);

                $values[$key] = $value;
            }
        }

        // Finally, we will run this query against the database connection and return
        // the results. We will need to also flatten these bindings before running
        // the query so they are all in one huge, flattened array for execution.
        return $wpdb->get_results($wpdb->prepare(str_replace('?', '%s', $this->grammar->compileInsert($this, $values)), $this->cleanBindings(Arr::flatten($values, 1))));
    }

    /**
     * Insert new records into the database while ignoring errors.
     *
     * @param  array  $values
     * @return int|array|object|null Database query results.
     */
    public function insertOrIgnore(array $values)
    {
        global $wpdb;

        if (empty($values)) {
            return 0;
        }

        if (! is_array(reset($values))) {
            $values = [$values];
        } else {
            foreach ($values as $key => $value) {
                ksort($value);
                $values[$key] = $value;
            }
        }

        return $wpdb->get_results($wpdb->prepare(str_replace('?', '%s', $this->grammar->compileInsertOrIgnore($this, $values)), $this->cleanBindings(Arr::flatten($values, 1))));
    }

    /**
     * Insert new records into the table using a subquery.
     *
     * @param  array  $columns
     * @param  \Closure|\Illuminate\Database\Query\Builder|string  $query
     * @return array|object|null Database query results.
     */
    public function insertUsing(array $columns, $query)
    {
        global $wpdb;

        [$sql, $bindings] = $this->createSub($query);

        return $wpdb->get_results($wpdb->prepare(str_replace('?', '%s', $this->grammar->compileInsertUsing($this, $columns, $sql)), $this->cleanBindings($bindings)));
    }

    /**
     * Update records in the database.
     *
     * @param  array  $values
     * @return array|object|null Database query results.
     */
    public function update(array $values)
    {
        global $wpdb;

        return $wpdb->get_results($wpdb->prepare(str_replace('?', '%s', $this->grammar->compileUpdate($this, $values)), $this->cleanBindings($this->grammar->prepareBindingsForUpdate($this->bindings, $values))));
    }

    /**
     * Insert new records or update the existing ones.
     *
     * @param  array  $values
     * @param  array|string  $uniqueBy
     * @param  array|null  $update
     * @return int|array|object|null Database query results.
     */
    public function upsert(array $values, $uniqueBy, $update = null)
    {
        global $wpdb;

        if (empty($values)) {
            return 0;
        } elseif ($update === []) {
            return (int) $this->insert($values);
        }

        if (! is_array(reset($values))) {
            $values = [$values];
        } else {
            foreach ($values as $key => $value) {
                ksort($value);

                $values[$key] = $value;
            }
        }

        if (is_null($update)) {
            $update = array_keys(reset($values));
        }

        $bindings = $this->cleanBindings(array_merge(
            Arr::flatten($values, 1),
            collect($update)->reject(function ($value, $key) {
                return is_int($key);
            })->all()
        ));

        return $wpdb->get_results($wpdb->prepare(str_replace('?', '%s', $this->grammar->compileUpsert($this, $values, (array) $uniqueBy, $update)), $bindings));
    }

    /**
     * Delete records from the database.
     *
     * @param  mixed  $id
     * @return array|object|null Database query results.
     */
    public function delete($id = null)
    {
        global $wpdb;

        // If an ID is passed to the method, we will set the where clause to check the
        // ID to let developers to simply and quickly remove a single row from this
        // database without manually specifying the "where" clauses on the query.
        if (! is_null($id)) {
            $this->where($this->from.'.id', '=', $id);
        }

        return $wpdb->get_results($wpdb->prepare(str_replace('?', '%s', $this->grammar->compileDelete($this)), $this->cleanBindings($this->grammar->prepareBindingsForDelete($this->bindings))));
    }

    /**
     * Create a raw database expression.
     *
     * @param  mixed  $value
     * @return array|object|null Database query results.
     */
    public function raw($value)
    {
        global $wpdb;

        return $wpdb->get_results($value);
    }
}
