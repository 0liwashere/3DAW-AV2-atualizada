<?php
require_once __DIR__ . '/includes/config.php';
exigirLogin();

$pdo = getConexao();
$lojas = $pdo->query('SELECT nome, endereco FROM lojas ORDER BY nome')->fetchAll();

require __DIR__ . '/views/home.view.php';
