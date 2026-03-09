<?php
require_once("../config/conexao.php");

$sql = "SELECT * FROM produtos ORDER BY id DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>

<meta charset="UTF-8">
<title>Produtos</title>

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

/* SIDEBAR */

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

/* CONTENT */

.content{
flex:1;
padding:40px;
}

h1{
margin-bottom:20px;
}

.botao{
background:#00E5FF;
border:none;
padding:10px 20px;
border-radius:8px;
cursor:pointer;
font-weight:600;
}

.botao:hover{
background:#6200EA;
color:white;
}

/* TABELA */

table{
width:100%;
border-collapse:collapse;
margin-top:20px;
}

th,td{
padding:12px;
border-bottom:1px solid #1d2740;
text-align:left;
}

th{
color:#00E5FF;
}

tr:hover{
background:#11182b;
}

img{
width:50px;
border-radius:6px;
}

.status-ativo{
color:#00ff9c;
font-weight:bold;
}

.status-inativo{
color:#ff5a5a;
font-weight:bold;
}

.acoes a{
margin-right:10px;
text-decoration:none;
font-weight:600;
}

.editar{
color:#00E5FF;
}

.excluir{
color:#ff4b4b;
}

</style>

</head>

<body>

<!-- MENU LATERAL -->

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


<!-- CONTEUDO -->

<div class="content">

<h1>Produtos</h1>

<a href="novo_produto.php">
<button class="botao">+ Novo Produto</button>
</a>

<table>

<tr>
<th>ID</th>
<th>Imagem</th>
<th>Nome</th>
<th>Fornecedor</th>
<th>Categoria</th>
<th>Marca</th>
<th>Preço</th>
<th>Estoque</th>
<th>Vendas</th>
<th>Status</th>
<th>Ações</th>
</tr>

<?php

if($result->num_rows > 0){

while($row = $result->fetch_assoc()){

$imagem = !empty($row['imagem']) ? $row['imagem'] : "sem-imagem.png";

$status = $row['ativo'] ? 
"<span class='status-ativo'>Ativo</span>" : 
"<span class='status-inativo'>Inativo</span>";

echo "<tr>";

echo "<td>".$row['id']."</td>";

echo "<td>
<img src='../assets/images/".$imagem."'>
</td>";

echo "<td>".$row['nome']."</td>";
echo "<td>".$row['fornecedor']."</td>";

echo "<td>".$row['categoria']."</td>";

echo "<td>".$row['marca']."</td>";

echo "<td>R$ ".number_format($row['preco'],2,",",".")."</td>";

echo "<td>".$row['estoque']."</td>";

echo "<td>".$row['vendas']."</td>";

echo "<td>".$status."</td>";

echo "<td class='acoes'>

<a class='editar' href='editar_produto.php?id=".$row['id']."'>Editar</a>

<a class='excluir' 
href='excluir_produto.php?id=".$row['id']."'
onclick=\"return confirm('Deseja excluir este produto?')\">
Excluir
</a>

</td>";

echo "</tr>";

}

}

?>

</table>

</div>

</body>
</html>