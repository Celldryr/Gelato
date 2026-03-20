<?php

require_once __DIR__ . '/../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') exit;

$json = file_get_contents('php://input');
$data = json_decode($json);

if(!$data || empty($data->items)) {
    echo json_encode(["success" => false, "message" => "pedido vacio"]);
    exit;
}

try{
    $pdo = new PDO(
        "pgsql:host={$_ENV['DB_HOST']}; dbname={$_ENV['DB_NAME']}",
        $_ENV['DB_USER'],
        $_ENV['DB_PASS'],
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );

    $pdo->beginTransaction(); //esto crea la transaccion

    // esto registra los pedidos
    $stmt = $pdo->prepare("INSERT INTO sale (user_id, total_price, status) VALUES (?, ?, 'pendiente') RETURNING id");
    $stmt-> execute([$data->user_id, $data->total]);
    $saleId = $stmt->fetchColumn();

    
    // esto registra los detalles del pedidos
    $stmtItem = $pdo->prepare("INSERT INTO sale_item (sale_id, product_id, quantity, price_at_sale) VALUES (?, ?, ?, ?)");

    foreach ($data->items as $item) {
        $stmtItem->execute([
            $saleId,
            $item->id,
            $item->quantity,
            $item->price
        ]);
    }
    $pdo->commit();
    echo json_encode(["success" => true , "sale_id" => $saleId]);
}catch (Exception $e) {
    if ($pdo) $pdo->rollBack();
    echo json_encode(["success" => false, "message" => $e->getMessage()]);
}