<?php

require_once __DIR__ . "/../config/database.php";

require_once __DIR__ . "/../app/models/Pessoa.php";
require_once __DIR__ . "/../app/repository/PessoaRepository.php";
require_once __DIR__ . "/../app/service/PessoaService.php";
require_once __DIR__ . "/../app/controllers/PessoaController.php";

$pessoaRepository = new PessoaRepository($pdo);
$pessoaService = new PessoaService($pessoaRepository);
$pessoaController = new PessoaController($pessoaService);

return [

    [
        'POST',
        '/pessoas/criar',
        function (array $payload) use ($pessoaController) {

            if (!isset($payload['nome'])) {

                http_response_code(400);

                return json_encode([
                    'success' => false,
                    'message' => 'Campo nome é obrigatório.'
                ]);
            }

            $pessoa = new Pessoa($payload['nome']);

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

            return $pessoaController->delete($payload['id']);
        }
    ]

];
