<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Models\User;

final class AuthController extends Controller
{
    public function showLogin(): void
    {
        requireGuest();

        $this->view('auth/login', [
            'title' => 'Entrar',
            'tab' => $_GET['tab'] ?? 'login',
            'erro' => '',
            'ok' => flash('ok'),
        ], '');
    }

    public function login(): void
    {
        requireGuest();
        verifyCsrf();

        $email = trim($_POST['email'] ?? '');
        $senha = $_POST['senha'] ?? '';
        $erro = '';

        if ($email === '' || $senha === '') {
            $erro = 'Preencha todos os campos.';
        } else {
            $model = new User();
            $user = $model->findByEmail($email);

            if ($user && password_verify($senha, $user['senha_hash'])) {
                $newStreak = $model->updateLoginStreak(
                    (int) $user['id'],
                    $user['ultimo_login'] ?? null,
                    (int) $user['streak']
                );
                $user['streak'] = $newStreak;
                $_SESSION['user'] = $user;

                $this->redirect('dashboard');
            }

            $erro = 'E-mail ou senha inválidos.';
        }

        $this->view('auth/login', [
            'title' => 'Entrar',
            'tab' => 'login',
            'erro' => $erro,
            'ok' => null,
        ], '');
    }

    public function register(): void
    {
        requireGuest();
        verifyCsrf();

        $nome = trim($_POST['nome'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $senha = $_POST['senha'] ?? '';
        $confirmar = $_POST['confirmar'] ?? '';
        $erro = '';

        if ($nome === '' || $email === '' || $senha === '' || $confirmar === '') {
            $erro = 'Preencha todos os campos.';
        } elseif (! filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $erro = 'E-mail inválido.';
        } elseif (strlen($senha) < 6) {
            $erro = 'A senha deve ter pelo menos 6 caracteres.';
        } elseif ($senha !== $confirmar) {
            $erro = 'As senhas não coincidem.';
        } else {
            $model = new User();

            if ($model->emailExists($email)) {
                $erro = 'Este e-mail já está cadastrado.';
            } else {
                $cores = ['#6b4de6', '#e85d4a', '#4ab89a', '#e8c547', '#4a90d9', '#d94a90'];
                $model->create($nome, $email, password_hash($senha, PASSWORD_BCRYPT), $cores[array_rand($cores)]);

                flash('ok', 'Conta criada! Faça login para começar.');
                $this->redirect('login');
            }
        }

        $this->view('auth/login', [
            'title' => 'Criar conta',
            'tab' => 'register',
            'erro' => $erro,
            'ok' => null,
        ], '');
    }

    public function logout(): void
    {
        $_SESSION = [];

        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000, $params['path'], $params['domain'] ?? '', $params['secure'], $params['httponly']);
        }

        session_destroy();
        $this->redirect('login');
    }
}
