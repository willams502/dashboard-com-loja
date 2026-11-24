<?php
session_start();
require_once(__DIR__ . "/conexao.php");

$email = trim($_POST['email'] ?? '');
$senha = $_POST['senha'] ?? '';

if ($email === '' || $senha === '') {
    exit('E-mail e senha são obrigatórios.');
}

$stmt = $conn->prepare("SELECT id, nome, senha FROM usuarios WHERE email = ? AND ativo = 1 LIMIT 1");
$stmt->bind_param('s', $email);
$stmt->execute();
$result = $stmt->get_result();

if ($user = $result->fetch_assoc()) {
    if (password_verify($senha, $user['senha'])) {
        session_regenerate_id(true);
        $_SESSION['usuario_id'] = (int)$user['id'];
        $_SESSION['usuario_nome'] = $user['nome'];

        $upd = $conn->prepare("UPDATE usuarios SET ultimo_login = NOW() WHERE id = ?");
        $upd->bind_param('i', $user['id']);
        $upd->execute();

        header("Location: dashboard.php");
        exit;
    }
}

echo "Login inválido";
