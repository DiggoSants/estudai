<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Model;

final class Questao extends Model
{
    public function materiasComContagem(): array
    {
        $statement = $this->db->query('
            SELECT m.*, COUNT(q.id) as total_questoes
            FROM materias m
            LEFT JOIN questoes q ON q.materia_id = m.id AND q.ativa = 1
            GROUP BY m.id, m.nome, m.cor, m.icone
            ORDER BY m.id
        ');

        return $statement->fetchAll();
    }

    public function selecionar(array $materiaIds, string $dificuldade, int $quantidade): array
    {
        $quantidade = max(1, min(20, $quantidade));
        $questoes = [];

        $tentativas = [
            ['materias' => $materiaIds, 'dificuldade' => $dificuldade],
            ['materias' => $materiaIds, 'dificuldade' => 'todas'],
            ['materias' => [], 'dificuldade' => $dificuldade],
            ['materias' => [], 'dificuldade' => 'todas'],
        ];

        foreach ($tentativas as $tentativa) {
            if (count($questoes) >= $quantidade) {
                break;
            }

            $novas = $this->buscarLote(
                $tentativa['materias'],
                $tentativa['dificuldade'],
                $quantidade - count($questoes),
                array_column($questoes, 'id')
            );

            foreach ($novas as $questao) {
                $questoes[(int) $questao['id']] = $questao;
            }
        }

        return array_values($questoes);
    }

    public function contarDisponiveis(array $materiaIds = [], string $dificuldade = 'todas'): int
    {
        $params = [];
        $where = ['q.ativa = 1'];

        if ($materiaIds !== []) {
            $placeholders = implode(',', array_fill(0, count($materiaIds), '?'));
            $where[] = "q.materia_id IN ({$placeholders})";
            array_push($params, ...$materiaIds);
        }

        if (in_array($dificuldade, ['facil', 'medio', 'dificil'], true)) {
            $where[] = 'q.dificuldade = ?';
            $params[] = $dificuldade;
        }

        $statement = $this->db->prepare('
            SELECT COUNT(*) as total
            FROM questoes q
            JOIN (
                SELECT questao_id, COUNT(*) as total_alternativas
                FROM alternativas
                GROUP BY questao_id
            ) alt ON alt.questao_id = q.id AND alt.total_alternativas >= 5
            WHERE ' . implode(' AND ', $where)
        );
        $statement->execute($params);

        return (int) ($statement->fetch()['total'] ?? 0);
    }

    private function buscarLote(array $materiaIds, string $dificuldade, int $limite, array $excluirIds = []): array
    {
        if ($limite <= 0) {
            return [];
        }

        $params = [];
        $where = ['q.ativa = 1'];

        if ($materiaIds !== []) {
            $placeholders = implode(',', array_fill(0, count($materiaIds), '?'));
            $where[] = "q.materia_id IN ({$placeholders})";
            array_push($params, ...$materiaIds);
        }

        if (in_array($dificuldade, ['facil', 'medio', 'dificil'], true)) {
            $where[] = 'q.dificuldade = ?';
            $params[] = $dificuldade;
        }

        if ($excluirIds !== []) {
            $placeholders = implode(',', array_fill(0, count($excluirIds), '?'));
            $where[] = "q.id NOT IN ({$placeholders})";
            array_push($params, ...array_map('intval', $excluirIds));
        }

        $limite = max(1, min(20, $limite));
        $sql = '
            SELECT
                q.id,
                q.prova_id,
                q.materia_id,
                q.numero,
                q.indice,
                q.disciplina_original,
                q.idioma,
                q.dificuldade,
                q.enunciado,
                q.contexto,
                q.alternativas_intro,
                q.gabarito,
                q.explicacao,
                q.origem,
                q.external_id,
                q.ativa,
                q.criado_em,
                p.ano,
                p.vestibular,
                p.edicao,
                m.nome as materia_nome,
                m.cor as materia_cor,
                m.icone as materia_icone,
                alt.alternativa_a,
                alt.alternativa_b,
                alt.alternativa_c,
                alt.alternativa_d,
                alt.alternativa_e
            FROM questoes q
            JOIN provas p ON p.id = q.prova_id
            JOIN materias m ON m.id = q.materia_id
            JOIN (
                SELECT
                    questao_id,
                    COUNT(*) as total_alternativas,
                    MAX(CASE WHEN letra = \'a\' THEN texto END) as alternativa_a,
                    MAX(CASE WHEN letra = \'b\' THEN texto END) as alternativa_b,
                    MAX(CASE WHEN letra = \'c\' THEN texto END) as alternativa_c,
                    MAX(CASE WHEN letra = \'d\' THEN texto END) as alternativa_d,
                    MAX(CASE WHEN letra = \'e\' THEN texto END) as alternativa_e
                FROM alternativas
                GROUP BY questao_id
            ) alt ON alt.questao_id = q.id AND alt.total_alternativas >= 5
            WHERE ' . implode(' AND ', $where) . "
            ORDER BY RAND()
            LIMIT {$limite}
        ";

        $statement = $this->db->prepare($sql);
        $statement->execute($params);

        return $statement->fetchAll();
    }
}
