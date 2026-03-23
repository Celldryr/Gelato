<?php
require_once __DIR__ . '/../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

try{
    $pdo = new PDO ("pgsql:host={$_ENV['DB_HOST']}; dbname={$_ENV['DB_NAME']}", 
    $_ENV['DB_USER'],
    $_ENV['DB_PASS']
    );

    $stmt = $pdo->query("SELECT s.id, s.total_price, s.created_at, u.name as seller 
                         FROM sale s
                         JOIN users u ON s.user_id = u.id
                         WHERE s.status = 'pendiente'
                         ORDER BY s.created_at DESC");

    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
} catch(Exception $e){
    echo json_encode(["error" => $e->getMessage()]);
}