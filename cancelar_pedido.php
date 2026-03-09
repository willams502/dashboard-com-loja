<?php

require_once("../config/conexao.php");

$id = $_GET['id'];

/* DELETAR ITENS DO PEDIDO */

$conn->query("DELETE FROM pedidos_itens WHERE pedido_id = '$id'");

/* DELETAR PEDIDO */

$conn->query("DELETE FROM pedidos WHERE id = '$id'");

header("Location: pedidos.php");

?>