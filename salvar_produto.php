<?php
require_once(__DIR__ . "/security.php");
require_auth();
require_once(__DIR__ . "/conexao.php");

$nome       = trim($_POST['nome'] ?? '');
$categoria  = trim($_POST['categoria'] ?? '');
$marca      = trim($_POST['marca'] ?? '');
$descricao  = trim($_POST['descricao'] ?? '');
$preco      = (float)($_POST['preco'] ?? 0);
$estoque    = (int)($_POST['estoque'] ?? 0);
$ativo      = (int)($_POST['ativo'] ?? 1);
$fornecedor = trim($_POST['fornecedor'] ?? '');

if ($nome === '' || $preco < 0 || $estoque < 0) {
    exit('Dados inválidos para o produto.');
}

$imagem = '';
if (isset($_FILES['imagem']) && !empty($_FILES['imagem']['name'])) {
    $imagem = validate_image_upload($_FILES['imagem'], __DIR__ . '/assets/images') ?? '';
}

$stmt = $conn->prepare(
    "INSERT INTO produtos (nome, preco, categoria, marca, fornecedor, estoque, ativo, descricao, imagem)
     VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)"
);
$stmt->bind_param('sdsssiiss', $nome, $preco, $categoria, $marca, $fornecedor, $estoque, $ativo, $descricao, $imagem);
$stmt->execute();

header("Location: produtos.php");
exit;
