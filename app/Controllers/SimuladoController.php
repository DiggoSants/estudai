<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;

final class SimuladoController extends Controller
{
    public function index(): void
    {
        requireLogin();

        $this->view('simulado/index', [
            'title' => 'Novo Simulado',
        ], '');
    }
}
