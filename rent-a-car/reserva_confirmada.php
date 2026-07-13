<?php
require_once __DIR__ . '/includes/config.php';
exigirLogin();

if (!isset($_SESSION['ultima_reserva_id'])) {
    header('Location: ' . BASE_URL . 'home.php');
    exit;
}

$pdo = getConexao();
$stmt = $pdo->prepare('
    SELECT r.*, c.nome AS carro_nome, c.imagem AS carro_imagem,
           lr.nome AS loja_retirada_nome, ld.nome AS loja_devolucao_nome
    FROM reservas r
    JOIN carros c ON c.id = r.carro_id
    JOIN lojas lr ON lr.id = r.loja_retirada_id
    JOIN lojas ld ON ld.id = r.loja_devolucao_id
    WHERE r.id = ? AND r.usuario_id = ?
');
$stmt->execute([$_SESSION['ultima_reserva_id'], $_SESSION['usuario_id']]);
$reserva = $stmt->fetch();

if (!$reserva) {
    header('Location: ' . BASE_URL . 'home.php');
    exit;
}

$usuario = usuarioAtual();

require __DIR__ . '/views/reserva_confirmada.view.php';
