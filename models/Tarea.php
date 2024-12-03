<?php

require_once 'db.php';

class Tarea
{
    private $db;

    public function __construct()
    {
        $this->db = getDbConnection();
    }

    public function getAllTasks()
    {
        $stmt = $this->db->query("SELECT * FROM tareas");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTaskById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM tareas WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createTask($nombre, $descripcion, $estado, $nivel, $fechaVencimiento, $categoriaId)
    {
        $stmt = $this->db->prepare("INSERT INTO tareas (nombre, descripcion, estado, nivel, fecha_vencimiento, categoria_id) VALUES (:nombre, :descripcion, :estado, :nivel, :fecha_vencimiento, :categoria_id)");
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':descripcion', $descripcion);
        $stmt->bindParam(':estado', $estado);
        $stmt->bindParam(':nivel', $nivel);
        $stmt->bindParam(':fecha_vencimiento', $fechaVencimiento);
        $stmt->bindParam(':categoria_id', $categoriaId);
        $stmt->execute();
        return $this->db->lastInsertId();
    }

    public function updateTask($id, $nombre, $descripcion, $estado, $nivel, $fechaVencimiento, $categoriaId)
    {
        $stmt = $this->db->prepare("UPDATE tareas SET nombre = :nombre, descripcion = :descripcion, estado = :estado, nivel = :nivel, fecha_vencimiento = :fecha_vencimiento, categoria_id = :categoria_id WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':descripcion', $descripcion);
        $stmt->bindParam(':estado', $estado);
        $stmt->bindParam(':nivel', $nivel);
        $stmt->bindParam(':fecha_vencimiento', $fechaVencimiento);
        $stmt->bindParam(':categoria_id', $categoriaId);
        return $stmt->execute();
    }

    public function finishTask($id)
    {
        $stmt = $this->db->prepare("UPDATE tareas SET estado = 1  WHERE id = :id");
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function deleteTask($id)
    {
        $stmt = $this->db->prepare("DELETE FROM tareas WHERE id = :id");
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
