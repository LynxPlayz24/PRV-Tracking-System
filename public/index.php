<?php
/**
 * PRVTS - Single Entry Point
 * All requests are routed through this file.
 */

// Start session
session_start();

// Composer autoloader
require_once dirname(__DIR__) . '/vendor/autoload.php';

// Load environment variables
$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

// Boot application
$app = new App\Core\App();
$app->run();
