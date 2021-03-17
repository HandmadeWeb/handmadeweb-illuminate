<?php

namespace HandmadeWeb\Illuminate;

use Carbon\Carbon;
use HandmadeWeb\Illuminate\Facades\DB;
use HandmadeWeb\Illuminate\Facades\Schema;

class Migration
{
    public function __construct($name, $callback)
    {
        if (! Schema::hasTable('illuminate_migrations')) {
            $this->createMigrationsTable();
        }

        if (Schema::hasTable('illuminate_migrations') && ! DB::table('illuminate_migrations')->where('migration', $name)->first()) {
            call_user_func($callback);
            DB::table('illuminate_migrations')->insert([
                'migration' => $name,
                'migrated_at' => Carbon::now(),
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
    }
}
