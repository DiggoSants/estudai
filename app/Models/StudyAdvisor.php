<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Model;

final class StudyAdvisor extends Model
{
    public function gerar(int $usuarioId): array
    {
        $materias = $this->desempenhoPorMateria($usuarioId);

        if ($materias === []) {
            return [
                'titulo' => 'Comece pelo diagnóstico',
                'resumo' => 'Faça um simulado misto para a IA montar sua primeira rota de estudos com base em erros reais.',
                'prioridade' => null,
                'tarefas' => [
                    'Fazer um simulado com 10 questões de matérias variadas.',
                    'Revisar as explicações das questões erradas.',
                    'Voltar ao dashboard para ver a primeira recomendação.',
                ],
                'materias' => [],
            ];
        }

        usort($materias, fn (array $a, array $b): int => $a['pct'] <=> $b['pct']);
        $prioridade = $materias[0];
        $forca = $materias[count($materias) - 1];
        $pct = (int) $prioridade['pct'];

        $intensidade = $pct < 50 ? 'alta' : ($pct < 70 ? 'média' : 'manutenção');
        $quantidade = $intensidade === 'alta' ? 12 : ($intensidade === 'média' ? 8 : 5);

        return [
            'titulo' => 'Rota individual de hoje',
            'resumo' => "Prioridade {$intensidade}: {$prioridade['nome']} está com {$pct}% de acertos. Use seu ponto forte em {$forca['nome']} como manutenção.",
            'prioridade' => $prioridade,
            'tarefas' => [
                "Resolver {$quantidade} questões de {$prioridade['nome']} em dificuldade média.",
                'Anotar o motivo de cada erro antes de olhar a explicação.',
                "Refazer 3 questões erradas de {$prioridade['nome']} no fim do estudo.",
                "Finalizar com 5 questões leves de {$forca['nome']} para manter confiança.",
            ],
            'materias' => $materias,
        ];
    }

    private function desempenhoPorMateria(int $usuarioId): array
    {
        $statement = $this->db->prepare('
            SELECT m.id, m.nome, m.cor, m.icone,
                   COUNT(r.id) as total,
                   SUM(r.correta) as acertos,
                   ROUND(SUM(r.correta) / COUNT(r.id) * 100) as pct
            FROM respostas r
            JOIN simulados s ON s.id = r.simulado_id
            JOIN questoes q ON q.id = r.questao_id
            JOIN materias m ON m.id = q.materia_id
            WHERE s.usuario_id = ? AND s.finalizado_em IS NOT NULL
            GROUP BY m.id, m.nome, m.cor, m.icone
            HAVING total > 0
            ORDER BY pct ASC, total DESC
        ');
        $statement->execute([$usuarioId]);

        return $statement->fetchAll();
    }
}
