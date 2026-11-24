<?php
session_start();
require_once(__DIR__ . "/conexao.php");

$email = trim($_POST['email'] ?? '');
$senha = $_POST['senha'] ?? '';

if ($email === '' || $senha === '') {
    exit('E-mail e senha são obrigatórios.');
}

$stmt = $conn->prepare("SELECT id, nome, senha FROM usuarios WHERE email = ? LIMIT 1");
$stmt->bind_param('s', $email);
$stmt->execute();
$result = $stmt->get_result();

if ($usuario = $result->fetch_assoc()) {
    $valid = password_verify($senha, $usuario['senha']);
    if ($valid) {
        session_regenerate_id(true);
        $_SESSION['usuario_id'] = (int)$usuario['id'];
        $_SESSION['usuario_nome'] = $usuario['nome'];
        header("Location: dashboard.php");
        exit;
    }
}

echo "Usuário ou senha inválidos";
