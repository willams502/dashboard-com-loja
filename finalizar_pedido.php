<?php

$conn = new mysqli("localhost","root","","sua_base");

$data = json_decode(file_get_contents("php://input"), true);

$itens = $data['itens'];
$total = $data['total'];

$conn->query("INSERT INTO pedidos (total) VALUES ('$total')");

$pedido_id = $conn->insert_id;

foreach($itens as $item){

$nome = $item['nome'];
$qtd = $item['qtd'];
$preco = $item['preco'];

$conn->query("
INSERT INTO pedidos_itens (pedido_id, produto_nome, quantidade, preco)
VALUES ('$pedido_id','$nome','$qtd','$preco')
");

}

echo json_encode([
"pedido_id"=>$pedido_id
]);

?>