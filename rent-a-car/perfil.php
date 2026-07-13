<?php
require_once __DIR__ . '/includes/config.php';
exigirLogin();

$usuario = usuarioAtual();

$erro = $_SESSION['erro_perfil'] ?? null;
unset($_SESSION['erro_perfil']);

$sucesso = $_SESSION['sucesso_perfil'] ?? null;
unset($_SESSION['sucesso_perfil']);

require __DIR__ . '/views/perfil.view.php';
