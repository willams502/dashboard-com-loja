<?php
session_start();
include "conexao.php";

if(!isset($_SESSION['carrinho'])){
    $_SESSION['carrinho'] = [];
}

$where = "WHERE ativo = 1";

if(isset($_GET['buscar']) && $_GET['buscar'] != ""){
$buscar = $conn->real_escape_string($_GET['buscar']);
$where .= " AND nome LIKE '%$buscar%'";
}

if(isset($_GET['categoria']) && $_GET['categoria'] != ""){
$categoria = $conn->real_escape_string($_GET['categoria']);
$where .= " AND categoria = '$categoria'";
}

if(isset($_GET['marca']) && $_GET['marca'] != ""){
$marca = $conn->real_escape_string($_GET['marca']);
$where .= " AND marca = '$marca'";
}

if(isset($_GET['preco_min']) && is_numeric($_GET['preco_min'])){
$where .= " AND preco >= " . floatval($_GET['preco_min']);
}

if(isset($_GET['preco_max']) && is_numeric($_GET['preco_max'])){
$where .= " AND preco <= " . floatval($_GET['preco_max']);
}

$order = "";

if(isset($_GET['ordenar'])){

if($_GET['ordenar'] == "menor_preco"){
$order = "ORDER BY preco ASC";
}

if($_GET['ordenar'] == "mais_vendidos"){
$order = "ORDER BY vendas DESC";
}

}

$sql = "SELECT * FROM produtos $where $order";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>NeoOriginal Store</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

body{
background:#0b0f19;
color:#e9eef7;
font-family:Arial;
}

.navbar{
background:#060a12;
}

.logo{
font-weight:bold;
font-size:22px;
}

.search-bar{
width:100%;
max-width:600px;
position:relative;
}

#resultado_busca{
position:absolute;
background:#121a2b;
width:100%;
z-index:999;
}

.menu{
background:#0f1626;
padding:10px 0;
}

.menu ul{
list-style:none;
display:flex;
margin:0;
padding:0;
}

.menu li{
position:relative;
margin-right:25px;
}

.menu a{
color:#cfd8ff;
text-decoration:none;
font-size:14px;
padding:8px 5px;
display:block;
}

.menu a:hover{
color:#00eaff;
}

.submenu{
display:none;
position:absolute;
top:35px;
left:0;
background:#121a2b;
padding:15px;
border-radius:8px;
min-width:180px;
box-shadow:0 10px 25px rgba(0,0,0,0.4);
}

.menu li:hover .submenu{
display:block;
}

.product-card{
background:#121a2b;
padding:15px;
border-radius:10px;
transition:0.3s;
}

.product-card:hover{
transform:translateY(-5px);
box-shadow:0 10px 25px rgba(0,234,255,0.15);
}

.product-card img{
border-radius:8px;
height:180px;
object-fit:cover;
width:100%;
}

.price{
color:#00eaff;
font-weight:bold;
font-size:18px;
}

.btn-buy{
background:#00eaff;
border:none;
color:#000;
width:100%;
padding:10px;
border-radius:6px;
font-weight:bold;
margin-top:10px;
}

.btn-buy:hover{
background:#00c7d4;
}

.sidebar{
background:#121a2b;
padding:20px;
border-radius:10px;
}

footer{
background:#060a12;
margin-top:60px;
padding:30px;
text-align:center;
color:#9aa6c7;
}

</style>
</head>

<body>

<nav class="navbar navbar-dark">
<div class="container d-flex justify-content-between align-items-center">

<div class="logo">NeoOriginal</div>

<div class="search-bar">

<form method="GET">

<input
type="text"
name="buscar"
class="form-control"
placeholder="Buscar celulares, peças e acessórios..."
autocomplete="off"
value="<?php echo isset($_GET['buscar']) ? $_GET['buscar'] : ''; ?>">

</form>

<div id="resultado_busca"></div>

</div>

<div>
<a href="#" class="text-light me-3">Entrar</a>
<a href="ver_carrinho.php" class="text-light">Carrinho</a>
</div>

</div>
</nav>


<div class="menu">
<div class="container">

<ul>

<li>
<a href="?categoria=celular">Celulares</a>
<div class="submenu">
<a href="?categoria=celular&marca=Samsung">Samsung</a>
<a href="?categoria=celular&marca=Apple">Apple</a>
<a href="?categoria=celular&marca=Xiaomi">Xiaomi</a>
<a href="?categoria=celular&marca=Motorola">Motorola</a>
</div>
</li>

<li>
<a href="?categoria=tela">Telas</a>
<div class="submenu">
<a href="?categoria=tela&marca=Samsung">Tela Samsung</a>
<a href="?categoria=tela&marca=Apple">Tela iPhone</a>
<a href="?categoria=tela&marca=Xiaomi">Tela Xiaomi</a>
</div>
</li>

<li>
<a href="?categoria=bateria">Baterias</a>
<div class="submenu">
<a href="?categoria=bateria&marca=Samsung">Bateria Samsung</a>
<a href="?categoria=bateria&marca=Apple">Bateria iPhone</a>
<a href="?categoria=bateria&marca=Xiaomi">Bateria Xiaomi</a>
</div>
</li>

</ul>

</div>
</div>


<div class="container mt-5">

<div class="row">

<div class="col-md-3">

<div class="sidebar">

<h5>Filtros</h5>

<form>

<h6>Preço</h6>

<input type="number" name="preco_min" placeholder="Min" class="form-control mb-2">

<input type="number" name="preco_max" placeholder="Max" class="form-control mb-3">

<h6>Marca</h6>

<select name="marca" class="form-control mb-3">

<option value="">Todas</option>
<option>Samsung</option>
<option>Apple</option>
<option>Xiaomi</option>
<option>Motorola</option>

</select>

<h6>Ordenar</h6>

<select name="ordenar" class="form-control mb-3">

<option value="">Padrão</option>
<option value="menor_preco">Menor preço</option>
<option value="mais_vendidos">Mais vendidos</option>

</select>

<button class="btn btn-info w-100">
Filtrar
</button>

</form>

</div>

</div>


<div class="col-md-9">

<div class="row g-4">

<?php while($produto = $result->fetch_assoc()){ ?>

<div class="col-md-4">

<div class="product-card">

<img src="assets/images/<?php echo !empty($produto['imagem']) ? $produto['imagem'] : 'sem-imagem.png'; ?>">

<h6 class="mt-2"><?php echo $produto['nome']; ?></h6>

<div class="price">
R$ <?php echo number_format($produto['preco'],2,",","."); ?>
</div>

<a href="produto.php?id=<?php echo $produto['id']; ?>" class="btn btn-outline-info mt-2">
Ver Produto
</a>

<form method="POST" action="carrinho.php">

<input type="hidden" name="id" value="<?php echo $produto['id']; ?>">

<button class="btn-buy">
Adicionar ao carrinho
</button>

</form>

</div>

</div>

<?php } ?>

</div>

</div>

</div>

</div>


<footer>
NeoOriginal © 2026 - A logística das assistências de elite
</footer>


<script>

const input = document.querySelector("input[name='buscar']");

input.addEventListener("keyup", function(){

let valor = this.value;

fetch("buscar_ajax.php?buscar="+valor)

.then(res => res.text())

.then(data => {

document.getElementById("resultado_busca").innerHTML = data;

});

});

</script>


</body>
</html>