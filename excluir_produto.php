<?php

require_once("../config/conexao.php");

if(!isset($_GET['id'])){
    header("Location: produtos.php");
    exit;
}

$id = intval($_GET['id']);

/* BUSCA IMAGEM DO PRODUTO */

$sql = "SELECT imagem FROM produtos WHERE id = $id";
$result = $conn->query($sql);

if($result->num_rows > 0){

    $produto = $result->fetch_assoc();
    $imagem = $produto['imagem'];

    /* REMOVE IMAGEM */

    if(!empty($imagem) && file_exists("../assets/images/".$imagem)){
        unlink("../assets/images/".$imagem);
    }

}

/* EXCLUI DO BANCO */

$sql_delete = "DELETE FROM produtos WHERE id = $id";
$conn->query($sql_delete);


/* REDIRECIONA */

header("Location: produtos.php");

?>