<?php
require __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->Load();

return [
    'paths' => [
        'migrations' => '%%PHINX_CONFIG_DIR%%/db/migrations',
        'seeds' => '%%PHINX_CONFIG_DIR%%/db/seeds'
    ],
    'environments' => [
        'default_migration_table' => 'phinxlog',
        'default_environment' => 'development',
        // 'production' => [
        //     'adapter' => 'pgsql',
        //     'host'     => $_ENV['DB_HOST'] ?? 'localhost',
        //     'database' => $_ENV['DB_NAME'] ?? 'gelato', 
        //     'username' => $_ENV['DB_USER'] ?? 'postgres',
        //     'password' => $_ENV['DB_PASS'] ?? '',
        //     'port'     => $_ENV['DB_PORT'] ?? 5432,
        //     'charset' => 'utf8',
        // ],
        'development' => [
            'adapter'  => 'pgsql',
            'host'     => $_ENV['DB_HOST'] ?? 'localhost',
            'name'     => $_ENV['DB_NAME'] ?? 'gelato', 
            'user'     => $_ENV['DB_USER'] ?? 'postgres',
            'pass'     => $_ENV['DB_PASS'] ?? '',
            'port'     => $_ENV['DB_PORT'] ?? 5432,
            'charset'  => 'utf8',
        ],
        // 'testing' => [
        //     'adapter' => 'pgsql',
        //     'host'     => $_ENV['DB_HOST'] ?? 'localhost',
        //     'name' => $_ENV['DB_NAME'] ?? 'gelato',
        //     'username' => $_ENV['DB_USER'] ?? 'postgres',
        //     'password' => $_ENV['DB_PASS'] ?? '',
        //     'port'     => $_ENV['DB_PORT'] ?? 5432,
        //     'charset' => 'utf8',
        // ]
    ],
    'version_order' => 'creation'
];
