<?php
header("Content-Type: application/json; charset=utf-8");
require_once(__DIR__ . "/conexao.php");

$raw = file_get_contents("php://input");
$dados = json_decode($raw, true);

if (!$dados || !isset($dados["itens"], $dados["total"])) {
    http_response_code(400);
    echo json_encode(["erro" => "Dados invalidos"]);
    exit;
}

$itens = (array)$dados["itens"];
$total = floatval($dados["total"]);

$stmt = $conn->prepare("INSERT INTO pedidos (total) VALUES (?)");
$stmt->bind_param('d', $total);
$stmt->execute();
$pedido_id = $conn->insert_id;

$stmtItem = $conn->prepare("INSERT INTO pedidos_itens (pedido_id, produto_nome, quantidade, preco) VALUES (?, ?, ?, ?)");

$mensagem = "Pedido #" . $pedido_id . "\n\n";

foreach($itens as $item){
    $nome = (string)($item["nome"] ?? '');
    $qtd = intval($item["qtd"] ?? 1);
    $preco = floatval($item["preco"] ?? 0.0);
    $subtotal = $preco * $qtd;

    $stmtItem->bind_param('isid', $pedido_id, $nome, $qtd, $preco);
    $stmtItem->execute();

    $mensagem .= $nome . " - Qtd: " . $qtd . " - R$ " . number_format($subtotal, 2, ",", ".") . "\n";
}

$mensagem .= "\nTotal: R$ " . number_format($total, 2, ",", ".");

echo json_encode([
    "pedido_id" => $pedido_id,
    "mensagem" => $mensagem
]);
exit;
