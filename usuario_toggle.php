<?php
require_once(__DIR__ . "/security.php");
require_auth();
require_once(__DIR__ . "/conexao.php");

$id = intval($_GET['id'] ?? 0);

if ($id > 0) {
    $stmt = $conn->prepare("UPDATE usuarios SET ativo = NOT ativo WHERE id = ?");
    $stmt->bind_param('i', $id);
    $stmt->execute();
}

header("Location: usuarios.php");
exit;
