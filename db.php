<?php


function getDbConnection()
{
    $dotenv = parse_ini_file('.env'); 

    $host = $dotenv['DB_HOST'];
    $dbname = $dotenv['DB_NAME'];
    $user = $dotenv['DB_USER'];
    $password = $dotenv['DB_PASSWORD'];

    try {
        $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";
        $pdo = new PDO($dsn, $user, $password, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]);
        return $pdo;
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(["message" => "Error", "error" => $e->getMessage()]);
        exit;
    }
}
