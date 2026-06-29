<?php

class Pessoa
{
    private int | null $id;
    private string $nome;

    public function __construct(string $nome)
    {
        $this->nome = $nome;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getNome(): string
    {
        return $this->nome;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function setNome(int $nome): void
    {
        $this->nome = $nome;
    }
}
