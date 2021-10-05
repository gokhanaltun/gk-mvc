<?php 
namespace App\System;

/**
 * Rquest Url Patterns
 */
define('URL_PATTERNS', 
[
    '{id}' => '([0-9]+)',
    '{name}' => '([a-z]+)',
    '{user}' => '([a-zA-Z]+)'
]);

/**
 * 'VİEW_PREFİX': View and Layout Files Extension Prefix
 * 'CACHE_PREFİX': Cache File Extension Prefix
 */
define('TEMPLATE_PREFIX', '.tmp');
define('CACHE_PREFIX', '.cache');

/**
 * Folder Base Paths
 * using templateEngine.php
 * using route.php
 */
define('CONTROLLER_BASE', dirname(__DIR__) . '/Controllers/');
define('VIEW_BASE', dirname(__DIR__) . '/Views/');
define('CACHE_BASE', dirname(__DIR__) . '/Cache/');
define('LAYOUT_BASE', dirname(__DIR__) . '/Layouts/');

/**
 * Mysql Database Connection
 */
define('DB_HOST', 'localhost');
define('DB_NAME', 'gk_template');
define('DB_USER', 'root');
define('DB_PASS', '');

?>