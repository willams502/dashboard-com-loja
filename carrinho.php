<?php
session_start();
require_once(__DIR__ . "/conexao.php");

if(!isset($_POST['id'])){
    header("Location: index.php");
    exit;
}

$id = intval($_POST['id']);
if ($id <= 0) {
    header("Location: index.php");
    exit;
}

$stmt = $conn->prepare("SELECT * FROM produtos WHERE id = ? AND ativo = 1");
$stmt->bind_param('i', $id);
$stmt->execute();
$result = $stmt->get_result();

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
        "id" => (int)$produto['id'],
        "nome" => $produto['nome'],
        "preco" => (float)$produto['preco'],
        "imagem" => $produto['imagem'],
        "qtd" => 1
    ];
}

$referer = $_SERVER['HTTP_REFERER'] ?? 'index.php';
header("Location: " . $referer);
exit;
