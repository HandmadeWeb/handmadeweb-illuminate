<?php

namespace HandmadeWeb\Illuminate;

use HandmadeWeb\Illuminate\AbstractLoaderClass;
use HandmadeWeb\Illuminate\Facades\Schema;
use HandmadeWeb\Illuminate\Migration as IlluminateMigration;
use Illuminate\Database\Schema\Blueprint;

class PluginLoader extends AbstractLoaderClass
{
    protected static function runMigrations()
    {
        new IlluminateMigration('HandmadeWeb-Illuminate_create_cache_table', function () {
            Schema::create('illuminate_cache', function (Blueprint $table) {
                $table->string('key')->unique();
                $table->mediumText('value');
                $table->integer('expiration');
            });
        });
    }
}
