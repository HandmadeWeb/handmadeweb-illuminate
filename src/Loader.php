<?php

namespace HandmadeWeb\Illuminate;

class Loader
{
    public static function boot()
    {
        class_exists('DB') ? new \DB : null;
        class_exists('View') ? new \View : null;
    }
}
