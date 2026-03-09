<?php
session_start();

$index = $_POST['index'];
$qtd = $_POST['qtd'];

$_SESSION['carrinho'][$index]['qtd'] = $qtd;