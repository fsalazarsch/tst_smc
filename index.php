<?php
//header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");

$method = $_SERVER['REQUEST_METHOD'];
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);


require 'routes.php';

if (isset($routes[$path][$method])) {
    call_user_func($routes[$path][$method]);
} else {
    http_response_code(404);

    echo json_encode(["message" => "Ruta no encontrada, ". $path]);
}

