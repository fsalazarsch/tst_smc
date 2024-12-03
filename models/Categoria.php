<?php

require_once 'db.php';

class Categoria
{
    private $db;

    public function __construct()
    {
        $this->db = getDbConnection();
    }

    public function getAllCategories()
    {
        $stmt = $this->db->query("SELECT id, nombre FROM categorias");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCategoryById($id)
    {
        $stmt = $this->db->prepare("SELECT id, nombre FROM categorias WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createCategory($nombre)
    {
        $stmt = $this->db->prepare("INSERT INTO categorias (nombre) VALUES (:nombre)");
        $stmt->bindParam(':nombre', $nombre);
        $stmt->execute();
        return $this->db->lastInsertId();
    }

    public function updateCategory($id, $nombre)
    {
        $stmt = $this->db->prepare("UPDATE categorias SET nombre = :nombre WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':nombre', $nombre);
        return $stmt->execute();
    }

    public function deleteCategory($id)
    {
        $stmt = $this->db->prepare("DELETE FROM categorias WHERE id = :id");
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
