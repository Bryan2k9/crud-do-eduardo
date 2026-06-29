<?php
require_once __DIR__ . "/../models/Pessoa.php";

class PessoaRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function insertPessoa(string $nome): bool
    {
        $sql = "INSERT INTO pessoas (nome) VALUES (?)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$nome]);
    }

    public function findPessoaById(int $id): Pessoa | null
    {
        $sql = "SELECT * FROM pessoas WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function deletar($id)
    {
        $sqlD = "DELETE FROM pessoas WHERE id = ?";
        $stmt = $this->pdo->prepare($sqlD);
        return $stmt->execute([$id]);
    }
}
