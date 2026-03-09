<?php

require_once("../config/conexao.php");

$id = $_POST['id'];
$nome = $_POST['nome'];
$email = $_POST['email'];
$nivel = $_POST['nivel'];

$sql = "
UPDATE usuarios 
SET nome='$nome',
email='$email',
nivel='$nivel'
WHERE id='$id'
";

$conn->query($sql);

header("Location: usuarios.php");

?>