<?php

namespace HandmadeWeb\Illuminate\Static\Abstract;

abstract class AbstractLoaderClass
{
    public static function boot()
    {
        static::init();
        static::runMigrations();
    }

    public static function init()
    {
    }

    private static function runMigrations()
    {
    }
}
