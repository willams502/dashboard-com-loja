<?php
session_start();

$carrinho = $_SESSION['carrinho'];

$mensagem = "Pedido:\n\n";

$total = 0;

foreach($carrinho as $item){

    $subtotal = $item['preco'] * $item['qtd'];
    $total += $subtotal;

    $mensagem .= 
    $item['nome']." - Qtd: ".$item['qtd']." - R$ ".
    number_format($subtotal,2,",",".")."\n";

}

$mensagem .= "\nTotal: R$ ".number_format($total,2,",",".");

$numero = "5531974012890";

$link = "https://wa.me/".$numero."?text=".urlencode($mensagem);

header("Location: ".$link);
exit;