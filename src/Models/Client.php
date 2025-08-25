<?php
require_once __DIR__ . '/../Core/Database.php';

class Client {
    private PDO $db; 
    public function __construct() { $this->db = (new Database())->pdo; }

    public function all(): array {
        $stmt = $this->db->query(query: "SELECT * FROM clients ORDER BY id DESC");
        return $stmt->fetchAll(mode: PDO::FETCH_ASSOC); //retorna em formato de array
    }

    public function find(int $id): mixed {
        $stmt = $this->db->prepare(query: "SELECT * FROM clients WHERE id = ?");
        //prepare -> pq o "?" vai ser preenchido depois pelo execute, quando tiver variaveis
        $stmt->execute(params: [$id]); //executa o query substituindo o ? poir $id
        return $stmt->fetch(mode: PDO::FETCH_ASSOC);
    }

    public function create(array $data): bool {
        $stmt = $this->db->prepare(
            query: "INSERT INTO clients (name, email, cpf, phone) VALUES (:name, :email, :cpf, :phone)"
        );
        return $stmt->execute(params: [
            ':name'  => $data['name'],
            ':email' => $data['email'],
            ':cpf'   => $data['cpf'],
            ':phone' => $data['phone'] ?? null,
        ]);
    }

    public function update(int $id, array $data): bool {
        $stmt = $this->db->prepare(
            query: "UPDATE clients SET name=:name, email=:email, cpf=:cpf, phone=:phone WHERE id=:id"
        );
        return $stmt->execute(params: [
            ':name'  => $data['name'],
            ':email' => $data['email'],
            ':cpf'   => $data['cpf'],
            ':phone' => $data['phone'] ?? null,
            ':id'    => $id
        ]);
    }

    public function delete(int $id): bool {
        $stmt = $this->db->prepare(query: "DELETE FROM clients WHERE id = ?");
        return $stmt->execute(params: [$id]);
    }

    public function existsEmail(string $email, ?int $ignoreId = null): bool {
        $sql = "SELECT id FROM clients WHERE email = ?";
        $params = [$email];
        if ($ignoreId) { $sql .= " AND id <> ?"; $params[] = $ignoreId; }
        $stmt = $this->db->prepare(query: $sql); $stmt->execute(params: $params);
        return (bool)$stmt->fetch();
    }

    public function existsCpf(string $cpf, ?int $ignoreId = null): bool {
        $sql = "SELECT id FROM clients WHERE cpf = ?";
        $params = [$cpf];
        if ($ignoreId) { $sql .= " AND id <> ?"; $params[] = $ignoreId; }
        $stmt = $this->db->prepare(query: $sql); $stmt->execute(params: $params);
        return (bool)$stmt->fetch();
    }
}
