<?php
require_once __DIR__ . '/includes/config.php';
exigirLogin();

if (!isset($_SESSION['reserva_pendente'])) {
    header('Location: ' . BASE_URL . 'carros.php');
    exit;
}

$r = $_SESSION['reserva_pendente'];
$usuario = usuarioAtual();

$erroCupom = $_SESSION['erro_cupom'] ?? null;
unset($_SESSION['erro_cupom']);

$erroPagamento = $_SESSION['erro_pagamento'] ?? null;
unset($_SESSION['erro_pagamento']);

require __DIR__ . '/views/pagamento.view.php';
