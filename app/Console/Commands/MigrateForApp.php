<?php

namespace App\Console\Commands;

use App\Models\Info;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Artisan;

class MigrateForApp extends Command
{
    // php artisan migrate:forapp --app=Khrejeen --seed --refresh
// php artisan migrate:forapp --app=Elite --seed --refresh
// php artisan migrate:forapp --app=Khrejeen --sql=2024-10-18
// php artisan migrate:forapp --app=Mawahb --seed --refresh
// php artisan migrate:forapp --app=Elite --seed --refresh
// php artisan migrate:forapp --app=Theqa --seed --refresh
// php artisan migrate:forapp --app=tamkeen --seed --refresh
    protected $signature = 'migrate:forapp
                            {--app= : The application name}
                            {--database= : The database connection to use}
                            {--seed : Seed after migration}
                            {--refresh : Drop all tables before migrating}
                            {--sql= : Execute SQL files created after the given date}
                            
                            ';

    protected $description = 'Run migrations for a specific app';

    public function handle()
    {
        $appName = $this->option('app');

        if (!$appName) {
            $this->error('Please provide an app name using the --app option.');
            return 1;
        }

        Config::set('app.name', $appName);

        Info::initialize();

        $this->setDatabaseConfig($appName);

        DB::purge();
        DB::reconnect();

        if ($this->option('refresh')) {
            $this->info('Dropping all tables for app: ' . $appName);
            $this->dropAllTables();
            $this->info('All tables dropped successfully.');
        }

        $options = [
            '--database' => Config::get('database.default'),
        ];
        try {
            Artisan::call('migrate', $options, $this->getOutput());

        } catch (\Exception $e) {
            $this->error('migrate_error' . $e->getMessage());
        }

        if ($this->option('seed')) {
            Artisan::call('db:seed', ['--database' => Config::get('database.default')], $this->getOutput());
        }
        if ($this->option('sql')) {
            Artisan::call('sql:execute', ['--date' => $this->option('sql')], $this->getOutput());
        }

        return 0;
    }

    protected function setDatabaseConfig($appName)
    {
        $connectionName = $appName . '_mysql';

        $dbConfig = [
            'driver' => 'mysql',
            'host' => env('DB_HOST_' . strtoupper($appName), env('DB_HOST', '127.0.0.1')),
            'port' => env('DB_PORT_' . strtoupper($appName), env('DB_PORT', '3306')),
            'database' => env('DB_DATABASE_' . strtoupper($appName), env('DB_DATABASE', 'laravel')),
            'username' => env('DB_USERNAME_' . strtoupper($appName), env('DB_USERNAME', 'root')),
            'password' => env('DB_PASSWORD_' . strtoupper($appName), env('DB_PASSWORD', '')),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                \PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
            ]) : [],
        ];

        Config::set('database.connections.' . $connectionName, $dbConfig);
        Config::set('database.default', $connectionName);
    }

    protected function dropAllTables()
    {
        Schema::dropAllTables();
    }
}
