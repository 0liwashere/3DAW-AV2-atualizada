<?php
require_once __DIR__ . '/includes/config.php';

// Se já estiver logado, vai direto pra Home
if (usuarioEstaLogado()) {
    header('Location: ' . BASE_URL . 'home.php');
    exit;
}

$erro = $_SESSION['erro_login'] ?? null;
unset($_SESSION['erro_login']);

require __DIR__ . '/views/login.view.php';
