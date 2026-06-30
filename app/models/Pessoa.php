<?php

class Pessoa
{
    # public = Fora do código ou programa para utilizar.
    # private = Apenas dentro da classe onde foi criado.
    
    private int | null $id; // tipagem dos dados. perfeito.
    private string $nome; // tipagem dos dados. perfeito.

    public function __construct(string $nome) // contruct serve para criar um new object e nesse caso fizemos um objeto com uma var tipo string que recebe algum valor.
    {
        $this->nome = $nome; // this é para dizer que queremos acessar algo no objeto nome e por o valor da var, tipo $nome = "Nícolas Gostoso";  $this->nome = $nome.
    }

    // ID pode ser null então melhorei colocando ? antes do int
    public function getId(): ?int
    {
        return $this->id; // pega o ID recebido pelo sistema.
    }

    public function getNome(): string
    {
        return $this->nome; // pega o nome recebido pelo sistema.
    }

    public function setId(int $id): void
    {
        $this->id = $id; // seta o valor ID no banco de dados.
    }

    public function setNome(string $nome): void
    {
        $this->nome = $nome; // seta o nome no banco de dados.
    }
}
