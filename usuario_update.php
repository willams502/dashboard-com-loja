<?php
require_once(__DIR__ . "/security.php");
require_auth();
require_once(__DIR__ . "/conexao.php");

$id = intval($_POST['id'] ?? 0);
$nome = trim($_POST['nome'] ?? '');
$email = trim($_POST['email'] ?? '');
$nivel = trim($_POST['nivel'] ?? 'operador');

if ($id > 0 && $nome !== '' && filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $stmt = $conn->prepare("UPDATE usuarios SET nome = ?, email = ?, nivel = ? WHERE id = ?");
    $stmt->bind_param('sssi', $nome, $email, $nivel, $id);
    $stmt->execute();
}

header("Location: usuarios.php");
exit;
