<?php
/**
 * PRVTS - Single Entry Point
 * All requests are routed through this file.
 */

// Composer autoloader
require_once dirname(__DIR__) . '/vendor/autoload.php';

// Load environment variables
$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

// Dynamic APP_URL detection for LAN/network access
if (isset($_SERVER['HTTP_HOST'])) {
    $scheme = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') ? 'https' : 'http';
    $scriptDir = rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? '')), '/');
    $_ENV['APP_URL'] = "{$scheme}://{$_SERVER['HTTP_HOST']}{$scriptDir}";
}

// Error display: controlled by APP_DEBUG in .env
$debug = filter_var($_ENV['APP_DEBUG'] ?? false, FILTER_VALIDATE_BOOLEAN);
ini_set('display_errors', $debug ? '1' : '0');
ini_set('display_startup_errors', $debug ? '1' : '0');
error_reporting(E_ALL);

// Secure session configuration
session_start([
    'cookie_httponly' => true,
    'cookie_samesite' => 'Lax',
    'use_strict_mode' => true,
    'use_only_cookies' => true,
]);

// Boot application
$app = new App\Core\App();
$app->run();

