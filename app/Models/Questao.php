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
            LEFT JOIN questoes q ON q.materia_id = m.id
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

    private function buscarLote(array $materiaIds, string $dificuldade, int $limite, array $excluirIds = []): array
    {
        if ($limite <= 0) {
            return [];
        }

        $params = [];
        $where = ['1=1'];

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
            SELECT q.*, m.nome as materia_nome, m.cor as materia_cor, m.icone as materia_icone
            FROM questoes q
            JOIN materias m ON m.id = q.materia_id
            WHERE ' . implode(' AND ', $where) . "
            ORDER BY RAND()
            LIMIT {$limite}
        ";

        $statement = $this->db->prepare($sql);
        $statement->execute($params);

        return $statement->fetchAll();
    }
}
