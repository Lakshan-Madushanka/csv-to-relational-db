<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class CreateDB extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:db';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This will create, migrate and seed the database base on env values';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $charset = config("database.connections.mysql.charset", 'utf8mb4');
        $collation = config("database.connections.mysql.collation", 'utf8mb4_unicode_ci');
        $dbName = Config::get("database.connections.mysql.database");

        $this->info('Creating database ....');
        $this->newLine();

        config(["database.connections.mysql.database" => null]);

        DB::statement("create database if not exists $dbName");

        $query = "CREATE DATABASE IF NOT EXISTS $dbName CHARACTER SET $charset COLLATE $collation;";

        DB::statement($query);

        config(["database.connections.mysql.database" => $dbName]);

        $this->newLine();
        $this->info('Created database succeeded !');
    }
}
