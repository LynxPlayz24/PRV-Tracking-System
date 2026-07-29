<?php
namespace App\Core;

/**
 * Router Class
 * Maps URL paths to Controller/Action pairs.
 * Supports parameterized routes like /student/123
 */
class Router
{
    private array $routes = [];

    /**
     * Register a GET route
     */
    public function get(string $path, string $controller, string $action): void
    {
        $this->routes['GET'][$path] = ['controller' => $controller, 'action' => $action];
    }

    /**
     * Register a POST route
     */
    public function post(string $path, string $controller, string $action): void
    {
        $this->routes['POST'][$path] = ['controller' => $controller, 'action' => $action];
    }

    /**
     * Dispatch the current request to the matched route
     */
    public function dispatch(string $uri, string $method): void
    {
        // Clean URI: remove query string and trailing slash
        $uri = parse_url($uri, PHP_URL_PATH);
        $uri = rtrim($uri, '/') ?: '/';

        // Remove base path (for subfolder installations)
        $basePath = $this->getBasePath();
        if ($basePath && strpos($uri, $basePath) === 0) {
            $uri = substr($uri, strlen($basePath)) ?: '/';
        }

        $method = strtoupper($method);

        // Try exact match first
        if (isset($this->routes[$method][$uri])) {
            $route = $this->routes[$method][$uri];
            $this->callAction($route['controller'], $route['action']);
            return;
        }

        // Try parameterized routes (e.g., /student/{id})
        foreach ($this->routes[$method] ?? [] as $routePath => $route) {
            // M1: Use [^/]+ to match any non-slash character (supports hyphens, dots, etc.)
            $pattern = preg_replace('/\{(\w+)\}/', '([^/]+)', $routePath);
            $pattern = '#^' . $pattern . '$#';

            if (preg_match($pattern, $uri, $matches)) {
                array_shift($matches); // Remove full match
                $this->callAction($route['controller'], $route['action'], $matches);
                return;
            }
        }

        // 404
        http_response_code(404);
        require dirname(__DIR__) . '/Views/errors/404.php';
    }

    /**
     * Instantiate controller and call action
     */
    private function callAction(string $controller, string $action, array $params = []): void
    {
        $controllerClass = "App\\Controllers\\{$controller}";

        if (!class_exists($controllerClass)) {
            throw new \RuntimeException("Controller {$controllerClass} not found");
        }

        $controllerInstance = new $controllerClass();

        if (!method_exists($controllerInstance, $action)) {
            throw new \RuntimeException("Action {$action} not found in {$controllerClass}");
        }

        call_user_func_array([$controllerInstance, $action], $params);
    }

    /**
     * Determine the base path for subfolder installations
     */
    private function getBasePath(): string
    {
        $scriptName = $_SERVER['SCRIPT_NAME'] ?? '';
        $basePath = str_replace('\\', '/', dirname($scriptName));
        if (substr($basePath, -7) === '/public') {
            $basePath = substr($basePath, 0, -7);
        }
        return $basePath === '/' ? '' : $basePath;
    }
}
