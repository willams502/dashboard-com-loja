<?php
session_start();
include "conexao.php";

if(!isset($_POST['id'])){
    header("Location: index.php");
    exit;
}

$id = intval($_POST['id']);

$sql = "SELECT * FROM produtos WHERE id = $id AND ativo = 1";
$result = $conn->query($sql);

if($result->num_rows == 0){
    header("Location: index.php");
    exit;
}

$produto = $result->fetch_assoc();

if(!isset($_SESSION['carrinho'])){
    $_SESSION['carrinho'] = [];
}

$existe = false;

foreach($_SESSION['carrinho'] as &$item){
    if($item['id'] == $id){
        $item['qtd'] += 1;
        $existe = true;
        break;
    }
}

if(!$existe){
    $_SESSION['carrinho'][] = [
        "id" => $produto['id'],
        "nome" => $produto['nome'],
        "preco" => $produto['preco'],
        "imagem" => $produto['imagem'],
        "qtd" => 1
    ];
}

/* volta para a página anterior */
header("Location: " . $_SERVER['HTTP_REFERER']);
exit;
?>