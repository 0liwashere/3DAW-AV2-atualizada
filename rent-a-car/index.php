<?php
require_once __DIR__ . '/includes/config.php';

if (usuarioEstaLogado()) {
    header('Location: ' . BASE_URL . 'home.php');
    exit;
}

$erro = $_SESSION['erro_login'] ?? null;
unset($_SESSION['erro_login']);

require __DIR__ . '/views/login.view.php';
