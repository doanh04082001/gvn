<?php

namespace Tests;

use Illuminate\Contracts\Console\Kernel;
use Illuminate\Support\Facades\Artisan;

trait CreatesApplication
{
    /**
     * If true, setup has run at least once.
     *
     * @var boolean
     */
    protected static $databaseMigrated = false;

    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $app = require __DIR__ . '/../bootstrap/app.php';

        $app->make(Kernel::class)->bootstrap();

        $this->migrateDatabase();

        return $app;
    }

    /**
     * If this is firt runtime test case to migrate and seed database
     *
     * @return void
     */
    private function migrateDatabase()
    {
        // if (!self::$databaseMigrated) {

        //     Artisan::call('migrate:fresh');
        //     Artisan::call('db:seed --class DatabaseTestSeeder');

        //     self::$databaseMigrated = true;
        // }
    }
}
