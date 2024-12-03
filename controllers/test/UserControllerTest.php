<?php

use PHPUnit\Framework\TestCase;

require_once 'controllers/UserController.php';
require_once 'models/User.php';

class UserControllerTest extends TestCase
{
    private $userController;
    private $userModelMock;

    protected function setUp(): void
    {
        $this->userModelMock = $this->createMock(User::class);
        $this->userController = new UserController();
        $this->userController->userModel = $this->userModelMock;
    }

    public function testGetAllUsers()
    {
        $this->userModelMock->method('getAllUsers')->willReturn([
            ['id' => 1, 'name' => 'Felipe', 'email' => 'felipe@asd.com'],
            ['id' => 2, 'name' => 'Ignacio', 'email' => 'ignacio@asd.com'],
        ]);

        ob_start();
        $this->userController->getAllUsers();
        $output = ob_get_clean();

        $expected = json_encode([
            ['id' => 1, 'name' => 'Felipe', 'email' => 'felipe@asd.com'],
            ['id' => 2, 'name' => 'Ignacio', 'email' => 'ignacio@asd.com'],
        ]);

        $this->assertJsonStringEqualsJsonString($expected, $output);
    }

    public function testGetUserById_UserFound()
    {
        $userId = 1;
        $this->userModelMock->method('getUserById')->with($userId)->willReturn([
            'id' => 1,
            'name' => 'Felipe',
            'email' => 'felipe@asd.com',
        ]);

        ob_start();
        $this->userController->getUserById($userId);
        $output = ob_get_clean();

        $expected = json_encode([
            'id' => 1,
            'name' => 'Felipe',
            'email' => 'felipe@asd.com',
        ]);

        $this->assertJsonStringEqualsJsonString($expected, $output);
    }

    public function testGetUserById_UserNotFound()
    {
        $userId = 99;
        $this->userModelMock->method('getUserById')->with($userId)->willReturn(null);

        ob_start();
        $this->userController->getUserById($userId);
        $output = ob_get_clean();

        $expected = json_encode(["message" => "Usuario no encontrado"]);

        $this->assertJsonStringEqualsJsonString($expected, $output);
    }

    public function testCreateUser_Success()
    {
        $input = [
            'name' => 'Felipe',
            'email' => 'felipe@asd.com',
            'password' => 'password123',
        ];

        file_put_contents('php://input', json_encode($input));

        $this->userModelMock->method('createUser')->willReturn(1);

        ob_start();
        $this->userController->createUser();
        $output = ob_get_clean();

        $expected = json_encode([
            "message" => "Usuario creado",
            "id" => 1,
        ]);

        $this->assertJsonStringEqualsJsonString($expected, $output);
    }

    public function testDeleteUser_Success()
    {
        $userId = 1;
        $_GET['id'] = $userId;

        $this->userModelMock->expects($this->once())->method('deleteUser')->with($userId);

        ob_start();
        $this->userController->deleteUser($userId);
        $output = ob_get_clean();

        $expected = json_encode(["message" => "Usuario eliminado"]);

        $this->assertJsonStringEqualsJsonString($expected, $output);
    }
}
?>
