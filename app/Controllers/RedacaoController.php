<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;

final class RedacaoController extends Controller
{
    public function index(): void
    {
        requireLogin();

        $this->view('redacao/index', [
            'title' => 'Oficina de Redação',
        ], '');
    }
}
