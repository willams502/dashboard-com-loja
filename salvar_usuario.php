<?php

session_start();
require_once("../config/conexao.php");

$email = $_POST['email'];
$senha = $_POST['senha'];

$sql = "SELECT * FROM usuarios WHERE email='$email' AND ativo=1";
$result = $conn->query($sql);

if($result->num_rows > 0){

$user = $result->fetch_assoc();

if(password_verify($senha,$user['senha'])){

$_SESSION['usuario_id'] = $user['id'];
$_SESSION['usuario_nome'] = $user['nome'];

$conn->query("UPDATE usuarios SET ultimo_login = NOW() WHERE id=".$user['id']);

header("Location: dashboard.php");
exit;

}

}

echo "Login inválido";

?>