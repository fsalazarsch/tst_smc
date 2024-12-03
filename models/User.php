<?php

require_once 'db.php';

class User
{
    private $db;

    public function __construct()
    {
        $this->db = getDbConnection();
    }

    public function getAllUsers()
    {
        $stmt = $this->db->query("SELECT * FROM users");
        return $stmt->fetchAll();
    }

    public function getUserById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    public function createUser($name, $email, $password)
    {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $this->db->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");
        $stmt->execute([
            'name' => $name,
            'email' => $email,
            'password' => $hashedPassword
        ]);
        return $this->db->lastInsertId();
    }

    public function updateUser($id, $name, $email, $password = null)
    {
        if ($password !== null) {
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
            $stmt = $this->db->prepare("UPDATE users SET name = :name, email = :email, password = :password WHERE id = :id");
            $stmt->execute([
                'id' => $id,
                'name' => $name,
                'email' => $email,
                'password' => $hashedPassword
            ]);
        } else {
            $stmt = $this->db->prepare("UPDATE users SET name = :name, email = :email WHERE id = :id");
            $stmt->execute([
                'id' => $id,
                'name' => $name,
                'email' => $email
            ]);
        }
    }

    public function deleteUser($id)
    {
        $stmt = $this->db->prepare("DELETE FROM users WHERE id = :id");
        $stmt->execute(['id' => $id]);
    }

    public function verifyPassword($inputPassword, $storedPassword)
    {
        return password_verify($inputPassword, $storedPassword);
    }

    public function getUserByCredentials($username, $password)
    {
    $stmt = $this->db->prepare("SELECT id, name, email, password FROM users WHERE name = :username");
    $stmt->bindParam(':username', $username);
    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        unset($user['password']); 
        return $user;
    }

    return null; 
    }
}

