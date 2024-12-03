<?php

require_once 'models/Categoria.php';

class CategoriaController
{
    private $categoriaModel;

    public function __construct()
    {
        $this->categoriaModel = new Categoria();
    }

    public function getAllCategories()
    {
        $categories = $this->categoriaModel->getAllCategories();
        return json_encode($categories);
    }

    public function getCategoryById($id)
    {
        $category = $this->categoriaModel->getCategoryById($id);
        if ($category) {
            echo json_encode($category);
        } else {
            http_response_code(404);
            echo json_encode(["message" => "Categoría no encontrada"]);
        }
    }

    public function createCategory()
    {
        $input = json_decode(file_get_contents('php://input'), true);
        if (!isset($input['nombre'])) {
            http_response_code(400);
            echo json_encode(["message" => "Datos incompletos"]);
            return;
        }

        $categoryId = $this->categoriaModel->createCategory($input['nombre']);
        echo json_encode(["message" => "Categoría creada", "id" => $categoryId]);
    }

    public function updateCategory()
    {
        $input = json_decode(file_get_contents('php://input'), true);
        if (!isset($input['id']) || !isset($input['nombre'])) {
            http_response_code(400);
            echo json_encode(["message" => "Datos incompletos"]);
            return;
        }

        $this->categoriaModel->updateCategory($input['id'], $input['nombre']);
        echo json_encode(["message" => "Categoría actualizada"]);
    }

    public function deleteCategory($id)
    {
        $this->categoriaModel->deleteCategory($id);
        echo json_encode(["message" => "Categoría eliminada"]);
    }
}
