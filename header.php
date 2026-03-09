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
font-family:Arial, Helvetica, sans-serif;
}

/* NAVBAR */

.navbar{
background:#060a12;
position:sticky;
top:0;
z-index:1000;
}

.logo{
font-weight:bold;
font-size:22px;
color:#ffffff;
}

.search-bar{
width:100%;
max-width:600px;
}

.search-bar input{
border-radius:20px;
padding:10px 20px;
}

/* MENU */

.menu{
background:#0f1626;
padding:10px 0;
position:sticky;
top:56px;
z-index:999;
}

.menu ul{
list-style:none;
margin:0;
padding:0;
display:flex;
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

/* SUBMENU */

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

.submenu a{
display:block;
font-size:13px;
padding:6px 0;
color:#cfd8ff;
}

.submenu a:hover{
color:#00eaff;
}

.menu li:hover .submenu{
display:block;
}

</style>
</head>

<body>

<!-- NAVBAR -->

<nav class="navbar navbar-dark">
<div class="container d-flex justify-content-between align-items-center">

<div class="logo">NeoOriginal</div>

<form class="search-bar" method="GET" action="buscar.php">
<input class="form-control" name="busca" placeholder="Buscar celulares, peças e acessórios...">
</form>

<div>
<a href="login.php" class="text-light me-3">Entrar</a>
<a href="carrinho.php" class="text-light">Carrinho</a>
</div>

</div>
</nav>

<!-- MENU -->

<div class="menu">
<div class="container">

<ul>

<li>
<a href="#">Celulares</a>
<div class="submenu">
<a href="#">Samsung</a>
<a href="#">Apple</a>
<a href="#">Xiaomi</a>
<a href="#">Motorola</a>
</div>
</li>

<li>
<a href="#">Telas</a>
<div class="submenu">
<a href="#">Tela Samsung</a>
<a href="#">Tela iPhone</a>
<a href="#">Tela Xiaomi</a>
</div>
</li>

<li>
<a href="#">Baterias</a>
<div class="submenu">
<a href="#">Bateria Samsung</a>
<a href="#">Bateria iPhone</a>
<a href="#">Bateria Xiaomi</a>
</div>
</li>

<li>
<a href="#">Ferramentas</a>
<div class="submenu">
<a href="#">Chaves</a>
<a href="#">Separadores</a>
<a href="#">Estações</a>
</div>
</li>

</ul>

</div>
</div>