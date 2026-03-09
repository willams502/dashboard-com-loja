<?php

require_once("../config/conexao.php");

$id = $_GET['id'];
$status = $_GET['status'];

$sql = "UPDATE pedidos SET status_entrega='$status' WHERE id='$id'";

$conn->query($sql);

header("Location: pedidos.php");

?>