<?php
session_start();

$index = $_POST['index'];

unset($_SESSION['carrinho'][$index]);

$_SESSION['carrinho'] = array_values($_SESSION['carrinho']);