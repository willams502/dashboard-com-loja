<?php
require_once(__DIR__ . "/security.php");
require_auth();
require_once(__DIR__ . "/conexao.php");

$id        = (int)($_POST['id'] ?? 0);
$nome      = trim($_POST['nome'] ?? '');
$categoria = trim($_POST['categoria'] ?? '');
$marca     = trim($_POST['marca'] ?? '');
$descricao = trim($_POST['descricao'] ?? '');
$preco     = (float)($_POST['preco'] ?? 0);
$estoque   = (int)($_POST['estoque'] ?? 0);
$ativo     = (int)($_POST['ativo'] ?? 1);

if ($id <= 0 || $nome === '') {
    exit('Dados inválidos.');
}

$stmtSel = $conn->prepare("SELECT imagem FROM produtos WHERE id = ?");
$stmtSel->bind_param('i', $id);
$stmtSel->execute();
$produto = $stmtSel->get_result()->fetch_assoc();
$imagem = $produto['imagem'] ?? '';

if (isset($_FILES['imagem']) && !empty($_FILES['imagem']['name'])) {
    $novaImagem = validate_image_upload($_FILES['imagem'], __DIR__ . '/assets/images');
    if ($novaImagem) {
        if (!empty($imagem) && file_exists(__DIR__ . '/assets/images/' . $imagem)) {
            @unlink(__DIR__ . '/assets/images/' . $imagem);
        }
        $imagem = $novaImagem;
    }
}

$stmtUpd = $conn->prepare(
    "UPDATE produtos SET nome=?, categoria=?, marca=?, descricao=?, preco=?, estoque=?, imagem=?, ativo=? WHERE id=?"
);
$stmtUpd->bind_param('ssssdisii', $nome, $categoria, $marca, $descricao, $preco, $estoque, $imagem, $ativo, $id);
$stmtUpd->execute();

header("Location: produtos.php");
exit;
