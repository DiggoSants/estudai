<?php

declare(strict_types=1);

use App\Core\Database;

function url(string $path = ''): string
{
    return rtrim(APP_URL, '/') . '/' . ltrim($path, '/');
}

function asset(string $path): string
{
    return url('assets/' . ltrim($path, '/'));
}

function e(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES | ENT_HTML5, 'UTF-8');
}

function db(): PDO
{
    return Database::connection();
}

function auth(): ?array
{
    return $_SESSION['user'] ?? null;
}

function requireLogin(): void
{
    if (! auth()) {
        header('Location: ' . url('login'));
        exit;
    }
}

function requireGuest(): void
{
    if (auth()) {
        header('Location: ' . url('dashboard'));
        exit;
    }
}

function loadUser(int $id): ?array
{
    $statement = db()->prepare('SELECT * FROM usuarios WHERE id = ?');
    $statement->execute([$id]);
    $user = $statement->fetch();

    return $user ?: null;
}

function calcNivel(int $xp): array
{
    $niveis = [
        1 => ['nome' => 'Calouro', 'min' => 0, 'max' => 299, 'cor' => '#6b7a8d', 'icone' => '🌱'],
        2 => ['nome' => 'Dedicado', 'min' => 300, 'max' => 699, 'cor' => '#4ab89a', 'icone' => '📚'],
        3 => ['nome' => 'Aplicado', 'min' => 700, 'max' => 1299, 'cor' => '#4a90d9', 'icone' => '⚡'],
        4 => ['nome' => 'Veterano', 'min' => 1300, 'max' => 2199, 'cor' => '#6b4de6', 'icone' => '🔥'],
        5 => ['nome' => 'Expert', 'min' => 2200, 'max' => 3499, 'cor' => '#e8c547', 'icone' => '🏆'],
        6 => ['nome' => 'Mestre', 'min' => 3500, 'max' => 5999, 'cor' => '#e85d4a', 'icone' => '🎓'],
        7 => ['nome' => 'Lendário', 'min' => 6000, 'max' => PHP_INT_MAX, 'cor' => '#ff6b35', 'icone' => '🌟'],
    ];

    foreach ($niveis as $nivel => $dados) {
        if ($xp >= $dados['min'] && $xp <= $dados['max']) {
            $progresso = $dados['max'] === PHP_INT_MAX
                ? 100
                : (int) round(($xp - $dados['min']) / ($dados['max'] - $dados['min']) * 100);

            return array_merge($dados, [
                'nivel' => $nivel,
                'xp' => $xp,
                'progresso' => $progresso,
            ]);
        }
    }

    return array_merge($niveis[7], [
        'nivel' => 7,
        'xp' => $xp,
        'progresso' => 100,
    ]);
}

function calcXP(int $acertos, int $total, int $segundos): int
{
    if ($total === 0) {
        return 0;
    }

    $percentual = $acertos / $total;
    $base = $acertos * 20;
    $bonus = $percentual >= 0.9 ? 50 : ($percentual >= 0.7 ? 20 : 0);
    $velocidade = $segundos < 300 ? 30 : ($segundos < 600 ? 10 : 0);

    return $base + $bonus + $velocidade;
}

function checkConquistas(int $userId): array
{
    $pdo = db();
    $user = loadUser($userId);

    if (! $user) {
        return [];
    }

    $statement = $pdo->prepare('SELECT conquista_id FROM usuario_conquistas WHERE usuario_id = ?');
    $statement->execute([$userId]);
    $desbloqueadas = array_column($statement->fetchAll(), 'conquista_id');

    $statement = $pdo->prepare('
        SELECT COUNT(*) as total, SUM(acertos) as soma_acertos, MAX(acertos / NULLIF(total, 0)) as best_pct
        FROM simulados
        WHERE usuario_id = ? AND finalizado_em IS NOT NULL
    ');
    $statement->execute([$userId]);
    $simulados = $statement->fetch() ?: [];

    $rules = [
        ['chave' => 'primeiro_simulado', 'cond' => (int) ($simulados['total'] ?? 0) >= 1],
        ['chave' => 'streak_3', 'cond' => (int) ($user['streak'] ?? 0) >= 3],
        ['chave' => 'streak_7', 'cond' => (int) ($user['streak'] ?? 0) >= 7],
        ['chave' => 'acerto_perfeito', 'cond' => (float) ($simulados['best_pct'] ?? 0) >= 1.0],
        ['chave' => 'maratona', 'cond' => (int) ($simulados['total'] ?? 0) >= 10],
        ['chave' => 'dedicado', 'cond' => (int) ($user['xp'] ?? 0) >= 1000],
    ];

    $novas = [];

    foreach ($rules as $rule) {
        if (! $rule['cond']) {
            continue;
        }

        $statement = $pdo->prepare('SELECT id, xp_bonus FROM conquistas WHERE chave = ?');
        $statement->execute([$rule['chave']]);
        $conquista = $statement->fetch();

        if (! $conquista || in_array($conquista['id'], $desbloqueadas, true)) {
            continue;
        }

        $pdo->prepare('INSERT IGNORE INTO usuario_conquistas (usuario_id, conquista_id) VALUES (?, ?)')
            ->execute([$userId, $conquista['id']]);
        $pdo->prepare('UPDATE usuarios SET xp = xp + ? WHERE id = ?')
            ->execute([(int) $conquista['xp_bonus'], $userId]);

        $novas[] = $rule['chave'];
    }

    return $novas;
}

function flash(string $key, ?string $message = null): ?string
{
    if ($message !== null) {
        $_SESSION['flash'][$key] = $message;
        return null;
    }

    $value = $_SESSION['flash'][$key] ?? null;
    unset($_SESSION['flash'][$key]);

    return $value;
}

function csrfToken(): string
{
    if (empty($_SESSION['csrf'])) {
        $_SESSION['csrf'] = bin2hex(random_bytes(32));
    }

    return $_SESSION['csrf'];
}

function verifyCsrf(): void
{
    $token = $_POST['csrf_token'] ?? '';

    if (! hash_equals($_SESSION['csrf'] ?? '', $token)) {
        http_response_code(403);
        echo 'Token invalido. <a href="javascript:history.back()">Voltar</a>';
        exit;
    }
}
