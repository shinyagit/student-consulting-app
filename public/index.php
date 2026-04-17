<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

/*
|--------------------------------------------------------------------------
| Resolve application base path
|--------------------------------------------------------------------------
|
| Local/Docker では通常の Laravel 構成（public の一つ上）を使い、
| Xserver 本番では公開ディレクトリ外に置いた current を使う。
|
*/

$defaultBasePath = dirname(__DIR__);
$xserverBasePath = '/home/xs266894/laravel-consulting-app/current';

$basePath = is_file($defaultBasePath . '/vendor/autoload.php')
    ? $defaultBasePath
    : $xserverBasePath;

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = $basePath . '/storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register the Composer autoloader...
require $basePath . '/vendor/autoload.php';

// Bootstrap Laravel and handle the request...
/** @var Application $app */
$app = require_once $basePath . '/bootstrap/app.php';

$app->handleRequest(Request::capture());