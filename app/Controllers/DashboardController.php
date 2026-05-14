<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Models\StudyAdvisor;

final class DashboardController extends Controller
{
    public function index(): void
    {
        requireLogin();

        $user = loadUser((int) $_SESSION['user']['id']);

        if (! $user) {
            session_destroy();
            $this->redirect('login');
        }

        $_SESSION['user'] = $user;
        checkConquistas((int) $user['id']);
        $user = loadUser((int) $user['id']) ?: $user;
        $_SESSION['user'] = $user;

        $pdo = db();
        $uid = (int) $user['id'];

        $stats = $this->fetchOne($pdo, '
            SELECT COUNT(*) as total, SUM(acertos) as acertos, SUM(total) as questoes,
                   AVG(acertos / NULLIF(total, 0)) * 100 as media
            FROM simulados
            WHERE usuario_id = ? AND finalizado_em IS NOT NULL
        ', [$uid]);

        $ultimos = $this->fetchAll($pdo, '
            SELECT s.*, DATE_FORMAT(s.finalizado_em, "%d/%m às %H:%i") as data_fmt
            FROM simulados s
            WHERE s.usuario_id = ? AND s.finalizado_em IS NOT NULL
            ORDER BY s.finalizado_em DESC
            LIMIT 5
        ', [$uid]);

        $materias = $this->fetchAll($pdo, '
            SELECT m.nome, m.cor, m.icone, COUNT(r.id) as total, SUM(r.correta) as acertos,
                   ROUND(SUM(r.correta) / COUNT(r.id) * 100) as pct
            FROM respostas r
            JOIN simulados s ON r.simulado_id = s.id
            JOIN questoes q ON r.questao_id = q.id
            JOIN materias m ON q.materia_id = m.id
            WHERE s.usuario_id = ? AND s.finalizado_em >= DATE_SUB(NOW(), INTERVAL 30 DAY)
            GROUP BY m.id, m.nome, m.cor, m.icone
            ORDER BY pct ASC
        ', [$uid]);

        $conquistas = $this->fetchAll($pdo, '
            SELECT c.*, DATE_FORMAT(uc.desbloqueado_em, "%d/%m/%Y") as data
            FROM usuario_conquistas uc
            JOIN conquistas c ON uc.conquista_id = c.id
            WHERE uc.usuario_id = ?
            ORDER BY uc.desbloqueado_em DESC
        ', [$uid]);

        $todasConquistas = $this->fetchAll($pdo, 'SELECT * FROM conquistas ORDER BY id');
        $erros = $this->fetchAll($pdo, '
            SELECT q.enunciado, m.nome as materia, m.cor, m.icone, COUNT(*) as tentativas,
                   SUM(r.correta) as acertos, ROUND((1 - SUM(r.correta) / COUNT(*)) * 100) as erro_pct
            FROM respostas r
            JOIN simulados s ON r.simulado_id = s.id
            JOIN questoes q ON r.questao_id = q.id
            JOIN materias m ON q.materia_id = m.id
            WHERE s.usuario_id = ? AND r.correta = 0 AND s.finalizado_em IS NOT NULL
            GROUP BY q.id, q.enunciado, m.nome, m.cor, m.icone
            ORDER BY tentativas DESC
            LIMIT 3
        ', [$uid]);

        $semana = [];
        for ($i = 6; $i >= 0; $i--) {
            $dia = date('Y-m-d', strtotime("-$i days"));
            $row = $this->fetchOne($pdo, '
                SELECT COUNT(*) as cnt
                FROM simulados
                WHERE usuario_id = ? AND DATE(finalizado_em) = ? AND finalizado_em IS NOT NULL
            ', [$uid, $dia]);
            $semana[] = ['data' => $dia, 'label' => date('D', strtotime($dia)), 'cnt' => (int) ($row['cnt'] ?? 0)];
        }

        $this->view('dashboard/index', [
            'title' => 'Dashboard',
            'user' => $user,
            'rotaEstudos' => (new StudyAdvisor())->gerar($uid),
            'nivel' => calcNivel((int) $user['xp']),
            'stats' => $stats ?: [],
            'ultimos' => $ultimos,
            'materias' => $materias,
            'conquistas' => $conquistas,
            'todasConquistas' => $todasConquistas,
            'conquistasIds' => array_column($conquistas, 'chave'),
            'semana' => $semana,
            'erros' => $erros,
            'primeiroNome' => explode(' ', $user['nome'])[0],
            'saudacao' => $this->saudacao(),
        ], '');
    }

    private function fetchOne(\PDO $pdo, string $sql, array $params = []): array|false
    {
        $statement = $pdo->prepare($sql);
        $statement->execute($params);

        return $statement->fetch();
    }

    private function fetchAll(\PDO $pdo, string $sql, array $params = []): array
    {
        $statement = $pdo->prepare($sql);
        $statement->execute($params);

        return $statement->fetchAll();
    }

    private function saudacao(): string
    {
        $hora = (int) date('H');

        return $hora < 12 ? 'Bom dia' : ($hora < 18 ? 'Boa tarde' : 'Boa noite');
    }
}
