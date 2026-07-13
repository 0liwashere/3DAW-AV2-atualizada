<?php
require_once __DIR__ . '/includes/config.php';

if (usuarioEstaLogado()) {
    header('Location: ' . BASE_URL . 'home.php');
    exit;
}

$erro = $_SESSION['erro_cadastro'] ?? null;
unset($_SESSION['erro_cadastro']);

// Busca as lojas para popular o select "Local de Partida"
$pdo = getConexao();
$lojas = $pdo->query('SELECT id, nome FROM lojas ORDER BY nome')->fetchAll();

require __DIR__ . '/views/cadastro.view.php';
