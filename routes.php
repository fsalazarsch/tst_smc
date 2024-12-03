<?php

require_once 'controllers/UserController.php';
require_once 'controllers/TareaController.php';
require_once 'controllers/CategoriaController.php';

$routes = [];

function matchRoute($routes, $url) {
    foreach ($routes as $route => $actions) {
        if (preg_match("#^" . str_replace("{id}", "([0-9]+)", $route) . "$#", $url, $matches)) {
            if (isset($matches[1])) {
                $id = $matches[1];  
                $actions['GET']($id);
            return;
            }
            else{
                return;
            }
    }
    }
}

$userController = new UserController();
$tareaController = new TareaController();
$categoriaController = new CategoriaController();

$routes['/tst_smc/']['GET'] = function () {
    require 'views/login.php'; 
};

$routes['/tst_smc/dashboard']['GET'] = function () use ($tareaController, $categoriaController) {
    $tareas = $tareaController->getAllTasks();
    $categs = $categoriaController->getAllCategories();
    require 'views/dashboard.php'; 
};

$routes['/tst_smc/agregar']['GET'] = function () use ($tareaController, $categoriaController) {
    $tareas = $tareaController->getAllTasks();
    $categs = $categoriaController->getAllCategories();
    require 'views/agregar.php'; 
};

$routes['/tst_smc/editar']['GET'] = function () use ($tareaController, $categoriaController) {

    if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
        http_response_code(400);
        echo json_encode(["message" => "ID no válido"]);
        return;
    }

    $id = (int)$_GET['id']; 
    $tarea = $tareaController->getTaskById($id);
    $categs = $categoriaController->getAllCategories();
    require 'views/editar.php'; 
};


$routes['/tst_smc/api/users']['GET'] = function () use ($userController) {
    header("Content-Type: application/json");
    $userController->getAllUsers();
};

$routes['/tst_smc/api/users']['POST'] = function () use ($userController) {
    header("Content-Type: application/json");
    $userController->createUser();
};

$routes['/tst_smc/api/users']['PUT'] = function () use ($userController) {
    $userController->updateUser();
};

$routes['/tst_smc/api/users/{:id}']['DELETE'] = function ($id) use ($userController) {
    $userController->deleteUser($id);
};

$routes['/tst_smc/api/users/{:id}']['GET'] = function ($id) use ($userController) {
    header("Content-Type: application/json");

    if (isset($id)) {
        $userController->getUserById($id);
    }
};
$routes['/tst_smc/api/users/login']['POST'] = function () use ($userController) {

    $userController->login();
};



$routes['/tst_smc/api/tareas']['GET'] = function () use ($tareaController) {
    header("Content-Type: application/json");
    echo $tareaController->getAllTasks();
};

$routes['/tst_smc/api/tareas']['POST'] = function () use ($tareaController) {
    header("Content-Type: application/json");
    $tareaController->createTask();
};

$routes['/tst_smc/api/finalizar_tarea']['POST'] = function () use ($tareaController) {
    header("Content-Type: application/json");
    $tareaController->finishTask();
};

$routes['/tst_smc/api/tareas']['PUT'] = function () use ($tareaController) {
    header("Content-Type: application/json");
    $tareaController->updateTask();
};

$routes['/tst_smc/api/tareas/{:id}']['GET'] = function ($id) use ($tareaController) {
    header("Content-Type: application/json");
    $tareaController->getTaskById($id);
};

$routes['/tst_smc/api/tareas']['DELETE'] = function () use ($tareaController) {
    header("Content-Type: application/json");
    $tareaController->deleteTask();
};


$routes['/tst_smc/api/categorias']['GET'] = function () use ($categoriaController) {
    header("Content-Type: application/json");
    $categoriaController->getAllCategories();
};

$routes['/tst_smc/api/categorias']['POST'] = function () use ($categoriaController) {
    header("Content-Type: application/json");
    $categoriaController->createCategory();
};

$routes['/tst_smc/api/categorias']['PUT'] = function () use ($categoriaController) {
    header("Content-Type: application/json");
    $categoriaController->updateCategory();
};

$routes['/tst_smc/api/categorias/{:id}']['GET'] = function ($id) use ($categoriaController) {
    header("Content-Type: application/json");
    $categoriaController->getCategoryById($id);
};

$routes['/tst_smc/api/categorias/{:id}']['DELETE'] = function ($id) use ($categoriaController) {
    header("Content-Type: application/json");
    $categoriaController->deleteCategory($id);
};



$url = $_SERVER['REQUEST_URI']; 

// Llamar a la función matchRoute
//matchRoute($routes, $url);
?>