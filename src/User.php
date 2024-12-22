<?php

namespace App;

use PDO;
use PDOException;

class User
{
    public $pdo;

    public function __construct()
    {
        $db = new DB();
        $this->pdo = $db->conn;
    }

    public function isEmailExist(string $email): bool
    {
        $query = 'SELECT COUNT(*) FROM users WHERE email = :email';
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([':email' => $email]);
        return $stmt->fetchColumn() > 0; // Agar email mavjud bo'lsa, true qaytaradi
    }

    // Ro'yxatdan o'tish metodi
    public function register(string $fullName, string $email, string $password): mixed
    {
        if ($this->isEmailExist($email)) {
            echo "Bu email allaqachon ro'yxatdan o'tgan!";
            return false;
        }

        $query = 'INSERT INTO users (full_name, email, password) VALUES (:full_name, :email, :password)';
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([
            ':full_name' => $fullName,
            ':email' => $email,
            ':password' => password_hash($password, PASSWORD_DEFAULT)
        ]);
        $id = $this->pdo->lastInsertId();
        return $this->getUserById($id);
    }

    public function getUserById(int $id): array
    {
        $query = 'SELECT * FROM users WHERE id = :id';
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function login(string $email, string $password): bool|array
    {
        try {
            $query = 'SELECT * FROM users WHERE email = :email';
            $stmt = $this->pdo->prepare($query);
            $stmt->execute([':email' => $email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user['password'])) {
                return $user;
            }
            return false;

        } catch (PDOException $e) {
            error_log("Login xatosi: " . $e->getMessage());
            return false;
        }
    }
}
