<?php
require_once(__DIR__ . "/security.php");
require_auth();
require_once(__DIR__ . "/conexao.php");

$id = intval($_GET['id'] ?? 0);
$status = trim($_GET['status'] ?? '');

$allowedStatuses = ['pendente', 'em transporte', 'entregue', 'cancelado'];
if ($id > 0 && in_array(strtolower($status), $allowedStatuses, true)) {
    $stmt = $conn->prepare("UPDATE pedidos SET status_entrega = ? WHERE id = ?");
    $stmt->bind_param('si', $status, $id);
    $stmt->execute();
}

header("Location: pedidos.php");
exit;
