<?php
session_start();

$carrinho = $_SESSION['carrinho'];

$msg = "Pedido:%0A%0A";

$total = 0;

foreach($carrinho as $item){

$subtotal = $item['preco'] * $item['qtd'];

$total += $subtotal;

$msg .= $item['nome']." - Qtd: ".$item['qtd']." - R$ ".$subtotal."%0A";

}

$msg .= "%0ATotal: R$ ".$total;

echo $msg;