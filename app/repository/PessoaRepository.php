<?php
require_once __DIR__ . "/../models/Pessoa.php"; // se conecta os dados feitos por Pessoa.php que foi preparado e validado antes por outra etapas.

class PessoaRepository
{
    private PDO $pdo; // seleciona o banco de dados.

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo; // faz um objeto novo para o $pdo.
    }

    public function insertPessoa(string $nome): bool // usar boolean para ver se tem um nome. faltou uma validação, entretanto executará corretamente(eu acho).
    {
        $sql = "INSERT INTO pessoas (nome) VALUES (?)";
        $stmt = $this->pdo->prepare($sql); # repare que o $this é importante até nisso já que no PDO comum só pdo->prepare($sql); seria necessário.
        return $stmt->execute([$nome]); # botando o parametro dentro do execute, padrão do modelo PDO, é o VALUES (nome).
    }
    
    // repare que usou a classe Pessoa como parametro que contem as informações junto do ID, e para ignorar faltas de dados possiveis setou null.
    public function findPessoaById(int $id): Pessoa | null 
    {
        $sql = "SELECT * FROM pessoas WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC); // é tipo o $stmt->fetch_assoc() padrão, em modelo PDO.
    }

    public function deletar($id) // básico né? preciso explicar nada eu diria.
    {
        $sqlD = "DELETE FROM pessoas WHERE id = ?";
        $stmt = $this->pdo->prepare($sqlD);
        return $stmt->execute([$id]);
    }
}
