<?php

require_once __DIR__ . "/../service/PessoaService.php"; // conecta ao repositório para usar as classes, receber e enviar dados.
require_once __DIR__ . "/../models/Pessoa.php"; // pegar os dados que existem da pessoa criada e estão em Pessoa.php.

class PessoaController
{
    private PessoaService $pessoaService; // puxa a classe $pessoaService, ler primerio o pessoaService.php.

    public function __construct(PessoaService $pessoaService) // criando objeto PessoaService = $pessoaService.
    {
        $this->pessoaService = $pessoaService;
    }

    public function create(Pessoa $pessoa): string
    {
        if (!$this->pessoaService->validarNome($pessoa->getNome())) { // Se não achar um objeto nome criado ou inválido que foi feito na classe em PessoaService.php.

            http_response_code(400);

            return json_encode([
                'success' => false,
                'message' => 'Nome inválido.'
            ]);
        }

        $success = $this->pessoaService->criarPessoa($pessoa); // if de cima de false então cria um objeto $pessoa com a classe criarPessoa() de PessoaService.php.

        if (!$success) { // caso ocorra algum erro inesperado.

            http_response_code(500);

            return json_encode([
                'success' => false,
                'message' => 'Erro ao salvar pessoa.'
            ]);
        }

        http_response_code(201); // caso execute tudo corretamente.

        return json_encode([
            'success' => true,
            'message' => 'Pessoa criada com sucesso.'
        ]);
    }

    public function show() {} // em falta 

    public function edit() {} // em falta

    public function delete($id) // falta ajuste, $id não declarado.
    {
        $success = $this->pessoaService->deletarPessoa($id); // usa a função deletarPessoa() existente em PessoaService.php.
        if ($success) {
            http_response_code(200);
        } else {
            http_response_code(400);
        }
        echo $success;
    }
}
