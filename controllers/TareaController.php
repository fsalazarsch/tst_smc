<?php

require_once 'models/Tarea.php';

class TareaController
{
    private $tareaModel;

    public function __construct()
    {
        $this->tareaModel = new Tarea();
    }

    public function getAllTasks()
    {
        $tasks = $this->tareaModel->getAllTasks();
        return json_encode($tasks);
    }

    public function getTaskById($id)
    {
        $task = $this->tareaModel->getTaskById($id);
        if ($task) {
            return json_encode($task);
        } else {
            http_response_code(404);
            return json_encode(["message" => "Tarea no encontrada"]);
        }
    }

    public function createTask()
    {
        $input = json_decode(file_get_contents('php://input'), true);
        if (!isset($input['nombre'], $input['descripcion'], $input['estado'], $input['nivel'], $input['fecha_vencimiento'], $input['categoria_id'])) {
            http_response_code(400);
            echo json_encode(["message" => "Datos incompletos"]);
            return;
        }

        $taskId = $this->tareaModel->createTask(
            $input['nombre'],
            $input['descripcion'],
            $input['estado'],
            $input['nivel'],
            $input['fecha_vencimiento'],
            $input['categoria_id']
        );

        echo json_encode(["message" => "Tarea creada", "id" => $taskId]);
    }

    public function updateTask()
    {
        $input = json_decode(file_get_contents('php://input'), true);
        if (!isset($input['id'], $input['nombre'], $input['descripcion'], $input['estado'], $input['nivel'], $input['fecha_vencimiento'], $input['categoria_id'])) {
            http_response_code(400);
            echo json_encode(["message" => "Datos incompletos"]);
            return;
        }

        $this->tareaModel->updateTask(
            $input['id'],
            $input['nombre'],
            $input['descripcion'],
            $input['estado'],
            $input['nivel'],
            $input['fecha_vencimiento'],
            $input['categoria_id']
        );

        echo json_encode(["message" => "Tarea actualizada"]);
    }

    public function finishTask()
    {   
        $input = json_decode(file_get_contents('php://input'), true);
        $this->tareaModel->finishTask($input['id']);
        echo json_encode(["message" => "Tarea terminada"]);
    }

    public function deleteTask()
    {
        $input = json_decode(file_get_contents('php://input'), true);
        $this->tareaModel->deleteTask($input['id']);
        echo json_encode(["message" => "Tarea eliminada"]);
    }
}
