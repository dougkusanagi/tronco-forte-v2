<?php

use flight\Engine;
use flight\database\PdoWrapper;
use flight\debug\database\PdoQueryCapture;
use Tracy\Debugger;

/** 
 * @var array $config This comes from the returned array at the bottom of the config.php file
 * @var Engine $app
 */

// Database configuration based on centralized config
$dbConfig = $config['database'];
$dbType = $dbConfig['type'] ?? 'sqlite';

if ($dbType === 'mysql') {
    $mysqlConfig = $dbConfig['mysql'];
    $dsn = 'mysql:host=' . $mysqlConfig['host'] . ';dbname=' . $mysqlConfig['dbname'] . ';charset=' . ($mysqlConfig['charset'] ?? 'utf8mb4');
    $user = $mysqlConfig['user'];
    $password = $mysqlConfig['password'];
} else {
    // SQLite configuration
    $sqliteConfig = $dbConfig['sqlite'];
    $dsn = 'sqlite:' . $sqliteConfig['file_path'];
    $user = null;
    $password = null;
}

// Register database service
// In development, you'll want the class that captures the queries for you. In production, not so much.
$pdoClass = Debugger::$showBar === true ? PdoQueryCapture::class : PdoWrapper::class;
$app->register('db', $pdoClass, [ $dsn, $user, $password ]);

// Got google oauth stuff? You could register that here
// $app->register('google_oauth', Google_Client::class, [ $config['google_oauth'] ]);

// Redis? This is where you'd set that up
// $app->register('redis', Redis::class, [ $config['redis']['host'], $config['redis']['port'] ]);

// Configure view system with layout
$app->register('view', \flight\template\View::class, [], function($view) {
    $view->path = __DIR__ . '/../views';
    $view->extension = '.php';
});
