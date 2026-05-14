<?php

declare(strict_types=1);

namespace App\Services;

use App\Core\Database;
use PDO;

final class EnemQuestionImporter
{
    private PDO $db;
    private EnemApiClient $client;

    public function __construct(?EnemApiClient $client = null)
    {
        $this->db = Database::connection();
        $this->client = $client ?? new EnemApiClient();
    }

    public function importForFilters(array $materiaIds = [], int $target = 20): int
    {
        if (! ENEM_API_ENABLED) {
            return 0;
        }

        $target = max(1, min(300, $target));
        $imported = 0;
        $years = $this->years();
        $language = $this->languageFilter($materiaIds);

        foreach ($years as $year) {
            if ($imported >= $target) {
                break;
            }

            foreach ($this->offsets() as $offset) {
                if ($imported >= $target) {
                    break;
                }

                $response = $this->client->listQuestions($year, ENEM_API_IMPORT_LIMIT, $offset, $language);

                foreach ($response['questions'] as $question) {
                    $materiaId = $this->mapMateriaId($question, $materiaIds);

                    if ($materiaId === null) {
                        continue;
                    }

                    if ($this->saveQuestion($question, $materiaId, $year)) {
                        $imported++;
                    }

                    if ($imported >= $target) {
                        break;
                    }
                }
            }
        }

        return $imported;
    }

    private function saveQuestion(array $question, int $materiaId, int $year): bool
    {
        $alternatives = is_array($question['alternatives'] ?? null) ? array_values($question['alternatives']) : [];
        usort($alternatives, static fn (array $a, array $b): int => strcmp((string) ($a['letter'] ?? ''), (string) ($b['letter'] ?? '')));

        $correct = strtolower((string) ($question['correctAlternative'] ?? ''));
        $statement = $this->buildStatement($question);

        if (count($alternatives) < 5 || ! in_array($correct, ['a', 'b', 'c', 'd', 'e'], true) || $statement === '') {
            return false;
        }

        $index = (string) ($question['index'] ?? md5(json_encode($question, JSON_THROW_ON_ERROR)));
        $language = (string) ($question['language'] ?? 'geral');
        $externalId = "enem.dev:{$year}:{$index}:{$language}";
        $provaId = $this->ensureProva($year);

        $this->db->beginTransaction();

        try {
            $insert = $this->db->prepare('
                INSERT IGNORE INTO questoes (
                    prova_id,
                    materia_id,
                    numero,
                    indice,
                    disciplina_original,
                    idioma,
                    dificuldade,
                    enunciado,
                    contexto,
                    alternativas_intro,
                    gabarito,
                    explicacao,
                    origem,
                    external_id,
                    ativa
                ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
            ');

            $insert->execute([
                $provaId,
                $materiaId,
                ctype_digit($index) ? (int) $index : null,
                $index,
                $this->normalizeText($question['discipline'] ?? ''),
                $language !== '' ? $language : null,
                'medio',
                $statement,
                $this->normalizeText($question['context'] ?? ''),
                $this->normalizeText($question['alternativesIntroduction'] ?? ''),
                $correct,
                'Questão importada da API pública enem.dev. Revise o gabarito oficial no contexto do exame quando necessário.',
                'enem.dev',
                $externalId,
                1,
            ]);

            if ($insert->rowCount() === 0) {
                $this->db->rollBack();
                return false;
            }

            $questaoId = (int) $this->db->lastInsertId();
            $alternativeInsert = $this->db->prepare('
                INSERT INTO alternativas (questao_id, letra, texto, arquivo_url, correta)
                VALUES (?, ?, ?, ?, ?)
            ');

            foreach ($alternatives as $alternative) {
                $letter = strtolower((string) ($alternative['letter'] ?? ''));

                if (! in_array($letter, ['a', 'b', 'c', 'd', 'e'], true)) {
                    continue;
                }

                $alternativeInsert->execute([
                    $questaoId,
                    $letter,
                    $this->alternativeText($alternative),
                    $this->normalizeFileUrl($alternative['file'] ?? null),
                    $letter === $correct ? 1 : 0,
                ]);
            }

            $this->saveFiles($questaoId, $question['files'] ?? []);
            $this->db->commit();

            return true;
        } catch (\Throwable $exception) {
            $this->db->rollBack();
            throw $exception;
        }
    }

    private function ensureProva(int $year): int
    {
        $externalId = "enem.dev:{$year}";
        $select = $this->db->prepare('SELECT id FROM provas WHERE origem = ? AND external_id = ? LIMIT 1');
        $select->execute(['enem.dev', $externalId]);
        $id = $select->fetchColumn();

        if ($id !== false) {
            return (int) $id;
        }

        $insert = $this->db->prepare('
            INSERT INTO provas (vestibular, ano, edicao, origem, external_id)
            VALUES (?, ?, ?, ?, ?)
        ');
        $insert->execute(['ENEM', $year, "ENEM {$year}", 'enem.dev', $externalId]);

        return (int) $this->db->lastInsertId();
    }

    private function saveFiles(int $questaoId, mixed $files): void
    {
        if (! is_array($files) || $files === []) {
            return;
        }

        $insert = $this->db->prepare('
            INSERT INTO questao_arquivos (questao_id, arquivo_url, tipo, ordem)
            VALUES (?, ?, ?, ?)
        ');

        $order = 1;

        foreach ($files as $file) {
            $url = $this->normalizeFileUrl($file);

            if ($url === null) {
                continue;
            }

            $insert->execute([$questaoId, $url, null, $order]);
            $order++;
        }
    }

    private function buildStatement(array $question): string
    {
        $parts = [];
        $title = $this->normalizeText($question['title'] ?? '');
        $context = $this->normalizeText($question['context'] ?? '');
        $intro = $this->normalizeText($question['alternativesIntroduction'] ?? '');

        foreach ([$title, $context, $intro] as $part) {
            if ($part !== '') {
                $parts[] = $part;
            }
        }

        foreach ($question['files'] ?? [] as $file) {
            $url = $this->normalizeFileUrl($file);

            if ($url !== null) {
                $parts[] = '[Arquivo da questão: ' . $url . ']';
            }
        }

        return trim(implode("\n\n", array_unique($parts)));
    }

    private function alternativeText(array $alternative): string
    {
        $parts = [];
        $text = $this->normalizeText($alternative['text'] ?? '');
        $file = $this->normalizeFileUrl($alternative['file'] ?? null);

        if ($text !== '') {
            $parts[] = $text;
        }

        if ($file !== null) {
            $parts[] = '[Arquivo: ' . $file . ']';
        }

        return trim(implode(' ', $parts));
    }

    private function normalizeText(mixed $value): string
    {
        $text = html_entity_decode((string) $value, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $text = trim(strip_tags($text));

        return preg_replace('/\s+/', ' ', $text) ?? $text;
    }

    private function normalizeFileUrl(mixed $value): ?string
    {
        if (! is_string($value)) {
            return null;
        }

        $value = trim($value);

        return $value !== '' ? $value : null;
    }

    private function mapMateriaId(array $question, array $materiaIds): ?int
    {
        $discipline = strtolower((string) ($question['discipline'] ?? ''));
        $language = strtolower((string) ($question['language'] ?? ''));
        $context = strtolower((string) ($question['context'] ?? ''));
        $intro = strtolower((string) ($question['alternativesIntroduction'] ?? ''));
        $text = $context . ' ' . $intro;

        $materiaId = match ($discipline) {
            'matematica' => 1,
            'linguagens' => $this->mapLanguageSubject($language, $text, $materiaIds),
            'ciencias-natureza' => $this->mapBroadSubject($this->inferNatureSubject($text), [3, 4, 5], $materiaIds),
            'ciencias-humanas' => $this->mapBroadSubject($this->inferHumanSubject($text), [6, 7, 9, 10], $materiaIds),
            default => null,
        };

        if ($materiaId === null) {
            return null;
        }

        if ($materiaIds !== [] && ! in_array($materiaId, $materiaIds, true)) {
            return null;
        }

        return $materiaId;
    }

    private function languageFilter(array $materiaIds): ?string
    {
        $wantsEnglish = in_array(8, $materiaIds, true);
        $wantsSpanish = in_array(14, $materiaIds, true);

        if ($wantsEnglish && ! $wantsSpanish) {
            return 'ingles';
        }

        if ($wantsSpanish && ! $wantsEnglish) {
            return 'espanhol';
        }

        return null;
    }

    private function mapLanguageSubject(string $language, string $text, array $materiaIds): ?int
    {
        $materiaId = match ($language) {
            'ingles' => 8,
            'espanhol' => 14,
            default => $this->inferLanguageSubject($text),
        };

        if ($materiaIds === [] || in_array($materiaId, $materiaIds, true)) {
            return $materiaId;
        }

        $compatible = array_values(array_intersect([2, 11, 12, 13, 15], $materiaIds));

        return $compatible[0] ?? null;
    }

    private function mapBroadSubject(int $inferred, array $accepted, array $materiaIds): ?int
    {
        if ($materiaIds === [] || in_array($inferred, $materiaIds, true)) {
            return $inferred;
        }

        $compatible = array_values(array_intersect($accepted, $materiaIds));

        return $compatible[0] ?? null;
    }

    private function inferNatureSubject(string $text): int
    {
        if ($this->hasAny($text, ['força', 'velocidade', 'energia', 'corrente', 'resistor', 'onda', 'movimento'])) {
            return 3;
        }

        if ($this->hasAny($text, ['mol', 'ph', 'reação', 'substância', 'ácido', 'base', 'carbono', 'átomo'])) {
            return 4;
        }

        return 5;
    }

    private function inferHumanSubject(string $text): int
    {
        if ($this->hasAny($text, ['mapa', 'território', 'clima', 'urbanização', 'população', 'paisagem'])) {
            return 7;
        }

        if ($this->hasAny($text, ['ética', 'filósofo', 'filosofia', 'kant', 'aristóteles', 'platão'])) {
            return 9;
        }

        if ($this->hasAny($text, ['sociedade', 'cultura', 'classe', 'sociologia', 'trabalho', 'desigualdade'])) {
            return 10;
        }

        return 6;
    }

    private function inferLanguageSubject(string $text): int
    {
        if ($this->hasAny($text, ['poema', 'romance', 'conto', 'narrador', 'literatura', 'modernismo', 'barroco'])) {
            return 11;
        }

        if ($this->hasAny($text, ['obra', 'artista', 'pintura', 'escultura', 'música', 'teatro', 'dança', 'arte'])) {
            return 12;
        }

        if ($this->hasAny($text, ['corpo', 'esporte', 'atividade física', 'jogo', 'dança', 'saúde corporal'])) {
            return 13;
        }

        if ($this->hasAny($text, ['internet', 'tecnologia', 'digital', 'mídia', 'rede social', 'informação', 'comunicação'])) {
            return 15;
        }

        return 2;
    }

    private function hasAny(string $text, array $needles): bool
    {
        foreach ($needles as $needle) {
            if (str_contains($text, $needle)) {
                return true;
            }
        }

        return false;
    }

    private function years(): array
    {
        $years = array_filter(array_map('intval', explode(',', ENEM_API_YEARS)));
        $years = array_values(array_unique($years));
        rsort($years);

        return $years;
    }

    private function offsets(): array
    {
        $offsets = [0, 30, 60, 90, 120, 150];
        shuffle($offsets);

        return $offsets;
    }
}
