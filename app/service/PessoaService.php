<?php
require_once __DIR__ . "/../repository/PessoaRepository.php";

class PessoaService
{
    public PessoaRepository $pessoaRepository;

    public function __construct(PessoaRepository $pessoaRepository)
    {
        $this->pessoaRepository = $pessoaRepository;
    }

    public function validarNome(string $nome): bool
    {
        if (strlen($nome) <= 100)
            return true;
        return false;
    }

    public function criarPessoa(Pessoa $pessoa)
    {
        if ($this->validarNome($pessoa->getNome()))
            return $this->pessoaRepository->insertPessoa($pessoa->getNome());

        return null;
    }

    public function deletarPessoa($id)
    {
        return $this->pessoaRepository->deletar($id);
    }
}
