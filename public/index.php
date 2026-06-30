<?php

header('Content-Type: application/json'); // Diz que tu vai ser em JSON e apenas isso.

define('BASE_PATH', dirname(__DIR__)); // Descobrir a pasta raíz do projeto para não escrever caminhos enormes.

// URI
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH); // pegar a rota, http://localhost/pessoas/criar?id=5 = /pessoas/criar

// http://localhost/crud/public/index.php o $_SERVER['SCRIPT_NAME'] verificar o URL e retorna o importante /crud/public/index.php
// dirname() = retorna /crud/public
//$basePath = /crud/public
$basePath = dirname($_SERVER['SCRIPT_NAME']); 

// $basePath !== '/' para ver se não está na raíz "http://localhost/" necessário para remover a base caso http://localhost/crud/public/index.php assim sobrando o importante: "/crud/public"
// str_starts_with para comparar se $uri começa com String de $basePath, $uri = "/crud/public/pessoas"; $basePath = "/crud/public"; e começa então retorna um True.
if ($basePath !== '/' && str_starts_with($uri, $basePath)) { 
    $uri = substr($uri, strlen($basePath)); // strlen conta os caracteres semelhantes vistos em str_starts_with e substr remove esse caracteres. "indo de /crud/public/pessoas" vira "/pessoas"
}

$uri = '/' . trim($uri, '/'); // remove a / do começo e do fim (se tiver) sendo /pessoas virá pessoas.

// Método HTTP
$method = $_SERVER['REQUEST_METHOD']; // pegar o método GET, POST, PUT, DELETE.

// Body JSON
$payload = json_decode(file_get_contents('php://input'), true); // ler o corpo da requisição JSON.

if (!is_array($payload)) { // verifica se veio um array JSON, caso não seja cria um array vázio.
    $payload = [];
}

// Rotas
$routes = require BASE_PATH . '/routes/routes.php'; // pede o corpo de requisição e enviar para o route para pedir uma rota em routes.php.

$routeFound = false; //inicia falso para executar só depois

// pega cada rota no routes.php (criar ou deletar):
foreach ($routes as $route) { 

    //serve para eficiência dando valor para um array de forma mais rápida em vez de fazer parte a parte array por array.
    //$routeMethod = GET, POST, PUT, DELETE.
    //$routeUri = /pessoas/criar ou deletar ETC.
    //$callback = método escolhido que tem em routes.php exemplo: 'POST', '/pessoas/criar'.
    // faz um $route = [POST, /pessoas/criar ou /pessoas/deletar, retorna = 'POST/pessoas/criar' ou 'POST/pessoas/deletar'].
    //mas ele já poem cada coisa em sua posição sem precisar chamar ou especificar, tipo $route[0] = $routeMethod.
    [$routeMethod, $routeUri, $callback] = $route; 
    
    if ($method === $routeMethod && $uri === $routeUri) { //verificando se é do método existente e permitido e verificando se tem uma rota existente para a função.

        $routeFound = true; // deu certo então agora fica true.

        $response = $callback($payload); // calback agora recebe as infos via método tipo isso: POST/pessoas/criar?nome="Nícolas_Fodastico".

        if ($response !== null) { // verifica se é extritamente diferente de nulo.
            echo $response;
        }

        exit; // sair da estrutura e terminar o código voltando para a página anterior e não executando mais nada.
    }
}

http_response_code(404); // executa caso o if acima falhar.

echo json_encode([
    'success' => false,
    'message' => 'Rota não encontrada.'
]);
