<?php

header('Content-Type: application/json');

define('BASE_PATH', dirname(__DIR__));

// URI
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$basePath = dirname($_SERVER['SCRIPT_NAME']);

if ($basePath !== '/' && str_starts_with($uri, $basePath)) {
    $uri = substr($uri, strlen($basePath));
}

$uri = '/' . trim($uri, '/');

// Método HTTP
$method = $_SERVER['REQUEST_METHOD'];

// Body JSON
$payload = json_decode(file_get_contents('php://input'), true);

if (!is_array($payload)) {
    $payload = [];
}

// Rotas
$routes = require BASE_PATH . '/routes/routes.php';

$routeFound = false;

foreach ($routes as $route) {

    [$routeMethod, $routeUri, $callback] = $route;

    if ($method === $routeMethod && $uri === $routeUri) {

        $routeFound = true;

        $response = $callback($payload);

        if ($response !== null) {
            echo $response;
        }

        exit;
    }
}

http_response_code(404);

echo json_encode([
    'success' => false,
    'message' => 'Rota não encontrada.'
]);
