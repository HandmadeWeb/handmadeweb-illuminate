<?php

namespace HandmadeWeb\Illuminate;

class Loader
{
    public static function boot()
    {
        class_exists('View') ? new \View : null;
    }
}
