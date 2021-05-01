<?php

namespace HandmadeWeb\Illuminate\Class;

use Carbon\Carbon;
use HandmadeWeb\Illuminate\Facades\DB;
use HandmadeWeb\Illuminate\Facades\Schema;
use HandmadeWeb\Illuminate\Static\MigrationCache;

class Migration
{
    protected $migrationTableExists;
    protected $migrationAlreadyRan;

    public function __construct($name, $callback)
    {
        $this->migrationTableExists = (bool) get_option('illuminate_migration_table_exists');

        if (! $this->migrationTableExists) {
            $this->createMigrationsTable();
        }

        $this->migrationAlreadyRan = MigrationCache::exists($name);

        if ($this->migrationTableExists && ! $this->migrationAlreadyRan) {
            call_user_func($callback);
            DB::table('illuminate_migrations')->insert([
                'migration' => $name,
                'migrated_at' => Carbon::now()->format('Y-m-d h:i:j'),
            ]);
        }
    }

    protected function createMigrationsTable()
    {
        Schema::create('illuminate_migrations', function ($table) {
            $table->id();
            $table->string('migration')->index();
            $table->datetime('migrated_at');
        });

        DB::table('illuminate_migrations')->insert([
            'migration' => 'HandmadeWeb-Illuminate_create_migrations_table',
            'migrated_at' => Carbon::now()->format('Y-m-d h:i:j'),
        ]);

        update_option('illuminate_migration_table_exists', true, true);
    }
}
