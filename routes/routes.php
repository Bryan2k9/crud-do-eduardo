<?php

require_once __DIR__ . "/../config/database.php";

require_once __DIR__ . "/../app/models/Pessoa.php";
require_once __DIR__ . "/../app/repository/PessoaRepository.php";
require_once __DIR__ . "/../app/service/PessoaService.php";
require_once __DIR__ . "/../app/controllers/PessoaController.php";

//idiciação
$pessoaRepository = new PessoaRepository($pdo); //repositório pede o banco de dados
$pessoaService = new PessoaService($pessoaRepository); //pessoaService pega as infos que o repositório pegou do PDO.
$pessoaController = new PessoaController($pessoaService); //pessoaController pega tudo pronto para utilizar do PDO.

return [ //entra aqui e retorna as rotas sempre.

    [
        'POST', //organiza o método para API
        '/pessoas/criar',
        function (array $payload) use ($pessoaController) { // $payload é um Array vázio de index.php e usa as informações do banco de dados PDO

            if (!isset($payload['nome'])) { // valida se tem algo

                http_response_code(400); 

                return json_encode([
                    'success' => false,
                    'message' => 'Campo nome é obrigatório.'
                ]);
            }
            if (empty($payload['nome'])) { // valida se não é vázio
                
                http_response_code(400); 

                return json_encode([
                    'success' => false,
                    'message' => 'Campo nome está vázio.'
                ]);
            }                                               

            $pessoa = new Pessoa($payload['nome']); // tudo certo então cria a pessoa se foi essa a rota escolhida.

            return $pessoaController->create($pessoa);
        }
    ],

    [
        'POST',
        '/pessoas/deletar',
        function (array $payload) use ($pessoaController) {

            if (!isset($payload['id'])) {

                http_response_code(400);

                return json_encode([
                    'success' => false,
                    'message' => 'Campo id é obrigatório.'
                ]);
            }
            if (empty($payload['id'])) {
                http_response_code(400);

                return json_encode([
                    'success' => false,
                    'message' => 'Campo id está vázio.'
                ]);
            }

            return $pessoaController->delete($payload['id']); //deleta os dados baseado no ID recebido
        }
    ]

];
