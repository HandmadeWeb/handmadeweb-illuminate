<?php

if (! class_exists('View')) {
    class View extends \HandmadeWeb\Illuminate\View
    {
    }
}

if (! function_exists('view')) {
    function view($view = null, $data = [], $mergeData = [])
    {
        if (func_num_args() === 0) {
            return View::getFactory();
        }

        return View::make($view, $data, $mergeData);
    }
}
