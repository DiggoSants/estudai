<?php

declare(strict_types=1);

define('BASE_PATH', dirname(__DIR__));

require BASE_PATH . '/config/config.php';
require BASE_PATH . '/app/Core/helpers.php';
require BASE_PATH . '/app/Core/Database.php';
require BASE_PATH . '/app/Core/Model.php';

spl_autoload_register(function (string $class): void {
    $prefix = 'App\\';
    $baseDir = BASE_PATH . '/app/';

    if (strncmp($prefix, $class, strlen($prefix)) !== 0) {
        return;
    }

    $relativeClass = substr($class, strlen($prefix));
    $file = $baseDir . str_replace('\\', '/', $relativeClass) . '.php';

    if (file_exists($file)) {
        require $file;
    }
});

use App\Services\EnemApiClient;
use App\Services\EnemQuestionImporter;

$options = parseOptions(array_slice($argv ?? [], 1));
$limit = max(1, min(300, (int) ($options['limit'] ?? 60)));
$materias = parseMaterias((string) ($options['materias'] ?? ''));

try {
    $client = new EnemApiClient();
    $probe = $client->listQuestions((int) (explode(',', ENEM_API_YEARS)[0] ?? 2023), 2);

    if (($probe['questions'] ?? []) === []) {
        echo "Aviso: a chamada de teste à enem.dev não retornou questões.\n";
        echo 'Detalhe: ' . ($client->lastError() ?? 'sem erro detalhado do cliente HTTP') . "\n";
    } else {
        echo 'API enem.dev acessível: ' . count($probe['questions']) . " questão(ões) recebida(s) no teste.\n";
    }

    $before = countImported();
    $imported = (new EnemQuestionImporter($client))->importForFilters($materias, $limit);
    $after = countImported();
    $counts = tableCounts();

    echo "Importação enem.dev concluída.\n";
    echo formatImportacaoEnem($imported) . "\n";
    echo "Total no banco com origem enem.dev: {$after}\n";
    echo "Provas ENEM: {$counts['provas']}\n";
    echo "Questões: {$counts['questoes']}\n";
    echo "Alternativas: {$counts['alternativas']}\n";

    if ($after === $before && $imported === 0) {
        echo "Nada novo importado. Possíveis motivos: questões já existem, filtro de matéria restrito ou API indisponível.\n";
    }
} catch (Throwable $exception) {
    fwrite(STDERR, "Erro ao importar da enem.dev: {$exception->getMessage()}\n");
    exit(1);
}

function parseOptions(array $args): array
{
    $options = [];

    foreach ($args as $arg) {
        if (! str_starts_with($arg, '--')) {
            continue;
        }

        [$key, $value] = array_pad(explode('=', substr($arg, 2), 2), 2, '1');
        $options[$key] = $value;
    }

    return $options;
}

function parseMaterias(string $value): array
{
    if ($value === '') {
        return [];
    }

    return array_values(array_filter(
        array_map('intval', explode(',', $value)),
        static fn (int $id): bool => $id > 0
    ));
}

function countImported(): int
{
    $statement = db()->query("SELECT COUNT(*) as total FROM questoes WHERE origem = 'enem.dev'");

    return (int) ($statement->fetch()['total'] ?? 0);
}

function tableCounts(): array
{
    return [
        'provas' => (int) (db()->query("SELECT COUNT(*) as total FROM provas WHERE vestibular = 'ENEM'")->fetch()['total'] ?? 0),
        'questoes' => (int) (db()->query('SELECT COUNT(*) as total FROM questoes')->fetch()['total'] ?? 0),
        'alternativas' => (int) (db()->query('SELECT COUNT(*) as total FROM alternativas')->fetch()['total'] ?? 0),
    ];
}
