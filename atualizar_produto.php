<?php

require_once("../config/conexao.php");

$id = $_POST['id'];

$nome = $_POST['nome'];
$categoria = $_POST['categoria'];
$marca = $_POST['marca'];
$descricao = $_POST['descricao'];
$preco = $_POST['preco'];
$estoque = $_POST['estoque'];
$ativo = $_POST['ativo'];


/* BUSCA IMAGEM ATUAL */

$sql = "SELECT imagem FROM produtos WHERE id = $id";
$result = $conn->query($sql);
$produto = $result->fetch_assoc();

$imagem = $produto['imagem'];


/* NOVA IMAGEM */

if(isset($_FILES['imagem']) && $_FILES['imagem']['name'] != ""){

$ext = pathinfo($_FILES['imagem']['name'], PATHINFO_EXTENSION);

$novo_nome = uniqid().".".$ext;

$tmp = $_FILES['imagem']['tmp_name'];

move_uploaded_file($tmp,"../assets/images/".$novo_nome);

if(!empty($imagem) && file_exists("../assets/images/".$imagem)){
unlink("../assets/images/".$imagem);
}

$imagem = $novo_nome;

}


/* UPDATE */

$sql = "UPDATE produtos SET

nome='$nome',
categoria='$categoria',
marca='$marca',
descricao='$descricao',
preco='$preco',
estoque='$estoque',
imagem='$imagem',
ativo='$ativo'

WHERE id=$id";

$conn->query($sql);

header("Location: produtos.php");

?>