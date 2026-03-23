<?php
require_once __DIR__ . '/../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

$data = json_decode(file_get_contents('php://input'));

if (!isset($data->sale_id)){
    echo json_encode(["success" => false]);
    exit;
}

try{
    $pdo = new PDO ("pgsql:host={$_ENV['DB_HOST']}; dbname={$_ENV['DB_NAME']}",$_ENV['DB_USER'],$_ENV['DB_PASS']);
    $stmt = $pdo->prepare("UPDATE sale SET status = 'pagado' WHERE id = ?");
    $stmt->execute([$data->sale_id]);

    echo json_encode(["success" => true]);
} catch(Exception $e){
    echo json_encode(["success" => false, "message" => $e->getMessage()]);
}