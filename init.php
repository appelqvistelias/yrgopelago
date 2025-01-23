<?php

declare(strict_types=1);

ini_set('display_errors', '0'); // Disable display errors
ini_set('log_errors', '1'); // Enable error logging
ini_set('error_log', __DIR__ . '/error.log'); // Set error log file

define('BASE_URL', 'http://www.eappqlevist.se');

session_start();

require_once __DIR__ . "/vendor/autoload.php";
require_once __DIR__ . "/src/logic/functions.php";

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/config');
$dotenv->load();
