<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Artisan;

class SeedForApp extends Command
{
    //php artisan db:seed:forapp --app=Khrejeen --class=SeederClass
    protected $signature = 'db:seed:forapp {--app= : The application name} {--class= : The class name of the root seeder}';

    protected $description = 'Seed the database for a specific app';

    public function handle()
    {
        $appName = $this->option('app');

        if (!$appName) {
            $this->error('Please provide an app name using the --app option.');
            return 1;
        }

        Config::set('app.name', $appName);

        $this->setDatabaseConfig($appName);

        DB::purge();
        DB::reconnect();

        $options = [
            '--database' => Config::get('database.default'),
        ];

        if ($this->option('class')) {
            $options['--class'] = $this->option('class');
        }

        Artisan::call('db:seed', $options, $this->getOutput());

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

}
