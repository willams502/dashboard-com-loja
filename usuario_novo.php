<?php

session_start();
require_once("../config/conexao.php");

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

<meta charset="UTF-8">
<title>Novo Usuário</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">

<style>

body{
background:linear-gradient(270deg,#0A0F1C,#020617,#11182B);
background-size:600% 600%;
animation:bg 15s ease infinite;
color:white;
font-family:Montserrat;
}

@keyframes bg{
0%{background-position:0% 50%}
50%{background-position:100% 50%}
100%{background-position:0% 50%}
}

/* SIDEBAR */

.sidebar{
width:250px;
height:100vh;
background:#070C17;
position:fixed;
padding:30px;
}

.logo{
font-size:24px;
font-weight:700;
margin-bottom:40px;
background:linear-gradient(90deg,#00E5FF,#6200EA);
-webkit-background-clip:text;
-webkit-text-fill-color:transparent;
}

.sidebar a{
display:block;
color:white;
text-decoration:none;
padding:12px;
border-radius:8px;
margin-bottom:8px;
}

.sidebar a:hover{
background:#162040;
color:#00E5FF;
}

/* MAIN */

.main{
margin-left:250px;
padding:40px;
}

/* CARD */

.card-box{
background:#11182B;
padding:30px;
border-radius:12px;
max-width:500px;
}

/* INPUTS */

input,select{
width:100%;
padding:10px;
margin-bottom:15px;
border-radius:6px;
border:none;
}

/* BOTÕES */

.btn-salvar{
background:#00E5FF;
border:none;
padding:10px 15px;
border-radius:6px;
font-weight:600;
}

.btn-voltar{
background:#6200EA;
padding:10px 15px;
border-radius:6px;
color:white;
text-decoration:none;
margin-left:10px;
}

</style>

</head>

<body>

<div class="sidebar">

<div class="logo">NeoOriginal</div>

<a href="dashboard.php">Dashboard</a>
<a href="produtos.php">Produtos</a>
<a href="pedidos.php">Pedidos</a>
<a href="usuarios.php">Usuários</a>
<a href="logout.php">Sair</a>

</div>

<div class="main">

<h2>Novo Usuário</h2>

<br>

<div class="card-box">

<form action="usuario_salvar.php" method="POST">

<label>Nome</label>
<input type="text" name="nome" required>

<label>Email</label>
<input type="email" name="email" required>

<label>Senha</label>
<input type="password" name="senha" required>

<label>Nível</label>

<select name="nivel">

<option value="admin">Admin</option>
<option value="usuario">Usuário</option>

</select>

<button class="btn-salvar">Criar Usuário</button>

<a href="usuarios.php" class="btn-voltar">Voltar</a>

</form>

</div>

</div>

</body>
</html>