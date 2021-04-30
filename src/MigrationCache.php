<?php

namespace HandmadeWeb\Illuminate;

use HandmadeWeb\Illuminate\Facades\DB;

class MigrationCache
{
    protected static $migrationTableExists = false;
    protected static $migrations = [];

    public static function boot()
    {
        if (! static::$migrationTableExists && get_option('illuminate_migration_table_exists')) {
            static::$migrationTableExists = true;
        }

        if (static::$migrationTableExists && empty(static::$migrations)) {
            $migrations = DB::table('illuminate_migrations')->get(['migration']);
            foreach ($migrations as $migration) {
                static::$migrations[$migration->migration] = true;
            }
        }
    }

    public static function exists(string $name): bool
    {
        static::boot();

        if (static::$migrationTableExists) {
            if (isset(static::$migrations[$name])) {
                return true;
            }

            $migration = DB::table('illuminate_migrations')->where('migration', $name)->first(['migration']);

            if (isset($migration->migration)) {
                static::$migrations[$migration->migration] = true;

                return true;
            }
        }

        return false;
    }
}
