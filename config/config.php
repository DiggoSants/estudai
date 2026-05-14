<?php

declare(strict_types=1);

define('APP_NAME', 'Estudai');
define('APP_URL', rtrim($_ENV['APP_URL'] ?? getenv('APP_URL') ?: 'http://localhost/estudai', '/'));
define('SESSION_NAME', 'estudai_sess');

define('DB_HOST', $_ENV['DB_HOST'] ?? getenv('DB_HOST') ?: 'localhost');
define('DB_PORT', (int) ($_ENV['DB_PORT'] ?? getenv('DB_PORT') ?: 3306));
define('DB_USER', $_ENV['DB_USER'] ?? getenv('DB_USER') ?: 'root');
define('DB_PASS', $_ENV['DB_PASS'] ?? getenv('DB_PASS') ?: '');
define('DB_NAME', $_ENV['DB_NAME'] ?? getenv('DB_NAME') ?: 'estudai');
define('DB_CHARSET', 'utf8mb4');

if (session_status() === PHP_SESSION_NONE) {
    $sessionPath = BASE_PATH . '/storage/sessions';

    if (! is_dir($sessionPath)) {
        mkdir($sessionPath, 0775, true);
    }

    session_save_path($sessionPath);
    session_name(SESSION_NAME);
    session_set_cookie_params([
        'lifetime' => 86400 * 7,
        'path' => '/',
        'secure' => false,
        'httponly' => true,
        'samesite' => 'Lax',
    ]);
    session_start();
}
