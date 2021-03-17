<?php

namespace HandmadeWeb\Illuminate;

abstract class AbstractLoaderClass
{
    public static function boot()
    {
        add_action('init', [static::class, 'init']);
        static::runMigrations();
    }

    public static function init()
    {
    }

    private static function runMigrations()
    {
    }
}
