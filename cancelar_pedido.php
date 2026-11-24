<?php
require_once(__DIR__ . "/security.php");
require_auth();
require_once(__DIR__ . "/conexao.php");

$id = intval($_GET['id'] ?? 0);

if ($id > 0) {
    /* DELETAR ITENS DO PEDIDO */
    $stmt1 = $conn->prepare("DELETE FROM pedidos_itens WHERE pedido_id = ?");
    $stmt1->bind_param('i', $id);
    $stmt1->execute();

    /* DELETAR PEDIDO */
    $stmt2 = $conn->prepare("DELETE FROM pedidos WHERE id = ?");
    $stmt2->bind_param('i', $id);
    $stmt2->execute();
}

header("Location: pedidos.php");
exit;
