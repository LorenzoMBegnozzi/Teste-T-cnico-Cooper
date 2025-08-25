<?php
class Database {
    private string $host = 'db';
    private string $db   = 'tat_db';
    private string $user = 'root';
    private string $pass = 'root';
    public PDO $pdo;

    public function __construct() {
        try {
            $this->pdo = new PDO(
                dsn: "mysql:host={$this->host};dbname={$this->db};charset=utf8mb4",
                username: $this->user,
                password: $this->pass,
                options: [ PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION ]
            );
        } catch (PDOException $e) {
            http_response_code(response_code: 500);
            die('Erro de conexão com o banco: ' . $e->getMessage());
        }
    }
}
