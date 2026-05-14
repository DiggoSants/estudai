<?php

declare(strict_types=1);

namespace App\Core;

final class Router
{
    private array $routes = [];

    public function get(string $path, array $handler): void
    {
        $this->add('GET', $path, $handler);
    }

    public function post(string $path, array $handler): void
    {
        $this->add('POST', $path, $handler);
    }

    private function add(string $method, string $path, array $handler): void
    {
        $this->routes[] = [
            'method' => $method,
            'path' => '/' . trim($path, '/'),
            'handler' => $handler,
        ];
    }

    public function dispatch(string $uri, string $method): void
    {
        $path = $this->normalizePath($uri);

        foreach ($this->routes as $route) {
            if ($route['method'] !== $method) {
                continue;
            }

            $params = $this->match($route['path'], $path);

            if ($params !== null) {
                [$controllerClass, $action] = $route['handler'];
                $controller = new $controllerClass();
                $controller->{$action}(...$params);
                return;
            }
        }

        http_response_code(404);
        echo 'Pagina nao encontrada.';
    }

    private function normalizePath(string $uri): string
    {
        $path = parse_url($uri, PHP_URL_PATH) ?: '/';
        $basePath = parse_url(APP_URL, PHP_URL_PATH) ?: '';

        if ($basePath !== '' && str_starts_with($path, $basePath)) {
            $path = substr($path, strlen($basePath)) ?: '/';
        }

        return '/' . trim($path, '/');
    }

    private function match(string $routePath, string $requestPath): ?array
    {
        $pattern = preg_replace('#\{([a-zA-Z_][a-zA-Z0-9_]*)\}#', '([^/]+)', $routePath);
        $pattern = '#^' . $pattern . '$#';

        if (! preg_match($pattern, $requestPath, $matches)) {
            return null;
        }

        array_shift($matches);

        return $matches;
    }
}
