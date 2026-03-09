<?php

require_once("../config/conexao.php");

$id = $_GET['id'];

$sql = "UPDATE usuarios SET ativo = NOT ativo WHERE id='$id'";

$conn->query($sql);

header("Location: usuarios.php");

?>