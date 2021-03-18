<?php

namespace HandmadeWeb\Illuminate;

use Closure;
use Exception;
use Illuminate\Cache\RetrievesMultipleKeys;
use Illuminate\Contracts\Cache\Store;
use Illuminate\Database\QueryException;
use Illuminate\Support\InteractsWithTime;

class Cache implements Store
{
    use InteractsWithTime, RetrievesMultipleKeys;

    /**
     * The name of the cache table.
     *
     * @var string
     */
    protected $table;

    /**
     * A string that should be prepended to keys.
     *
     * @var string
     */
    protected $prefix;

    /**
     * Create a new database store.
     *
     * @param  string  $table
     * @param  string  $prefix
     * @param  string  $lockTable
     * @param  array  $lockLottery
     * @return void
     */
    public function __construct($table, $prefix = '')
    {
        global $wpdb;
        $this->table = $wpdb->prefix.$table;
        $this->prefix = $prefix;
    }

    /**
     * Retrieve an item from the cache by key.
     *
     * @param  string|array  $key
     * @return mixed
     */
    public function get($key)
    {
        global $wpdb;

        $prefixed = $this->prefix.$key;

        $cache = collect($wpdb->get_results($wpdb->prepare("SELECT * FROM `{$this->table}` WHERE `key` = %s LIMIT 1", $prefixed)))->first();

        // If we have a cache record we will check the expiration time against current
        // time on the system and see if the record has expired. If it has, we will
        // remove the records from the database table so it isn't returned again.
        if (is_null($cache)) {
            return;
        }

        $cache = is_array($cache) ? (object) $cache : $cache;

        // If this cache expiration date is past the current time, we will remove this
        // item from the cache. Then we will return a null value since the cache is
        // expired. We will use "Carbon" to make this comparison with the column.
        if ($this->currentTime() >= $cache->expiration) {
            $this->forget($key);

            return;
        }

        return $this->unserialize($cache->value);
    }

    /**
     * Store an item in the cache for a given number of seconds.
     *
     * @param  string  $key
     * @param  mixed  $value
     * @param  int  $seconds
     * @return bool
     */
    public function put($key, $value, $seconds)
    {
        global $wpdb;

        $key = $this->prefix.$key;
        $value = $this->serialize($value);
        $expiration = $this->getTime() + $seconds;

        try {
            return $wpdb->insert($this->table, ['key' => $key, 'value' => $value, 'expiration' => $expiration]);
        } catch (Exception $e) {
            $result = $wpdb->update($this->table, ['value' => $value, 'expiration' => $expiration], ['key' => $key]);

            return $result > 0;
        }
    }

    /**
     * Store an item in the cache if the key doesn't exist.
     *
     * @param  string  $key
     * @param  mixed  $value
     * @param  int  $seconds
     * @return bool
     */
    public function add($key, $value, $seconds)
    {
        global $wpdb;

        $key = $this->prefix.$key;
        $value = $this->serialize($value);
        $expiration = $this->getTime() + $seconds;

        try {
            return $wpdb->insert($this->table, ['key' => $key, 'value' => $value, 'expiration' => $expiration]);
        } catch (QueryException $e) {
            return $wpdb->query($wpdb->prepare("UPDATE `{$this->table}` SET `value` = %s, `expiration` = %s WHERE `key` = %s AND expiration <= %s", $value, $expiration, $key, $this->getTime())) === true;
        }
    }

    /**
     * Increment the value of an item in the cache.
     *
     * @param  string  $key
     * @param  mixed  $value
     * @return int|bool
     */
    public function increment($key, $value = 1)
    {
        return $this->incrementOrDecrement($key, $value, function ($current, $value) {
            return $current + $value;
        });
    }

    /**
     * Decrement the value of an item in the cache.
     *
     * @param  string  $key
     * @param  mixed  $value
     * @return int|bool
     */
    public function decrement($key, $value = 1)
    {
        return $this->incrementOrDecrement($key, $value, function ($current, $value) {
            return $current - $value;
        });
    }

    /**
     * Increment or decrement an item in the cache.
     *
     * @param  string  $key
     * @param  mixed  $value
     * @param  \Closure  $callback
     * @return int|bool
     */
    protected function incrementOrDecrement($key, $value, Closure $callback)
    {
        global $wpdb;

        $prefixed = $this->prefix.$key;

        $cache = collect($wpdb->get_results($wpdb->prepare("SELECT * FROM `{$this->table}` WHERE `key` = %s LIMIT 1", $this->table, $prefixed)))->first();

        // If there is no value in the cache, we will return false here. Otherwise the
        // value will be decrypted and we will proceed with this function to either
        // increment or decrement this value based on the given action callbacks.
        if (is_null($cache)) {
            return false;
        }

        $cache = is_array($cache) ? (object) $cache : $cache;

        $current = $this->unserialize($cache->value);

        // Here we'll call this callback function that was given to the function which
        // is used to either increment or decrement the function. We use a callback
        // so we do not have to recreate all this logic in each of the functions.
        $new = $callback((int) $current, $value);

        if (! is_numeric($current)) {
            return false;
        }

        // Here we will update the values in the table. We will also encrypt the value
        // since database cache values are encrypted by default with secure storage
        // that can't be easily read. We will return the new value after storing.
        $wpdb->update($this->table, ['value' => $this->serialize($new)], ['key' => $key]);

        return $new;
    }

    /**
     * Get the current system time.
     *
     * @return int
     */
    protected function getTime()
    {
        return $this->currentTime();
    }

    /**
     * Store an item in the cache indefinitely.
     *
     * @param  string  $key
     * @param  mixed  $value
     * @return bool
     */
    public function forever($key, $value)
    {
        return $this->put($key, $value, 315360000);
    }

    /**
     * Remove an item from the cache.
     *
     * @param  string  $key
     * @return bool
     */
    public function forget($key)
    {
        global $wpdb;

        $wpdb->delete($this->table, ['key' => $key]);

        return true;
    }

    /**
     * Remove all items from the cache.
     *
     * @return bool
     */
    public function flush()
    {
        global $wpdb;

        $wpdb->query("DELETE FROM `{$this->table}`");

        return true;
    }

    /**
     * Get the cache key prefix.
     *
     * @return string
     */
    public function getPrefix()
    {
        return $this->prefix;
    }

    /**
     * Serialize the given value.
     *
     * @param  mixed  $value
     * @return string
     */
    protected function serialize($value)
    {
        $result = serialize($value);

        return $result;
    }

    /**
     * Unserialize the given value.
     *
     * @param  string  $value
     * @return mixed
     */
    protected function unserialize($value)
    {
        return unserialize($value);
    }
}
