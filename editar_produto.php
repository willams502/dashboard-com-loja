<?php

require_once(__DIR__ . "/security.php");
require_auth();
require_once(__DIR__ . "/conexao.php");

$id = intval($_GET['id'] ?? 0);
if ($id <= 0) {
    header("Location: produtos.php");
    exit;
}

$stmt = $conn->prepare("SELECT * FROM produtos WHERE id = ?");
$stmt->bind_param('i', $id);
$stmt->execute();
$result = $stmt->get_result();
$produto = $result->fetch_assoc();
if (!$produto) {
    header("Location: produtos.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>

<meta charset="UTF-8">
<title>Editar Produto</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&display=swap" rel="stylesheet">

<style>

*{
margin:0;
padding:0;
box-sizing:border-box;
font-family:Poppins;
}

body{
display:flex;
background:#0A0F1C;
color:#F4F6F8;
}

.sidebar{
width:230px;
height:100vh;
background:#0F1629;
padding:25px;
}

.logo{
font-size:22px;
font-weight:700;
margin-bottom:40px;
color:#00E5FF;
}

.menu a{
display:block;
color:#F4F6F8;
text-decoration:none;
padding:12px;
border-radius:6px;
margin-bottom:10px;
}

.menu a:hover{
background:#00E5FF;
color:#000;
}

.content{
flex:1;
padding:40px;
}

.form-box{
background:#0F1629;
padding:30px;
border-radius:10px;
max-width:900px;
}

.linha{
display:flex;
gap:20px;
margin-bottom:20px;
}

.campo{
flex:1;
display:flex;
flex-direction:column;
}

.campo-full{
width:100%;
margin-bottom:20px;
}

input, select, textarea{
padding:12px;
border-radius:6px;
border:none;
background:#0A0F1C;
color:#F4F6F8;
}

textarea{
height:120px;
resize:none;
}

.botao{
background:#00E5FF;
border:none;
padding:12px 20px;
border-radius:8px;
cursor:pointer;
font-weight:600;
}

img{
width:120px;
margin-bottom:10px;
border-radius:6px;
}

</style>

</head>

<body>

<div class="sidebar">

<div class="logo">NeoOriginal</div>

<div class="menu">
<a href="dashboard.php">Dashboard</a>
<a href="produtos.php">Produtos</a>
<a href="pedidos.php">Pedidos</a>
<a href="usuarios.php">Usuarios</a>
<a href="logout.php">Sair</a>
</div>

</div>

<div class="content">

<h1>Editar Produto</h1>

<div class="form-box">

<form action="atualizar_produto.php" method="POST" enctype="multipart/form-data">

<input type="hidden" name="id" value="<?php echo $produto['id']; ?>">

<div class="linha">

<div class="campo">
<label>Nome</label>
<input type="text" name="nome" value="<?php echo $produto['nome']; ?>">
</div>

<div class="campo">
<label>Preço</label>
<input type="number" step="0.01" name="preco" value="<?php echo $produto['preco']; ?>">
</div>

</div>


<div class="linha">

<div class="campo">
<label>Categoria</label>
<input type="text" name="categoria" value="<?php echo $produto['categoria']; ?>">
</div>

<div class="campo">
<label>Marca</label>
<input type="text" name="marca" value="<?php echo $produto['marca']; ?>">
</div>

</div>


<div class="linha">

<div class="campo">
<label>Estoque</label>
<input type="number" name="estoque" value="<?php echo $produto['estoque']; ?>">
</div>

<div class="campo">
<label>Status</label>

<select name="ativo">

<option value="1" <?php if($produto['ativo']==1) echo "selected"; ?>>Ativo</option>
<option value="0" <?php if($produto['ativo']==0) echo "selected"; ?>>Inativo</option>

</select>

</div>

</div>


<div class="campo-full">
<label>Descrição</label>
<textarea name="descricao"><?php echo $produto['descricao']; ?></textarea>
</div>


<div class="campo-full">

<label>Imagem Atual</label><br>

<?php
if(!empty($produto['imagem'])){
echo "<img src='../assets/images/".$produto['imagem']."'>";
}
?>

</div>


<div class="campo-full">
<label>Trocar Imagem</label>
<input type="file" name="imagem">
</div>


<button class="botao">Atualizar Produto</button>

</form>

</div>

</div>

</body>
</html>