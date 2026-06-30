<?php
require_once __DIR__ . "/../repository/PessoaRepository.php"; // conecta ao repositório para usar as classes, receber e enviar dados.

class PessoaService
{
    public PessoaRepository $pessoaRepository; // puxa os dados do repositório em pessoaRepositório.php ler primeiro lá.

    public function __construct(PessoaRepository $pessoaRepository)
    {
        $this->pessoaRepository = $pessoaRepository; // pega tudo criado em pessoaRepositório.php.
    }

    public function validarNome(string $nome): bool // comparação de tamanho que vai ver se é true ou false então declarar como boolean
    {
        if (strlen($nome) <= 100) // strlen conta os caracteres e tem que ser menor igual a 100.
            return true; // sai do if com o return true e ignora o false(se o bool for true).
        return false; // se o return acima falhar vai executar isso.
    }

    public function criarPessoa(Pessoa $pessoa) // cria um objeto Pessoa = $pessoa
    {
        // passa o parametro para verificar o nome, $pessoa usa a classe getNome() que existe em Pessoa.php. verificando se tem menos de 100 e se tudo de true:
        if ($this->validarNome($pessoa->getNome())) 
            return $this->pessoaRepository->insertPessoa($pessoa->getNome()); // return um objeto novo que vai ser enviado para o Repostório.

        return null; // caso falhe o processo de criar o objeto novo para o repositório vai retornar nulo.
    }

    public function deletarPessoa($id) // função para deletar por ID, precisa de ajuste.
    {
        return $this->pessoaRepository->deletar($id);
    }
}
