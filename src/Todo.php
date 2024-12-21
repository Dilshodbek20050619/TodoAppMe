<?php

namespace App;

use \PDO;
use PDOException;
use Redis;

class Todo
{
    private $redis;
    private $db;
    private $pdo;

    public function __construct()
    {
        $this->redis = new Redis();
        $this->redis->connect('127.0.0.1', 6379);
        $this->db = new DB();
        $this->pdo = $this->db->conn;
    }

    public function setPendingEditTask($chatId, $taskId): void
    {
        $this->redis->set("pending_edit_task:$chatId", $taskId);
    }

    public function hasPendingEditTask($chatId): bool|int|Redis
    {
        return $this->redis->exists("pending_edit_task:$chatId");
    }

    public function getPendingEditTaskId($chatId) {
        return $this->redis->get("pending_edit_task:$chatId");
    }

    public function clearPendingEditTask($chatId): void
    {
        $this->redis->del("pending_edit_task:$chatId");
    }

    public function get(int $user_id)
    {
        $stmt = $this->db->conn->prepare("SELECT * FROM todo WHERE user_id=:user_id");
        $stmt->execute([
            'user_id' => $user_id
        ]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function store($title, $due_date, $status, $user_id)
    {
        $stmt = $this->db->conn->prepare(
            "INSERT INTO todo (title, status, due_date, created_at, updated_at,user_id) VALUES (:title, :status, :due_date, NOW(), NOW(),:user_id)"
        );
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':due_date', $due_date);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
    }

    public function delete($id)
    {
        $id = (int)$id;
        $stmt = $this->db->conn->prepare("DELETE FROM todo WHERE id = :id");
        $stmt->execute([
            'id' => $id
        ]);

    }


    public function getById($id)
    {
        $id = (int)$id;
        $stmt = $this->db->conn->prepare("SELECT * FROM todo WHERE id = :id LIMIT 1");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update($id, $title, $due_date, $status)
    {

        $stmt = $this->db->conn->prepare("
        UPDATE todo 
        SET title = :title, due_date = :due_date, status = :status, updated_at = NOW() 
        WHERE id = :id
    ");
        $stmt->execute([
            'id' => $id,
            'title' => $title,
            'due_date' => $due_date,
            'status' => $status]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getTasksByChatId(int $chatId): array
    {
        try {
            $query = "
            SELECT t.* 
            FROM todo t
            INNER JOIN users u ON t.user_id = u.id
            WHERE u.telegram_id = :chatId
        ";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute([':chatId' => $chatId]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('Database Error: ' . $e->getMessage());
            return [];
        }
    }

    public function setTelegramId(int $userId, int $chatId): void
    {
        $query = 'UPDATE users SET telegram_id = :chatId WHERE id = :userId';
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([
            ':chatId' => $chatId,
            ':userId' => $userId
        ]);
    }

    public function updateTaskStatus(int $taskId, string $newStatus): bool
    {
        try {
            $query = 'UPDATE todo SET status = :status WHERE id = :taskId';
            $stmt = $this->pdo->prepare($query);

            // Parametrlarni biriktirish va bajarish
            $stmt->execute([
                ':status' => $newStatus,
                ':taskId' => $taskId
            ]);
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            error_log('Database Error: ' . $e->getMessage());
            return false;
        }
    }

    public function getTaskById(int $taskId): ?array
    {
        $query = 'SELECT * FROM todo WHERE id = :taskId';
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([':taskId' => $taskId]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    public function updateTaskTitle($taskId, $newTitle): bool
    {
        try {
            $query = "UPDATE todo SET title = :newTitle WHERE id = :taskId";
            $stmt = $this->pdo->prepare($query);

            // bindValue ishlatish - faqat bir marta qiymatni bog'laydi
            $stmt->bindValue(':newTitle', $newTitle);
            $stmt->bindValue(':taskId', $taskId, PDO::PARAM_INT);

            // So'rovni bajarish
            if ($stmt->execute()) {
                return true;
            } else {
                error_log("Failed to update task title, no rows affected.");
                return false;
            }
        } catch (PDOException $e) {
            // Xatolikni loglash
            error_log("Failed to update task title: " . $e->getMessage());
            return false;
        }
    }

}