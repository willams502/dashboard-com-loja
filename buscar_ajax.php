<?php
require_once(__DIR__ . "/conexao.php");

$buscar = trim($_GET['buscar'] ?? '');
if ($buscar === '') {
    exit;
}

$stmt = $conn->prepare("SELECT nome FROM produtos WHERE nome LIKE ? AND ativo = 1 LIMIT 5");
$like = '%' . $buscar . '%';
$stmt->bind_param('s', $like);
$stmt->execute();
$result = $stmt->get_result();

while($row = $result->fetch_assoc()){
    $nomeSafe = htmlspecialchars($row['nome'], ENT_QUOTES, 'UTF-8');
    $nomeUrl = urlencode($row['nome']);
    echo "<div style='padding:8px;border-bottom:1px solid #222'>";
    echo "<a href='?buscar=" . $nomeUrl . "' style='color:white'>" . $nomeSafe . "</a>";
    echo "</div>";
}
exit;
