<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Questao;
use App\Models\Simulado;

final class SimuladoController extends Controller
{
    public function index(): void
    {
        requireLogin();

        $questaoModel = new Questao();
        $materias = $questaoModel->materiasComContagem();
        $totalQuestoes = array_sum(array_map(static fn (array $m): int => (int) $m['total_questoes'], $materias));

        $this->view('simulado/index', [
            'title' => 'Novo Simulado',
            'materias' => $materias,
            'totalQuestoes' => $totalQuestoes,
            'erro' => flash('erro'),
            'aviso' => flash('aviso'),
        ], '');
    }

    public function iniciar(): void
    {
        requireLogin();
        verifyCsrf();

        $materiaIds = array_map('intval', $_POST['materias'] ?? []);
        $materiaIds = array_values(array_filter($materiaIds, static fn (int $id): bool => $id > 0));
        $dificuldade = (string) ($_POST['dificuldade'] ?? 'todas');
        $quantidade = (int) ($_POST['quantidade'] ?? 10);

        $questoes = (new Questao())->selecionar($materiaIds, $dificuldade, $quantidade);

        if ($questoes === []) {
            flash('erro', 'Não encontrei questões com esses filtros. Tente uma dificuldade diferente ou selecione mais matérias.');
            $this->redirect('simulado');
        }

        $simuladoId = (new Simulado())->criar((int) $_SESSION['user']['id'], $questoes);
        $_SESSION['simulado_ativo'] = $simuladoId;

        if (count($questoes) < $quantidade) {
            flash('aviso', 'O banco ainda não tem questões suficientes para completar a quantidade pedida. Gere mais questões pelo seed para aumentar a variedade.');
        }

        $this->redirect("simulado/{$simuladoId}");
    }

    public function show(string $id): void
    {
        requireLogin();

        $simuladoId = (int) $id;
        $model = new Simulado();
        $simulado = $model->buscar($simuladoId, (int) $_SESSION['user']['id']);

        if (! $simulado) {
            http_response_code(404);
            echo 'Simulado não encontrado.';
            return;
        }

        if ($simulado['finalizado_em'] !== null) {
            $this->redirect("simulado/{$simuladoId}/resultado");
        }

        if ((int) ($_SESSION['simulado_ativo'] ?? 0) !== $simuladoId) {
            flash('erro', 'Esse simulado antigo não está mais ativo. Inicie um novo diagnóstico.');
            $this->redirect('simulado');
        }

        $this->view('simulado/show', [
            'title' => 'Responder Simulado',
            'simulado' => $simulado,
            'questoes' => $model->questoes($simuladoId),
        ], '');
    }

    public function finalizar(string $id): void
    {
        requireLogin();
        verifyCsrf();

        $simuladoId = (int) $id;
        if ((int) ($_SESSION['simulado_ativo'] ?? 0) !== $simuladoId) {
            flash('erro', 'Esse simulado não está ativo. Inicie um novo diagnóstico.');
            $this->redirect('simulado');
        }

        (new Simulado())->finalizar($simuladoId, (int) $_SESSION['user']['id'], $_POST['respostas'] ?? []);
        unset($_SESSION['simulado_ativo']);
        $_SESSION['ultimo_resultado_simulado'] = $simuladoId;

        $this->redirect("simulado/{$simuladoId}/resultado");
    }

    public function resultado(string $id): void
    {
        requireLogin();

        $simuladoId = (int) $id;
        $resultado = (new Simulado())->resultado($simuladoId, (int) $_SESSION['user']['id']);

        if ($resultado['simulado']['finalizado_em'] === null) {
            $this->redirect((int) ($_SESSION['simulado_ativo'] ?? 0) === $simuladoId ? "simulado/{$simuladoId}" : 'simulado');
        }

        if ((int) ($_SESSION['ultimo_resultado_simulado'] ?? 0) !== $simuladoId) {
            flash('erro', 'Para revisar outro simulado, use o histórico do dashboard quando essa tela estiver liberada. Por enquanto, gere um novo diagnóstico.');
            $this->redirect('simulado');
        }

        $this->view('simulado/resultado', [
            'title' => 'Resultado',
            'simulado' => $resultado['simulado'],
            'questoes' => $resultado['questoes'],
        ], '');
    }
}
