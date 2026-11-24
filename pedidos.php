<?php

require_once(__DIR__ . "/security.php");
require_auth();
require_once(__DIR__ . "/conexao.php");

/* BUSCAR PEDIDOS */

$sql = "
SELECT 
pedidos.id,
pedidos.data,
pedidos.status,
pedidos.status_entrega,
SUM(pedidos_itens.quantidade * pedidos_itens.preco) as total
FROM pedidos
LEFT JOIN pedidos_itens 
ON pedidos.id = pedidos_itens.pedido_id
GROUP BY pedidos.id
ORDER BY pedidos.id DESC
";

$pedidos = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

<meta charset="UTF-8">
<title>Pedidos</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">

<style>

body{
background:#0A0F1C;
color:white;
font-family:Montserrat;
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

/* TABELA */

.tabela{
background:#11182B;
border-radius:12px;
padding:20px;
}

table{
width:100%;
}

th{
color:#00E5FF;
padding:12px;
}

td{
padding:12px;
border-bottom:1px solid rgba(255,255,255,.05);
}

/* STATUS PAGAMENTO */

.status{
padding:5px 12px;
border-radius:20px;
font-size:12px;
}

.status.pago{
background:#00ff9920;
color:#00ff99;
}

.status.pendente{
background:#ffaa0020;
color:#ffaa00;
}

.status.cancelado{
background:#ff4d4d20;
color:#ff4d4d;
}

/* STATUS ENTREGA */

.status-entrega{
padding:5px 12px;
border-radius:20px;
font-size:12px;
}

.status-entrega.em_atendimento{
background:#0099ff20;
color:#0099ff;
}

.status-entrega.rota_entrega{
background:#6f00ff20;
color:#9a4dff;
}

.status-entrega.finalizado{
background:#00ff9920;
color:#00ff99;
}

/* BOTÕES */

.btn-ver{
background:#00E5FF;
border:none;
color:black;
padding:6px 12px;
border-radius:6px;
font-size:13px;
text-decoration:none;
}

.btn-status{
background:#6200EA;
border:none;
color:white;
padding:6px 10px;
border-radius:6px;
font-size:12px;
text-decoration:none;
margin-left:5px;
}

.btn-ver:hover{
background:#00c8e0;
}

.btn-status:hover{
background:#7a2cff;
}
.btn-cancelar{
background:#ff4d4d;
border:none;
color:white;
padding:6px 10px;
border-radius:6px;
font-size:12px;
text-decoration:none;
margin-left:5px;
}

.btn-cancelar:hover{
background:#ff2e2e;
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

<h2>Pedidos</h2>

<div class="tabela">

<table>

<tr>
<th>ID</th>
<th>Data</th>
<th>Total</th>
<th>Pagamento</th>
<th>Entrega</th>
<th>Ações</th>
</tr>

<?php while($p = $pedidos->fetch_assoc()){ ?>

<tr>

<td>#<?php echo $p['id'] ?></td>

<td><?php echo date("d/m/Y", strtotime($p['data'])) ?></td>

<td>
R$ <?php echo number_format($p['total'],2,",",".") ?>
</td>

<td>
<span class="status <?php echo $p['status'] ?>">
<?php echo $p['status'] ?>
</span>
</td>

<td>
<span class="status-entrega <?php echo $p['status_entrega'] ?>">
<?php echo $p['status_entrega'] ?>
</span>
</td>

<td>

<a href="pedido_ver.php?id=<?php echo $p['id'] ?>" class="btn-ver">
Itens
</a>

<a href="alterar_entrega.php?id=<?php echo $p['id'] ?>&status=em_atendimento" class="btn-status">
Atendimento
</a>

<a href="alterar_entrega.php?id=<?php echo $p['id'] ?>&status=rota_entrega" class="btn-status">
Rota
</a>

<a href="alterar_entrega.php?id=<?php echo $p['id'] ?>&status=finalizado" class="btn-status">
Finalizar
</a>
<a href="cancelar_pedido.php?id=<?php echo $p['id'] ?>" 
class="btn-cancelar"
onclick="return confirm('Tem certeza que deseja cancelar este pedido?')">
Cancelar
</a>

</td>

</tr>

<?php } ?>

</table>

</div>

</div>

</body>
</html>