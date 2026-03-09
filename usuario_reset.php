<?php

require_once("../config/conexao.php");

$id = $_GET['id'];

$senha = password_hash("123456", PASSWORD_DEFAULT);

$sql = "UPDATE usuarios SET senha='$senha' WHERE id='$id'";

$conn->query($sql);

header("Location: usuarios.php");

?>