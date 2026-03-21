<?php
/**
 * Router for PHP built-in server (WordPress pretty URLs)
 */
$uri = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
if ($uri !== '/' && file_exists(__DIR__ . $uri)) {
    return false; // Serve static files
}
require __DIR__ . '/index.php';
