<?php
namespace App;

//use SQLITE;
use SQLITE3;
class User
{
    private SQLITE3 $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }

    public function all(): array
    {
        $multiArray = [];
        $results = $this->db->query("SELECT * FROM users");

        while($result = $results->fetchArray(SQLITE3_BOTH)) {
            $multiArray[] = $result;
        }
        return $multiArray;
    }

    public function find(int $id): array|false
    {
        $stmt = $this->db->query("SELECT * FROM users WHERE id = ?");
        return $stmt->fetchArray();
    }

    public function create(string $name, string $email): void
    {
        $stmt = $this->db->query("INSERT INTO users (name, email) VALUES ('$name', '$email')");
    }

    public function update(int $id, string $name, string $email): void
    {
        $stmt = $this->db->exec("UPDATE users SET name = '$name', email = '$email' WHERE id = '$id'");
    }

    public function delete(int $id): void
    {
        $stmt = $this->db->exec("DELETE FROM users WHERE id = '$id'");
    }
}

