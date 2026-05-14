<?php

declare(strict_types=1);

define('APP_NAME', 'Estudai');
define('APP_URL', rtrim($_ENV['APP_URL'] ?? getenv('APP_URL') ?: 'http://localhost/estudai', '/'));
define('SESSION_NAME', 'estudai_sess');

function envValue(string $key, ?string $fallback = null): ?string
{
    $value = $_ENV[$key] ?? getenv($key);

    return $value !== false && $value !== '' ? (string) $value : $fallback;
}

function databaseConfig(): array
{
    $databaseUrl = envValue('DATABASE_URL', envValue('MYSQL_URL'));

    if ($databaseUrl) {
        $parts = parse_url($databaseUrl);

        if ($parts !== false) {
            $host = $parts['host'] ?? 'localhost';
            // Force TCP connection by using 127.0.0.1 instead of localhost
            if ($host === 'localhost') {
                $host = '127.0.0.1';
            }
            return [
                'host' => $host,
                'port' => (int) ($parts['port'] ?? 3306),
                'user' => urldecode($parts['user'] ?? 'root'),
                'pass' => urldecode($parts['pass'] ?? ''),
                'name' => ltrim($parts['path'] ?? '/estudai', '/'),
            ];
        }
    }

    $host = envValue('DB_HOST', envValue('MYSQLHOST', 'localhost'));
    // Force TCP connection by using 127.0.0.1 instead of localhost
    if ($host === 'localhost') {
        $host = '127.0.0.1';
    }
    return [
        'host' => $host,
        'port' => (int) envValue('DB_PORT', envValue('MYSQLPORT', '3306')),
        'user' => envValue('DB_USER', envValue('MYSQLUSER', 'root')),
        'pass' => envValue('DB_PASS', envValue('MYSQLPASSWORD', '')),
        'name' => envValue('DB_NAME', envValue('MYSQLDATABASE', 'estudai')),
    ];
}

$database = databaseConfig();

define('DB_HOST', $database['host']);
define('DB_PORT', $database['port']);
define('DB_USER', $database['user']);
define('DB_PASS', $database['pass']);
define('DB_NAME', $database['name']);
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
