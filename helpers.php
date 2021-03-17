<?php

use HandmadeWeb\Illuminate\Facades\View;

if (! function_exists('locationExistsOrCreate')) {
    function locationExistsOrCreate(string $location, int $chmodPermission = 0755): bool
    {
        return is_dir($location) ?: mkdir($location, $chmodPermission, true);
    }
}

if (! function_exists('view')) {
    function view($view = null, $data = [], $mergeData = [])
    {
        if (func_num_args() === 0) {
            return View::__getFacadeInstance();
        }

        return View::make($view, $data, $mergeData);
    }
}
