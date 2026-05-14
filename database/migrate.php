<?php

declare(strict_types=1);

define('BASE_PATH', dirname(__DIR__));

require BASE_PATH . '/config/config.php';
require BASE_PATH . '/app/Core/helpers.php';
require BASE_PATH . '/app/Core/Database.php';

$args = array_slice($argv ?? [], 1);
$force = in_array('--force', $args, true) || in_array('--forced', $args, true);
$unknownArgs = array_values(array_filter($args, fn (string $arg): bool => ! in_array($arg, ['--force', '--forced'], true)));

if ($unknownArgs !== []) {
    fwrite(STDERR, 'Argumento desconhecido: ' . implode(', ', $unknownArgs) . PHP_EOL);
    exit(1);
}

$schemaPath = BASE_PATH . '/database/schema.sql';

if (! file_exists($schemaPath)) {
    fwrite(STDERR, "Schema não encontrado em {$schemaPath}" . PHP_EOL);
    exit(1);
}

$sql = file_get_contents($schemaPath);

if ($sql === false || trim($sql) === '') {
    fwrite(STDERR, 'Schema vazio ou inválido.' . PHP_EOL);
    exit(1);
}

try {
    ensureDatabaseExists();
    db()->exec($sql);

    echo $force
        ? 'Migração forçada concluída.' . PHP_EOL
        : 'Migração concluída.' . PHP_EOL;
} catch (Throwable $exception) {
    fwrite(STDERR, "Erro ao executar migração: {$exception->getMessage()}" . PHP_EOL);
    exit(1);
}

function ensureDatabaseExists(): void
{
    $dsn = sprintf(
        'mysql:host=%s;port=%d;charset=%s',
        DB_HOST,
        DB_PORT,
        DB_CHARSET
    );

    $database = str_replace('`', '``', DB_NAME);
    $pdo = new PDO($dsn, DB_USER, DB_PASS, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]);

    $pdo->exec("CREATE DATABASE IF NOT EXISTS `{$database}` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
}
