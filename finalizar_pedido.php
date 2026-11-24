<?php
header("Content-Type: application/json; charset=utf-8");
require_once(__DIR__ . "/conexao.php");

$data = json_decode(file_get_contents("php://input"), true);
if (!$data || !isset($data['itens'], $data['total'])) {
    http_response_code(400);
    echo json_encode(["erro" => "Dados invalidos"]);
    exit;
}

$itens = (array)$data['itens'];
$total = floatval($data['total']);

$stmt = $conn->prepare("INSERT INTO pedidos (total) VALUES (?)");
$stmt->bind_param('d', $total);
$stmt->execute();

$pedido_id = $conn->insert_id;

$stmtItem = $conn->prepare("INSERT INTO pedidos_itens (pedido_id, produto_nome, quantidade, preco) VALUES (?, ?, ?, ?)");

foreach($itens as $item){
    $nome = (string)($item['nome'] ?? '');
    $qtd = intval($item['qtd'] ?? 1);
    $preco = floatval($item['preco'] ?? 0.0);

    $stmtItem->bind_param('isid', $pedido_id, $nome, $qtd, $preco);
    $stmtItem->execute();
}

echo json_encode([
    "pedido_id" => $pedido_id
]);
exit;
