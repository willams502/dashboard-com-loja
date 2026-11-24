<?php
require_once(__DIR__ . "/security.php");
require_auth();
require_once(__DIR__ . "/conexao.php");

$id = (int)($_GET['id'] ?? 0);
if ($id <= 0) {
    header("Location: produtos.php");
    exit;
}

$stmt = $conn->prepare("SELECT imagem FROM produtos WHERE id = ?");
$stmt->bind_param('i', $id);
$stmt->execute();
if ($produto = $stmt->get_result()->fetch_assoc()) {
    $imagem = $produto['imagem'];
    if (!empty($imagem) && file_exists(__DIR__ . '/assets/images/' . $imagem)) {
        @unlink(__DIR__ . '/assets/images/' . $imagem);
    }
}

$del = $conn->prepare("DELETE FROM produtos WHERE id = ?");
$del->bind_param('i', $id);
$del->execute();

header("Location: produtos.php");
exit;
