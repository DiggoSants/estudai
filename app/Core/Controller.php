<?php

declare(strict_types=1);

namespace App\Core;

abstract class Controller
{
    protected function view(string $view, array $data = [], string $layout = 'main'): void
    {
        $viewPath = BASE_PATH . '/app/Views/' . $view . '.php';
        $layoutPath = BASE_PATH . '/app/Views/layouts/' . $layout . '.php';

        if (! file_exists($viewPath)) {
            http_response_code(500);
            echo 'View nao encontrada.';
            return;
        }

        extract($data, EXTR_SKIP);

        ob_start();
        require $viewPath;
        $content = ob_get_clean();

        if ($layout !== '' && file_exists($layoutPath)) {
            require $layoutPath;
            return;
        }

        echo $content;
    }

    protected function redirect(string $path): void
    {
        header('Location: ' . url($path));
        exit;
    }
}
