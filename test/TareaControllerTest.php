<?php

use PHPUnit\Framework\TestCase;

require_once 'controllers/TareaController.php';
require_once 'models/Tarea.php';

class TareaControllerTest extends TestCase
{
    private $tareaController;
    private $tareaModelMock;

    protected function setUp(): void
    {
        $this->tareaModelMock = $this->createMock(Tarea::class);
        $this->tareaController = new TareaController();
        $this->tareaController->tareaModel = $this->tareaModelMock;
    }

    public function testGetAllTasks()
    {
        $this->tareaModelMock->method('getAllTasks')->willReturn([
            ['id' => 1, 'nombre' => 'Tarea 1', 'descripcion' => 'Descripción 1', 'estado' => 'pendiente', 'nivel' => 'alto', 'fecha_vencimiento' => '2024-12-31', 'categoria_id' => 1],
            ['id' => 2, 'nombre' => 'Tarea 2', 'descripcion' => 'Descripción 2', 'estado' => 'en progreso', 'nivel' => 'medio', 'fecha_vencimiento' => '2024-12-25', 'categoria_id' => 2],
        ]);

        ob_start();
        $this->tareaController->getAllTasks();
        $output = ob_get_clean();

        $expected = json_encode([
            ['id' => 1, 'nombre' => 'Tarea 1', 'descripcion' => 'Descripción 1', 'estado' => 'pendiente', 'nivel' => 'alto', 'fecha_vencimiento' => '2024-12-31', 'categoria_id' => 1],
            ['id' => 2, 'nombre' => 'Tarea 2', 'descripcion' => 'Descripción 2', 'estado' => 'en progreso', 'nivel' => 'medio', 'fecha_vencimiento' => '2024-12-25', 'categoria_id' => 2],
        ]);

        $this->assertJsonStringEqualsJsonString($expected, $output);
    }

    public function testGetTaskById_TaskFound()
    {
        $taskId = 1;
        $this->tareaModelMock->method('getTaskById')->with($taskId)->willReturn([
            'id' => 1,
            'nombre' => 'Tarea 1',
            'descripcion' => 'Descripción 1',
            'estado' => 'pendiente',
            'nivel' => 'alto',
            'fecha_vencimiento' => '2024-12-31',
            'categoria_id' => 1
        ]);

        ob_start();
        $this->tareaController->getTaskById($taskId);
        $output = ob_get_clean();

        $expected = json_encode([
            'id' => 1,
            'nombre' => 'Tarea 1',
            'descripcion' => 'Descripción 1',
            'estado' => 'pendiente',
            'nivel' => 'alto',
            'fecha_vencimiento' => '2024-12-31',
            'categoria_id' => 1
        ]);

        $this->assertJsonStringEqualsJsonString($expected, $output);
    }

    public function testGetTaskById_TaskNotFound()
    {
        $taskId = 99;
        $this->tareaModelMock->method('getTaskById')->with($taskId)->willReturn(null);

        ob_start();
        $this->tareaController->getTaskById($taskId);
        $output = ob_get_clean();

        $expected = json_encode(["message" => "Tarea no encontrada"]);

        $this->assertJsonStringEqualsJsonString($expected, $output);
    }

    public function testCreateTask_Success()
    {
        $input = [
            'nombre' => 'Tarea 1',
            'descripcion' => 'Descripción 1',
            'estado' => 'pendiente',
            'nivel' => 'alto',
            'fecha_vencimiento' => '2024-12-31',
            'categoria_id' => 1,
        ];

        file_put_contents('php://input', json_encode($input));

        $this->tareaModelMock->method('createTask')->willReturn(1);

        ob_start();
        $this->tareaController->createTask();
        $output = ob_get_clean();

        $expected = json_encode([
            "message" => "Tarea creada",
            "id" => 1,
        ]);

        $this->assertJsonStringEqualsJsonString($expected, $output);
    }

    public function testUpdateTask_Success()
    {
        $input = [
            'id' => 1,
            'nombre' => 'Tarea 1',
            'descripcion' => 'Descripción 1',
            'estado' => 'en progreso',
            'nivel' => 'medio',
            'fecha_vencimiento' => '2024-12-30',
            'categoria_id' => 2,
        ];

        file_put_contents('php://input', json_encode($input));

        $this->tareaModelMock->expects($this->once())
            ->method('updateTask')
            ->with(
                $input['id'],
                $input['nombre'],
                $input['descripcion'],
                $input['estado'],
                $input['nivel'],
                $input['fecha_vencimiento'],
                $input['categoria_id']
            );

        ob_start();
        $this->tareaController->updateTask();
        $output = ob_get_clean();

        $expected = json_encode(["message" => "Tarea actualizada"]);

        $this->assertJsonStringEqualsJsonString($expected, $output);
    }

    public function testDeleteTask_Success()
    {
        $input = [
            'id' => 1,
        ];

        file_put_contents('php://input', json_encode($input));

        $this->tareaModelMock->expects($this->once())
            ->method('deleteTask')
            ->with($input['id']);

        ob_start();
        $this->tareaController->deleteTask();
        $output = ob_get_clean();

        $expected = json_encode(["message" => "Tarea eliminada"]);

        $this->assertJsonStringEqualsJsonString($expected, $output);
    }

    public function testFinishTask_Success()
    {
        $input = [
            'id' => 1,
        ];

        file_put_contents('php://input', json_encode($input));

        $this->tareaModelMock->expects($this->once())
            ->method('finishTask')
            ->with($input['id']);

        ob_start();
        $this->tareaController->finishTask();
        $output = ob_get_clean();

        $expected = json_encode(["message" => "Tarea terminada"]);

        $this->assertJsonStringEqualsJsonString($expected, $output);
    }
}
?>
