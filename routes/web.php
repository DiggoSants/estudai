<?php

declare(strict_types=1);

use App\Controllers\HomeController;
use App\Controllers\AuthController;
use App\Controllers\DashboardController;
use App\Controllers\SimuladoController;

$router->get('/', [HomeController::class, 'index']);
$router->get('/login', [AuthController::class, 'showLogin']);
$router->post('/login', [AuthController::class, 'login']);
$router->post('/register', [AuthController::class, 'register']);
$router->get('/dashboard', [DashboardController::class, 'index']);
$router->get('/logout', [AuthController::class, 'logout']);
$router->get('/simulado', [SimuladoController::class, 'index']);
$router->post('/simulado/iniciar', [SimuladoController::class, 'iniciar']);
$router->get('/simulado/{id}', [SimuladoController::class, 'show']);
$router->post('/simulado/{id}/finalizar', [SimuladoController::class, 'finalizar']);
$router->get('/simulado/{id}/resultado', [SimuladoController::class, 'resultado']);

// Aliases temporarios para compatibilidade com os arquivos originais.
$router->get('/login.php', [AuthController::class, 'showLogin']);
$router->post('/login.php', [AuthController::class, 'login']);
$router->get('/dashboard.php', [DashboardController::class, 'index']);
$router->get('/logout.php', [AuthController::class, 'logout']);
$router->get('/simulado.php', [SimuladoController::class, 'index']);
