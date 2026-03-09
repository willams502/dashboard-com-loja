<?php
session_start();

$carrinho = isset($_SESSION['carrinho']) ? $_SESSION['carrinho'] : [];
$qtd_carrinho = count($carrinho);
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Carrinho</title>

<style>

body{
font-family:Arial;
margin:0;
background:#f5f5f5;
}

/* MENU */

.topo{
position:fixed;
top:0;
width:100%;
background:#222;
color:white;
padding:15px;
z-index:999;
}

.topo a{
color:white;
margin-right:20px;
text-decoration:none;
font-weight:bold;
}

.container{
margin-top:80px;
padding:20px;
max-width:1000px;
margin-left:auto;
margin-right:auto;
}

/* TABELA */

table{
width:100%;
background:white;
border-radius:10px;
border-collapse:collapse;
box-shadow:0 2px 10px rgba(0,0,0,0.1);
}

th,td{
padding:12px;
border-bottom:1px solid #eee;
text-align:center;
}

tr:hover{
background:#fafafa;
}

img{
width:70px;
}

/* BOTÕES */

button{
padding:6px 10px;
border:none;
cursor:pointer;
border-radius:5px;
}

.remover{
background:#ff4d4d;
color:white;
}

.whatsapp{
background:#00a650;
color:white;
padding:15px 25px;
font-size:18px;
margin-top:20px;
border-radius:8px;
}

/* QUANTIDADE */

.qtd-box{
display:flex;
justify-content:center;
align-items:center;
gap:5px;
}

.qtd{
width:40px;
text-align:center;
}

/* ANIMAÇÃO */

.removendo{
opacity:0;
transform:translateX(-50px);
transition:0.3s;
}

</style>

</head>

<body>

<div class="topo">
<a href="index.php">Produtos</a>
<a href="carrinho.php">Carrinho (<span id="contador"><?=$qtd_carrinho?></span>)</a>
</div>

<div class="container">

<h2>Seu Carrinho</h2>

<table>

<tr>
<th>Imagem</th>
<th>Produto</th>
<th>Preço</th>
<th>Quantidade</th>
<th>Total</th>
<th>Ação</th>
</tr>

<?php foreach($carrinho as $index => $item){ ?>

<tr id="item<?=$index?>">

<td>
<img src="assets/images/<?=$item['imagem']?>">
</td>

<td class="nome"><?=$item['nome']?></td>

<td class="preco"><?=$item['preco']?></td>

<td>

<div class="qtd-box">

<button onclick="diminuir(this)">-</button>

<input type="number" class="qtd" value="<?=$item['qtd']?>" min="1">

<button onclick="aumentar(this)">+</button>

</div>

</td>

<td class="subtotal"><?=$item['preco'] * $item['qtd']?></td>

<td>

<button class="remover" onclick="removerItem(<?=$index?>)">
Remover
</button>

</td>

</tr>

<?php } ?>

</table>

<h3>Total: R$ <span id="total">0</span></h3>

<button class="whatsapp" onclick="enviar_whatsapp()">
Enviar pedido no WhatsApp
</button>

</div>

<script>

function atualizarTotal(){

let total = 0

document.querySelectorAll("tr[id^='item']").forEach(row=>{

let preco = parseFloat(row.querySelector(".preco").innerText)
let qtd = parseInt(row.querySelector(".qtd").value)

let subtotal = preco * qtd

row.querySelector(".subtotal").innerText = subtotal.toFixed(2)

total += subtotal

})

document.getElementById("total").innerText = total.toFixed(2)

}

atualizarTotal()


function aumentar(btn){

let input = btn.parentElement.querySelector(".qtd")
input.value++
atualizarTotal()

}


function diminuir(btn){

let input = btn.parentElement.querySelector(".qtd")

if(input.value > 1){
input.value--
atualizarTotal()
}

}


function removerItem(index){

let item = document.getElementById("item"+index)

item.classList.add("removendo")

setTimeout(()=>{

item.remove()
atualizarTotal()

let contador = document.getElementById("contador")
contador.innerText = parseInt(contador.innerText) - 1

},300)

fetch("remover_item.php",{
method:"POST",
headers:{"Content-Type":"application/x-www-form-urlencoded"},
body:"index="+index
})

}


function enviar_whatsapp(){

let telefone = "5531974012890"

let itens = []
let total = 0

document.querySelectorAll("tr[id^='item']").forEach(row=>{

let nome = row.querySelector(".nome").innerText
let preco = parseFloat(row.querySelector(".preco").innerText)
let qtd = parseInt(row.querySelector(".qtd").value)

itens.push({
nome:nome,
preco:preco,
qtd:qtd
})

total += preco * qtd

})

fetch("salvar_pedido.php",{

method:"POST",
headers:{
"Content-Type":"application/json"
},

body:JSON.stringify({
itens:itens,
total:total
})

})
.then(response => response.json())
.then(data => {

let mensagem = encodeURIComponent(data.mensagem)

let url = "https://wa.me/"+telefone+"?text="+mensagem

window.open(url)

})

}

</script>

</body>
</html>