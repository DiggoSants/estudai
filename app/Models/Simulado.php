<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Model;

final class Simulado extends Model
{
    public function criar(int $usuarioId, array $questoes): int
    {
        $this->db->beginTransaction();

        try {
            $this->excluirRascunhosDoUsuario($usuarioId);

            $statement = $this->db->prepare('INSERT INTO simulados (usuario_id, total) VALUES (?, ?)');
            $statement->execute([$usuarioId, count($questoes)]);
            $simuladoId = (int) $this->db->lastInsertId();

            $statement = $this->db->prepare('INSERT INTO respostas (simulado_id, questao_id) VALUES (?, ?)');
            foreach ($questoes as $questao) {
                $statement->execute([$simuladoId, (int) $questao['id']]);
            }

            $this->db->commit();
            return $simuladoId;
        } catch (\Throwable $exception) {
            $this->db->rollBack();
            throw $exception;
        }
    }

    private function excluirRascunhosDoUsuario(int $usuarioId): void
    {
        $statement = $this->db->prepare('SELECT id FROM simulados WHERE usuario_id = ? AND finalizado_em IS NULL');
        $statement->execute([$usuarioId]);
        $ids = array_map('intval', array_column($statement->fetchAll(), 'id'));

        if ($ids === []) {
            return;
        }

        $placeholders = implode(',', array_fill(0, count($ids), '?'));
        $this->db->prepare("DELETE FROM respostas WHERE simulado_id IN ({$placeholders})")->execute($ids);

        $params = $ids;
        $params[] = $usuarioId;
        $this->db->prepare("DELETE FROM simulados WHERE id IN ({$placeholders}) AND usuario_id = ? AND finalizado_em IS NULL")->execute($params);
    }

    public function pertenceAoUsuario(int $simuladoId, int $usuarioId): bool
    {
        $statement = $this->db->prepare('SELECT id FROM simulados WHERE id = ? AND usuario_id = ? LIMIT 1');
        $statement->execute([$simuladoId, $usuarioId]);

        return (bool) $statement->fetch();
    }

    public function buscar(int $simuladoId, int $usuarioId): ?array
    {
        $statement = $this->db->prepare('SELECT * FROM simulados WHERE id = ? AND usuario_id = ? LIMIT 1');
        $statement->execute([$simuladoId, $usuarioId]);
        $simulado = $statement->fetch();

        return $simulado ?: null;
    }

    public function questoes(int $simuladoId): array
    {
        $statement = $this->db->prepare('
            SELECT q.*, r.resposta, r.correta, m.nome as materia_nome, m.cor as materia_cor, m.icone as materia_icone
            FROM respostas r
            JOIN questoes q ON q.id = r.questao_id
            JOIN materias m ON m.id = q.materia_id
            WHERE r.simulado_id = ?
            ORDER BY r.id
        ');
        $statement->execute([$simuladoId]);

        return $statement->fetchAll();
    }

    public function finalizar(int $simuladoId, int $usuarioId, array $respostas): array
    {
        $simulado = $this->buscar($simuladoId, $usuarioId);

        if (! $simulado) {
            throw new \RuntimeException('Simulado nao encontrado.');
        }

        if ($simulado['finalizado_em'] !== null) {
            return $this->resultado($simuladoId, $usuarioId);
        }

        $questoes = $this->questoes($simuladoId);
        $acertos = 0;
        $total = count($questoes);

        $this->db->beginTransaction();

        try {
            $update = $this->db->prepare('
                UPDATE respostas
                SET resposta = ?, correta = ?
                WHERE simulado_id = ? AND questao_id = ?
            ');

            foreach ($questoes as $questao) {
                $questaoId = (int) $questao['id'];
                $resposta = strtolower((string) ($respostas[$questaoId] ?? ''));
                $resposta = in_array($resposta, ['a', 'b', 'c', 'd', 'e'], true) ? $resposta : null;
                $correta = $resposta !== null && $resposta === strtolower((string) $questao['gabarito']) ? 1 : 0;
                $acertos += $correta;

                $update->execute([$resposta, $correta, $simuladoId, $questaoId]);
            }

            $tempo = max(1, time() - strtotime((string) $simulado['iniciado_em']));
            $xp = calcXP($acertos, $total, $tempo);

            $statement = $this->db->prepare('
                UPDATE simulados
                SET finalizado_em = NOW(), tempo_gasto = ?, acertos = ?, total = ?, xp_ganho = ?
                WHERE id = ? AND usuario_id = ?
            ');
            $statement->execute([$tempo, $acertos, $total, $xp, $simuladoId, $usuarioId]);

            $this->db->prepare('UPDATE usuarios SET xp = xp + ? WHERE id = ?')->execute([$xp, $usuarioId]);
            $this->db->commit();

            checkConquistas($usuarioId);

            return $this->resultado($simuladoId, $usuarioId);
        } catch (\Throwable $exception) {
            $this->db->rollBack();
            throw $exception;
        }
    }

    public function resultado(int $simuladoId, int $usuarioId): array
    {
        $simulado = $this->buscar($simuladoId, $usuarioId);

        if (! $simulado) {
            throw new \RuntimeException('Simulado nao encontrado.');
        }

        return [
            'simulado' => $simulado,
            'questoes' => $this->questoes($simuladoId),
        ];
    }
}
