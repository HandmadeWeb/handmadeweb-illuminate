<?php

namespace HandmadeWeb\Illuminate;

class Loader
{
    public static function boot()
    {
    }

    public static function boot_views()
    {
        class_exists('View') ? new \View : null;
    }
}
