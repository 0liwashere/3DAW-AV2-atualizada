<?php
require_once __DIR__ . '/includes/config.php';
exigirLogin();

$pdo = getConexao();

$carroId = (int) ($_GET['id'] ?? 0);
$stmt = $pdo->prepare('SELECT * FROM carros WHERE id = ? AND ativo = 1');
$stmt->execute([$carroId]);
$carro = $stmt->fetch();

if (!$carro) {
    header('Location: ' . BASE_URL . 'carros.php');
    exit;
}

$lojas = $pdo->query('SELECT id, nome FROM lojas ORDER BY nome')->fetchAll();
$protecoes = $pdo->query('SELECT * FROM protecoes ORDER BY id')->fetchAll();
$adicionais = $pdo->query('SELECT * FROM adicionais ORDER BY id')->fetchAll();
$usuario = usuarioAtual();

// Datas padrão: retirada hoje, devolução em 7 dias (para já ilustrar a promoção Black Nov)
$hoje = date('Y-m-d\TH:i', strtotime('+1 day 10:00'));
$emSeteDias = date('Y-m-d\TH:i', strtotime('+8 days 10:00'));

require __DIR__ . '/views/carro_detalhe.view.php';
