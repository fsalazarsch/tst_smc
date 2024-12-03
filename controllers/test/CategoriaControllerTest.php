<?php

use PHPUnit\Framework\TestCase;

require_once 'controllers/CategoriaController.php';
require_once 'models/Categoria.php';

class CategoriaControllerTest extends TestCase
{
    private $categoriaController;
    private $categoriaModelMock;

    protected function setUp(): void
    {
        $this->categoriaModelMock = $this->createMock(Categoria::class);
        $this->categoriaController = new CategoriaController();
        $this->categoriaController->categoriaModel = $this->categoriaModelMock;
    }

    public function testGetAllCategories()
    {
        $this->categoriaModelMock->method('getAllCategories')->willReturn([
            ['id' => 1, 'nombre' => 'Categoría 1'],
            ['id' => 2, 'nombre' => 'Categoría 2'],
        ]);

        ob_start();
        $this->categoriaController->getAllCategories();
        $output = ob_get_clean();

        $expected = json_encode([
            ['id' => 1, 'nombre' => 'Categoría 1'],
            ['id' => 2, 'nombre' => 'Categoría 2'],
        ]);

        $this->assertJsonStringEqualsJsonString($expected, $output);
    }

    public function testGetCategoryById_CategoryFound()
    {
        $categoryId = 1;
        $this->categoriaModelMock->method('getCategoryById')->with($categoryId)->willReturn([
            'id' => 1,
            'nombre' => 'Categoría 1'
        ]);

        ob_start();
        $this->categoriaController->getCategoryById($categoryId);
        $output = ob_get_clean();

        $expected = json_encode([
            'id' => 1,
            'nombre' => 'Categoría 1'
        ]);

        $this->assertJsonStringEqualsJsonString($expected, $output);
    }

    public function testGetCategoryById_CategoryNotFound()
    {
        $categoryId = 99;
        $this->categoriaModelMock->method('getCategoryById')->with($categoryId)->willReturn(null);

        ob_start();
        $this->categoriaController->getCategoryById($categoryId);
        $output = ob_get_clean();

        $expected = json_encode(["message" => "Categoría no encontrada"]);

        $this->assertJsonStringEqualsJsonString($expected, $output);
    }

    public function testCreateCategory_Success()
    {
        $input = [
            'nombre' => 'Categoría 1',
        ];

        file_put_contents('php://input', json_encode($input));

        $this->categoriaModelMock->method('createCategory')->willReturn(1);

        ob_start();
        $this->categoriaController->createCategory();
        $output = ob_get_clean();

        $expected = json_encode([
            "message" => "Categoría creada",
            "id" => 1,
        ]);

        $this->assertJsonStringEqualsJsonString($expected, $output);
    }

    public function testUpdateCategory_Success()
    {
        $input = [
            'id' => 1,
            'nombre' => 'Categoría Actualizada',
        ];

        file_put_contents('php://input', json_encode($input));

        $this->categoriaModelMock->expects($this->once())
            ->method('updateCategory')
            ->with($input['id'], $input['nombre']);

        ob_start();
        $this->categoriaController->updateCategory();
        $output = ob_get_clean();

        $expected = json_encode(["message" => "Categoría actualizada"]);

        $this->assertJsonStringEqualsJsonString($expected, $output);
    }

    public function testDeleteCategory_Success()
    {
        $categoryId = 1;

        $this->categoriaModelMock->expects($this->once())
            ->method('deleteCategory')
            ->with($categoryId);

        ob_start();
        $this->categoriaController->deleteCategory($categoryId);
        $output = ob_get_clean();

        $expected = json_encode(["message" => "Categoría eliminada"]);

        $this->assertJsonStringEqualsJsonString($expected, $output);
    }
}
?>
