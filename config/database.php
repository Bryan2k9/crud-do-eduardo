<?php

$dsn = 'mysql:host=localhost;dbname=api_sistema;charset=utf8mb4'; 
$usuario = 'root';
$senha = '';

try {
    //Cria a conexão:
    $pdo = new PDO($dsn, $usuario, $senha);
    //serve para caso de erro:
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // echo "Erro na conexão: " . $e->getMessage(); em API não pode usar echo pq o user não deve saber sobre a resposta.
    # melhor:

    # métodos: getMessage() , getCode() , getLine() e getFile().
    // $e->getMessage(); // Mensagem do erro
    // $e->getCode();    // Código do erro
    // $e->getFile();    // Arquivo onde ocorreu
    // $e->getLine();    // Linha do erro 
    console_log($e->getMessage()); // O dev pode consultar o erro no log e o user não.
    
    http_response_code(500); // Erro 500 (Internal Server Error). 
    exit(json_encode([
        "Erro" => "Falha interna do servidor"          
    ]);
}
