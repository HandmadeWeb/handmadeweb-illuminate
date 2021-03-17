<?php

use Carbon\Carbon;
use HandmadeWeb\Illuminate\Facades\Cache;
use HandmadeWeb\Illuminate\Facades\View;

if (! function_exists('locationExistsOrCreate')) {
    function locationExistsOrCreate(string $location, int $chmodPermission = 0755): bool
    {
        return is_dir($location) ?: mkdir($location, $chmodPermission, true);
    }
}

if (! function_exists('view')) {
    /**
     * Get the evaluated view contents for the given view.
     *
     * @param  string|null  $view
     * @param  \Illuminate\Contracts\Support\Arrayable|array  $data
     * @param  array  $mergeData
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    function view($view = null, $data = [], $mergeData = [])
    {
        if (func_num_args() === 0) {
            return View::__getFacadeInstance();
        }

        return View::make($view, $data, $mergeData);
    }
}

if (! function_exists('cache')) {
    /**
     * Get / set the specified cache value.
     *
     * If an array is passed, we'll assume you want to put to the cache.
     *
     * @param  dynamic  key|key,default|data,expiration|null
     * @return mixed|\Illuminate\Cache\CacheManager
     *
     * @throws \Exception
     */
    function cache()
    {
        $arguments = func_get_args();

        if (empty($arguments)) {
            return Cache::__getFacadeInstance();
        }

        if (is_string($arguments[0])) {
            return Cache::__getFacadeInstance()->get(...$arguments);
        }

        if (! is_array($arguments[0])) {
            throw new Exception(
                'When setting a value in the cache, you must pass an array of key / value pairs.'
            );
        }

        return Cache::__getFacadeInstance()->put(key($arguments[0]), reset($arguments[0]), $arguments[1] ?? null);
    }
}

if (! function_exists('now')) {
    /**
     * Create a new Carbon instance for the current time.
     *
     * @param  \DateTimeZone|string|null  $tz
     * @return \Illuminate\Support\Carbon
     */
    function now($tz = null)
    {
        return Carbon::now($tz);
    }
}

if (! function_exists('today')) {
    /**
     * Create a new Carbon instance for the current date.
     *
     * @param  \DateTimeZone|string|null  $tz
     * @return \Illuminate\Support\Carbon
     */
    function today($tz = null)
    {
        return Carbon::today($tz);
    }
}
