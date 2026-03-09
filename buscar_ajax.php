<?php
include "conexao.php";

$buscar = $_GET['buscar'];

$sql = "SELECT nome FROM produtos 
WHERE nome LIKE '%$buscar%' 
LIMIT 5";

$result = $conn->query($sql);

while($row = $result->fetch_assoc()){

echo "<div style='padding:8px;border-bottom:1px solid #222'>";
echo "<a href='?buscar=".$row['nome']."' style='color:white'>";
echo $row['nome'];
echo "</a></div>";

}