<?php
require_once __DIR__ . '/../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

$json = file_get_contents('php://input');
$data = json_decode($json);

if (!$data || !isset($data->username) || !isset($data->password)){
    echo json_encode(["success" => false, "message" => "Datos incompletos"]);
    exit;
}

try{
    $pdo = new PDO ("pgsql:host={$_ENV['DB_HOST']}; dbname={$_ENV['DB_NAME']}",$_ENV['DB_USER'],$_ENV['DB_PASS']);
    $stmt = $pdo->prepare("SELECT id, name, password, role FROM users WHERE name = ? AND is_deleted = false");
    $stmt->execute([$data->username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if($user && password_verify($data->password, $user['password'])){
        echo json_encode([
            "success" => true,
            "user" => [
                "id" => $user['id'],
                "name" => $user['name'],
                "role" => $user['role']
            ]
        ]);
    } else {
        echo json_encode(["success" => false, "message" => "Usuario o contraseña incorrecta"]);
    }
} catch(Exception $e){
    echo json_encode(["success" => false, "message" => $e->getMessage()]);
}