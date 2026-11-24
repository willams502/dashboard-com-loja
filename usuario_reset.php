<?php
require_once(__DIR__ . "/security.php");
require_auth();
require_once(__DIR__ . "/conexao.php");

$id = (int)($_GET['id'] ?? 0);
if ($id > 0) {
    $novaSenha = bin2hex(random_bytes(6));
    $hash = password_hash($novaSenha, PASSWORD_DEFAULT);
    $stmt = $conn->prepare("UPDATE usuarios SET senha = ? WHERE id = ?");
    $stmt->bind_param('si', $hash, $id);
    $stmt->execute();
}

header("Location: usuarios.php");
exit;
