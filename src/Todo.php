<?php
namespace App;
use \PDO;
class Todo
{
    private $db;

    public function __construct()
    {
        $this->db = new DB();
    }

    public function get(int $user_id)
    {
        $stmt = $this->db->conn->prepare("SELECT * FROM todo WHERE user_id=:user_id");
        $stmt->execute([
            'user_id' => $user_id
        ]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function store($title, $due_date, $status,$user_id)
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

    public function updateStatus($task_id, $status)
    {
        $stmt = $this->db->conn->prepare("UPDATE todo SET status = :status, updated_at = NOW() WHERE id = :id");
        $stmt->bindParam(':id', $task_id);
        $stmt->bindParam(':status', $status);
        $stmt->execute();
    }

    public function delete($task_id)
    {
        $stmt = $this->db->conn->prepare("DELETE FROM todo WHERE id = :id");
        $stmt->bindParam(':id', $task_id);
        $stmt->execute();
    }
    public function getById($id) {
        $stmt = $this->db->conn->prepare("SELECT * FROM todo WHERE id = :id LIMIT 1");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function update($id, $title, $due_date, $status) {
        $stmt = $this->db->conn->prepare("
        UPDATE todo 
        SET title = :title, due_date = :due_date, status = :status, updated_at = NOW() 
        WHERE id = :id
    ");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':due_date', $due_date);
        $stmt->bindParam(':status', $status);
        $stmt->execute();
    }

}