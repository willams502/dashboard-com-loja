<?php

require_once("../config/conexao.php");

$nome = $_POST['nome'];
$categoria = $_POST['categoria'];
$marca = $_POST['marca'];
$descricao = $_POST['descricao'];
$preco = $_POST['preco'];
$estoque = $_POST['estoque'];
$ativo = $_POST['ativo'];
$fornecedor = $_POST['fornecedor'];
$imagem = "";

/* UPLOAD DA IMAGEM */

if(isset($_FILES['imagem']) && $_FILES['imagem']['name'] != ""){

    $extensao = pathinfo($_FILES['imagem']['name'], PATHINFO_EXTENSION);

    $novo_nome = uniqid().".".$extensao;

    $tmp = $_FILES['imagem']['tmp_name'];

    $destino = "../assets/images/".$novo_nome;

    move_uploaded_file($tmp, $destino);

    $imagem = $novo_nome;

}


/* INSERT */

$sql = "

INSERT INTO produtos
(nome, preco, categoria, marca, fornecedor, estoque, ativo, descricao, imagem)

VALUES
('$nome','$preco','$categoria','$marca','$fornecedor','$estoque','$ativo','$descricao','$imagem')

";

$conn->query($sql);


/* REDIRECIONA */

header("Location: produtos.php");

?>