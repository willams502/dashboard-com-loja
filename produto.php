<?php
include "conexao.php";
include "header.php";
$id = $_GET['id'];

$sql = "SELECT * FROM produtos WHERE id = $id";
$result = $conn->query($sql);

$produto = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title><?php echo $produto['nome']; ?></title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

body{
background:#0b0f19;
color:#e9eef7;
font-family:Arial;
}

.product-box{
background:#121a2b;
padding:30px;
border-radius:10px;
}

.price{
color:#00eaff;
font-size:26px;
font-weight:bold;
}

.btn-buy{
background:#00eaff;
border:none;
color:#000;
padding:12px;
border-radius:6px;
font-weight:bold;
width:100%;
}

.btn-buy:hover{
background:#00c7d4;
}

</style>

</head>

<body>

<div class="container mt-5">

<div class="row">

<div class="col-md-6">

<img
src="assets/images/<?php echo $produto['imagem']; ?>"
class="img-fluid"
style="border-radius:10px;"
>

</div>

<div class="col-md-6">

<div class="product-box">

<h2><?php echo $produto['nome']; ?></h2>

<p class="mt-3">
<?php echo $produto['descricao']; ?>
</p>

<div class="price mt-3">
R$ <?php echo number_format($produto['preco'],2,",","."); ?>
</div>

<p class="mt-2">
Estoque: <?php echo $produto['estoque']; ?>
</p>

<form method="POST" action="carrinho.php">

<input type="hidden" name="id" value="<?php echo $produto['id']; ?>">

<button class="btn-buy mt-3">
Adicionar ao Carrinho
</button>

</form>

</div>

</div>

</div>

</div>

</body>
<?php include "footer.php"; ?>
</html>