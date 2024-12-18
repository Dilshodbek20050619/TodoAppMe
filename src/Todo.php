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
}