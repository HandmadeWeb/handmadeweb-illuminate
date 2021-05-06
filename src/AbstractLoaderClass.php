<?php

namespace HandmadeWeb\Illuminate;

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
