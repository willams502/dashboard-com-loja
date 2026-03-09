<?php

session_start();
require_once("../config/conexao.php");

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

$sql = "SELECT * FROM usuarios ORDER BY id DESC";
$usuarios = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

<meta charset="UTF-8">
<title>Usuários</title>

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
padding:25px;
border-radius:12px;
}

/* TABELA */

table{
width:100%;
}

th{
color:#00E5FF;
padding:10px;
}

td{
padding:10px;
border-bottom:1px solid rgba(255,255,255,.05);
}

/* STATUS */

.ativo{color:#00ff99;}
.inativo{color:#ff4d4d;}

.btn-acao{
padding:6px 10px;
border-radius:6px;
font-size:12px;
text-decoration:none;
margin-right:5px;
}

.btn-editar{background:#00E5FF;color:black;}
.btn-status{background:#ffaa00;color:black;}
.btn-reset{background:#ff4d4d;color:white;}
.btn-novo{background:#00ff99;color:black;padding:8px 12px;border-radius:6px;text-decoration:none;}

</style>

</head>

<body>

<!-- SIDEBAR -->

<div class="sidebar">

<div class="logo">NeoOriginal</div>

<a href="dashboard.php">Dashboard</a>
<a href="produtos.php">Produtos</a>
<a href="pedidos.php">Pedidos</a>
<a href="usuarios.php">Usuários</a>
<a href="logout.php">Sair</a>

</div>

<!-- MAIN -->

<div class="main">

<h2>Usuários</h2>

<br>

<a href="usuario_novo.php" class="btn-novo">+ Novo usuário</a>

<br><br>

<div class="card-box">

<table>

<tr>
<th>ID</th>
<th>Nome</th>
<th>Email</th>
<th>Nível</th>
<th>Status</th>
<th>Ações</th>
</tr>

<?php while($u = $usuarios->fetch_assoc()){ ?>

<tr>

<td><?php echo $u['id'] ?></td>
<td><?php echo $u['nome'] ?></td>
<td><?php echo $u['email'] ?></td>
<td><?php echo $u['nivel'] ?></td>

<td>

<?php if($u['ativo']==1){ ?>

<span class="ativo">Ativo</span>

<?php }else{ ?>

<span class="inativo">Inativo</span>

<?php } ?>

</td>

<td>

<a class="btn-acao btn-editar"
href="usuario_editar.php?id=<?php echo $u['id'] ?>">
Editar
</a>

<a class="btn-acao btn-status"
href="usuario_toggle.php?id=<?php echo $u['id'] ?>">

<?php if($u['ativo']==1){ ?>

Desativar

<?php }else{ ?>

Ativar

<?php } ?>

</a>

<a class="btn-acao btn-reset"
href="usuario_reset.php?id=<?php echo $u['id'] ?>"
onclick="return confirm('Resetar senha para 123456?')">

Resetar senha

</a>

</td>

</tr>

<?php } ?>

</table>

</div>

</div>

</body>
</html>