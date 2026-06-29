<?php

require_once __DIR__ . "/../service/PessoaService.php";
require_once __DIR__ . "/../models/Pessoa.php";

class PessoaController
{
    private PessoaService $pessoaService;

    public function __construct(PessoaService $pessoaService)
    {
        $this->pessoaService = $pessoaService;
    }

    public function create(Pessoa $pessoa): string
    {
        if (!$this->pessoaService->validarNome($pessoa->getNome())) {

            http_response_code(400);

            return json_encode([
                'success' => false,
                'message' => 'Nome inválido.'
            ]);
        }

        $success = $this->pessoaService->criarPessoa($pessoa);

        if (!$success) {

            http_response_code(500);

            return json_encode([
                'success' => false,
                'message' => 'Erro ao salvar pessoa.'
            ]);
        }

        http_response_code(201);

        return json_encode([
            'success' => true,
            'message' => 'Pessoa criada com sucesso.'
        ]);
    }

    public function show() {}

    public function edit() {}

    public function delete($id)
    {
        $success = $this->pessoaService->deletarPessoa($id);
        if ($success) {
            http_response_code(200);
        } else {
            http_response_code(400);
        }
        echo $success;
    }
}
