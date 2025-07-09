<?php

namespace App\Core;

use App\Http\Request;
use App\Http\Response;

class Router
{
    private static array $routes = [];

    private static function addRoute($method, $route, $action)
    {
        self::$routes[] = [
            'METHOD' => $method,
            'ROUTE' => self::treatRoute($route),
            'ACTION' => explode('@', $action)
        ];
    }

    protected static function treatRoute($uri)
    {
        return rtrim($uri, '/') . '/';
    }

    public static function get($route, $action)
    {
        self::addRoute(Request::METHOD_GET, $route, $action);
    }

    public static function post($route, $action)
    {
        self::addRoute(Request::METHOD_POST, $route, $action);
    }

    public static function put($route, $action)
    {
        self::addRoute(Request::METHOD_PUT, $route, $action);
    }

    public static function delete($route, $action)
    {
        self::addRoute(Request::METHOD_DELETE, $route, $action); // ✅ corrigido
    }

    public function dispatch($url)
    {
        self::verifyRoute($this->treatRoute($url), self::$routes);
    }

    public function getRoutes(): array
    {
        return self::$routes;
    }

    private static function verifyRoute($url, $routes)
    {
        $routeFound = false;

        foreach ($routes as $route) {

            if ($_SERVER['REQUEST_METHOD'] !== $route['METHOD']) {
                continue;
            }

            // Transforma "/api/items/{id}/" em regex "/api/items/([\w\.-]+)/"
            $regex = '/\{([\w]+)\}/';
            $pattern = preg_replace($regex, '([\w\.-]+)', $route['ROUTE']);
            $pattern = str_replace('/', '\/', $pattern);
            $pattern = '/^' . $pattern . '$/';

            if (preg_match($pattern, $url, $matches)) {
                $routeFound = true;
                [$class, $method] = $route['ACTION'];
                array_shift($matches); // Remove o match completo

                try {
                    $instance = new $class();
                    $instance->$method(...$matches);
                    return;
                } catch (\ArgumentCountError $th) {
                    Response::json([
                        'error' => true,
                        'message' => 'Parâmetros ausentes no controller.',
                        'details' => $th->getMessage()
                    ], 500);
                    return;
                } catch (\Throwable $th) {
                    Response::json([
                        'error' => true,
                        'message' => 'Erro interno no servidor.',
                        'details' => $th->getMessage()
                    ], 500);
                    return;
                }
            }
        }

        if (!$routeFound) {
            Response::json([
                'error' => true,
                'message' => 'Rota não encontrada.'
            ], 404);
        }
    }
}
