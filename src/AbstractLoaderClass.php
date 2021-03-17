<?php

namespace HandmadeWeb\Illuminate;

abstract class AbstractLoaderClass
{
    public static function boot()
    {
        static::runMigrations();
    }

    private static function runMigrations()
    {
    }
}
