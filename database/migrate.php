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
    fwrite(STDERR, 'Argumento desconhecido: ' . implode(', ', $unknownArgs) . "\n");
    exit(1);
}

$schemaPath = BASE_PATH . '/database/schema.sql';

if (! file_exists($schemaPath)) {
    fwrite(STDERR, "Schema nao encontrado em {$schemaPath}\n");
    exit(1);
}

$sql = file_get_contents($schemaPath);

if ($sql === false || trim($sql) === '') {
    fwrite(STDERR, "Schema vazio ou invalido.\n");
    exit(1);
}

try {
    db()->exec($sql);
    echo $force
        ? "Migracao forcada concluida.\n"
        : "Migracao concluida.\n";
} catch (Throwable $exception) {
    fwrite(STDERR, "Erro ao executar migracao: {$exception->getMessage()}\n");
    exit(1);
}
