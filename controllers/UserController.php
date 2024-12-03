<?php

require_once 'models/User.php';

class UserController
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = new User();
    }

    public function getAllUsers()
    {
        $users = $this->userModel->getAllUsers();
        echo json_encode($users);
    }

    public function getUserById($id)
    {
        $user = $this->userModel->getUserById($id);
        if ($user) {
            echo json_encode($user);
        } else {
            http_response_code(404);
            echo json_encode(["message" => "Usuario no encontrado"]);
        }
    }

    public function createUser()
    {
        $input = json_decode(file_get_contents('php://input'), true);
        if (!isset($input['name']) || !isset($input['email'])) {
            http_response_code(400);
            echo json_encode(["message" => "Datos incompletos"]);
            return;
        }

        $userId = $this->userModel->createUser($input['name'], $input['email'], $input['password']);
        echo json_encode(["message" => "Usuario creado", "id" => $userId]);
    }

    public function updateUser()
    {
        $input = json_decode(file_get_contents('php://input'), true);
        if (!isset($input['id']) || !isset($input['name']) || !isset($input['email'], $input['password'])) {
            http_response_code(400);
            echo json_encode(["message" => "Datos incompletos"]);
            return;
        }

        $this->userModel->updateUser($input['id'], $input['name'], $input['email'], $input['password']);
        echo json_encode(["message" => "Usuario actualizado"]);
    }


        public function login()
        {
            $input = json_decode(file_get_contents('php://input'), true);
            if (!isset($input['username']) || !isset($input['password'])) {
                http_response_code(400);
                echo json_encode(["message" => "Datos incompletos"]);
                return;
            }

            $user = $this->userModel->getUserByCredentials($input['username'], $input['password']);
            if ($user) {
                echo json_encode(["message" => "Login exitoso", "user" => $user]);
            } else {
                http_response_code(401);
                echo json_encode(["message" => "Credenciales inválidas"]);
            }
        }

    public function deleteUser($id)
    {
        if (!isset($_GET['id'])) {
            http_response_code(400);
            echo json_encode(["message" => "ID no proporcionado"]);
            return;
        }

        $this->userModel->deleteUser($_GET['id']);
        echo json_encode(["message" => "Usuario eliminado"]);
    }
}
?>
