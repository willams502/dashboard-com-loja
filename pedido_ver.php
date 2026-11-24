<?php

require_once(__DIR__ . "/security.php");
require_auth();
require_once(__DIR__ . "/conexao.php");

$id = intval($_GET['id'] ?? 0);
if ($id <= 0) {
    header("Location: pedidos.php");
    exit;
}

/* BUSCAR PEDIDO */
$stmt = $conn->prepare("SELECT * FROM pedidos WHERE id = ?");
$stmt->bind_param('i', $id);
$stmt->execute();
$pedido = $stmt->get_result()->fetch_assoc();
if (!$pedido) {
    header("Location: pedidos.php");
    exit;
}

/* BUSCAR ITENS */
$stmtItens = $conn->prepare("SELECT * FROM pedidos_itens WHERE pedido_id = ?");
$stmtItens->bind_param('i', $id);
$stmtItens->execute();
$itens = $stmtItens->get_result();

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

<meta charset="UTF-8">
<title>Pedido #<?php echo $id ?></title>

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

/* CARD */

.card-pedido{
background:#11182B;
padding:25px;
border-radius:12px;
margin-bottom:20px;
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

/* ENTREGA */

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

/* BOTÃO */

.btn-voltar{
background:#00E5FF;
color:black;
padding:8px 14px;
border-radius:6px;
text-decoration:none;
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

<h2>Pedido #<?php echo $id ?></h2>

<div class="card-pedido">

<p>
<strong>Data:</strong> 
<?php echo date("d/m/Y H:i", strtotime($pedido['data'])) ?>
</p>

<p>

<strong>Pagamento:</strong>

<span class="status <?php echo $pedido['status'] ?>">
<?php echo $pedido['status'] ?>
</span>

</p>

<p>

<strong>Entrega:</strong>

<span class="status-entrega <?php echo $pedido['status_entrega'] ?>">
<?php echo $pedido['status_entrega'] ?>
</span>

</p>

</div>

<div class="card-pedido">

<h4>Itens do pedido</h4>

<table>

<tr>
<th>Produto</th>
<th>Quantidade</th>
<th>Preço</th>
<th>Subtotal</th>
</tr>

<?php 

$total = 0;

while($i = $itens->fetch_assoc()){

$subtotal = $i['quantidade'] * $i['preco'];

$total += $subtotal;

?>

<tr>

<td><?php echo $i['produto_nome'] ?></td>

<td><?php echo $i['quantidade'] ?></td>

<td>R$ <?php echo number_format($i['preco'],2,",",".") ?></td>

<td>R$ <?php echo number_format($subtotal,2,",",".") ?></td>

</tr>

<?php } ?>

</table>

<h3 style="margin-top:20px">

Total do pedido:  
R$ <?php echo number_format($total,2,",",".") ?>

</h3>

</div>

<a href="pedidos.php" class="btn-voltar">
← Voltar para pedidos
</a>

</div>

</body>
</html>