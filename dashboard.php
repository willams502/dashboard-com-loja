<?php

session_start();
require_once("../config/conexao.php");

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

/* VENDAS POR MES */

$sql_vendas_mes = "
SELECT 
MONTH(data) as mes,
SUM(pedidos_itens.quantidade * pedidos_itens.preco) as total
FROM pedidos
LEFT JOIN pedidos_itens ON pedidos.id = pedidos_itens.pedido_id
GROUP BY MONTH(data)
ORDER BY mes
";

$vendas_mes = $conn->query($sql_vendas_mes);

$meses = [];
$totais = [];

while($v = $vendas_mes->fetch_assoc()){

$meses[] = $v['mes'];
$totais[] = $v['total'];

}

/* PRODUTOS */

$sql = "SELECT COUNT(*) total FROM produtos";
$r = $conn->query($sql);
$produtos = $r->fetch_assoc()['total'];

/* PEDIDOS */

$sql = "SELECT COUNT(*) total FROM pedidos";
$r = $conn->query($sql);
$pedidos = $r->fetch_assoc()['total'];

/* ESTOQUE BAIXO */

$sql = "SELECT nome, estoque FROM produtos WHERE estoque <= 5";
$estoque_baixo = $conn->query($sql);

/* VENDAS TOTAL */

$sql = "SELECT SUM(quantidade * preco) total FROM pedidos_itens";
$r = $conn->query($sql);
$vendas = $r->fetch_assoc()['total'];

if(!$vendas){
$vendas = 0;
}

/* PEDIDOS RECENTES */

$sql = "
SELECT id,data,status
FROM pedidos
ORDER BY id DESC
LIMIT 5
";

$pedidos_recentes = $conn->query($sql);

/* TOP CATEGORIAS */

$sql = "
SELECT categoria, COUNT(*) total
FROM produtos
GROUP BY categoria
ORDER BY total DESC
LIMIT 5
";

$top_cat = $conn->query($sql);

/* PRODUTOS MAIS VENDIDOS */

$sql = "
SELECT produto_nome,
SUM(quantidade) vendidos,
SUM(preco * quantidade) total_vendido
FROM pedidos_itens
GROUP BY produto_nome
ORDER BY vendidos DESC
LIMIT 5
";

$top_produtos = $conn->query($sql);

$nomes = [];
$quantidades = [];
$produtos_lista = [];

while($row = $top_produtos->fetch_assoc()){

$nomes[] = $row['produto_nome'];
$quantidades[] = $row['vendidos'];
$produtos_lista[] = $row;

}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

<meta charset="UTF-8">

<title>Dashboard</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

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

/* CARDS */

.card-dashboard{
background:#11182B;
padding:25px;
border-radius:12px;
margin-bottom:20px;
transition:.3s;
}

.card-dashboard:hover{
transform:translateY(-5px);
box-shadow:0 0 20px rgba(0,229,255,.2);
}

.card-value{
font-size:32px;
color:#00E5FF;
}

/* TABELA */

.tabela-dashboard{
background:#11182B;
padding:20px;
border-radius:12px;
}

.tabela-dashboard table{
width:100%;
}

.tabela-dashboard th{
color:#00E5FF;
padding:10px;
}

.tabela-dashboard td{
padding:10px;
border-bottom:1px solid rgba(255,255,255,.05);
}

/* BARRA PRODUTOS */

.barra{
width:100%;
height:10px;
background:#1a233a;
border-radius:10px;
margin-top:5px;
}

.barra-preenchida{
height:100%;
background:linear-gradient(90deg,#00E5FF,#6200EA);
box-shadow:0 0 10px #00E5FF;
}

/* ALERTA ESTOQUE */

.alerta{
background:#ff4d4d20;
border-left:4px solid #ff4d4d;
padding:10px;
margin-bottom:8px;
display:flex;
justify-content:space-between;
}

/* STATUS */

.status{
padding:4px 10px;
border-radius:20px;
font-size:12px;
}

.status.pago{background:#00ff9920;color:#00ff99;}
.status.pendente{background:#ffaa0020;color:#ffaa00;}
.status.cancelado{background:#ff4d4d20;color:#ff4d4d;}

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

<h2>Dashboard</h2>

<p>Bem-vindo <?php echo $_SESSION['usuario_nome']; ?></p>

<div class="row">

<div class="col-md-3">
<div class="card-dashboard">
<div>Vendas</div>
<div class="card-value" id="vendas"><?php echo $vendas ?></div>
</div>
</div>

<div class="col-md-3">
<div class="card-dashboard">
<div>Pedidos</div>
<div class="card-value" id="pedidos"><?php echo $pedidos ?></div>
</div>
</div>

<div class="col-md-3">
<div class="card-dashboard">
<div>Produtos</div>
<div class="card-value" id="produtos"><?php echo $produtos ?></div>
</div>
</div>

<div class="col-md-3">
<div class="card-dashboard">
<div>Estoque baixo</div>
<div class="card-value"><?php echo $estoque_baixo->num_rows ?></div>
</div>
</div>

</div>

<div class="row mt-5">

<div class="col-md-6">

<h4>Vendas por mês</h4>

<canvas id="graficoMes"></canvas>

</div>

<div class="col-md-6">

<h4>Pedidos recentes</h4>

<div class="tabela-dashboard">

<table>

<tr>
<th>ID</th>
<th>Data</th>
<th>Status</th>
</tr>

<?php while($p=$pedidos_recentes->fetch_assoc()){ ?>

<tr>

<td><?php echo $p['id'] ?></td>
<td><?php echo $p['data'] ?></td>
<td><span class="status <?php echo $p['status'] ?>"><?php echo $p['status'] ?></span></td>

</tr>

<?php } ?>

</table>

</div>

</div>

</div>

<div class="row mt-5">

<div class="col-md-6">

<h4>Produtos mais vendidos</h4>

<div class="tabela-dashboard">

<?php

$max = max($quantidades);

foreach($produtos_lista as $p){

$porcentagem = ($p['vendidos']/$max)*100;

?>

<div style="margin-bottom:20px">

<div style="display:flex;justify-content:space-between">

<strong><?php echo $p['produto_nome'] ?></strong>

<span><?php echo $p['vendidos'] ?> vendas</span>

</div>

<div class="barra">

<div class="barra-preenchida" style="width:<?php echo $porcentagem ?>%"></div>

</div>

</div>

<?php } ?>

</div>

</div>

<div class="col-md-6">

<h4>Top categorias</h4>

<div class="tabela-dashboard">

<?php while($c=$top_cat->fetch_assoc()){ ?>

<div style="display:flex;justify-content:space-between;padding:8px">

<span><?php echo $c['categoria'] ?></span>
<span><?php echo $c['total'] ?></span>

</div>

<?php } ?>

</div>

</div>

</div>

<div class="row mt-5">

<div class="col-md-6">

<h4>⚠ Estoque baixo</h4>

<?php while($e=$estoque_baixo->fetch_assoc()){ ?>

<div class="alerta">

<span><?php echo $e['nome'] ?></span>
<span><?php echo $e['estoque'] ?></span>

</div>

<?php } ?>

</div>

<div class="col-md-6">

<h4>Ranking produtos</h4>

<canvas id="graficoProdutos"></canvas>

</div>

</div>

</div>

<script>

new Chart(document.getElementById('graficoMes'),{

type:'line',

data:{
labels: <?php echo json_encode($meses); ?>,
datasets:[{
label:'Vendas',
data: <?php echo json_encode($totais); ?>,
borderColor:'#00E5FF',
backgroundColor:'rgba(0,229,255,.1)',
fill:true
}]
},

options:{
plugins:{legend:{labels:{color:'white'}}},
scales:{
x:{ticks:{color:'white'}},
y:{ticks:{color:'white'}}
}
}

})

new Chart(document.getElementById('graficoProdutos'),{

type:'bar',

data:{
labels: <?php echo json_encode($nomes); ?>,
datasets:[{
label:'Itens vendidos',
data: <?php echo json_encode($quantidades); ?>,
backgroundColor:'#00E5FF'
}]
},

options:{
plugins:{legend:{labels:{color:'white'}}},
scales:{
x:{ticks:{color:'white'}},
y:{ticks:{color:'white'}}
}
}

})

</script>

</body>
</html>