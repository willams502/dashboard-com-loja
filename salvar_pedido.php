<?php

header("Content-Type: application/json");

$conn = new mysqli("localhost","root","","neoriginal");

if ($conn->connect_error) {
    echo json_encode(["erro"=>"erro conexao"]);
    exit;
}

$raw = file_get_contents("php://input");
$dados = json_decode($raw,true);

$itens = $dados["itens"];
$total = $dados["total"];

$conn->query("INSERT INTO pedidos (total) VALUES ('$total')");
$pedido_id = $conn->insert_id;

$mensagem = "Pedido #".$pedido_id."\n\n";

foreach($itens as $item){

    $nome = $item["nome"];
    $qtd = $item["qtd"];
    $preco = $item["preco"];

    $subtotal = $preco * $qtd;

    $conn->query("
        INSERT INTO pedidos_itens
        (pedido_id,produto_nome,quantidade,preco)
        VALUES
        ('$pedido_id','$nome','$qtd','$preco')
    ");

    $mensagem .= $nome." - Qtd: ".$qtd." - R$ ".number_format($subtotal,2,",",".")."\n";
}

$mensagem .= "\nTotal: R$ ".number_format($total,2,",",".");

echo json_encode([
    "pedido_id"=>$pedido_id,
    "mensagem"=>$mensagem
]);