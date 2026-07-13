<?php
require_once __DIR__ . '/includes/config.php';
exigirLogin();

$pdo = getConexao();

// --- Parâmetros de filtro vindos da URL (GET) ---
$f_categorias  = $_GET['categorias'] ?? [];
$f_passageiros = $_GET['passageiros'] ?? [];
$f_bagagem     = $_GET['bagagem'] ?? [];
$f_combustivel = $_GET['combustivel'] ?? [];
$f_cambio      = $_GET['cambio'] ?? [];
$f_cor         = $_GET['cor'] ?? [];
$busca         = trim($_GET['busca'] ?? '');
$ordenar       = $_GET['ordenar'] ?? '';


$where = ['ativo = 1'];
$params = [];

if (!empty($f_categorias)) {
    $placeholders = implode(',', array_fill(0, count($f_categorias), '?'));
    $where[] = "categoria IN ($placeholders)";
    foreach ($f_categorias as $c) $params[] = $c;
}

if (!empty($f_passageiros)) {
    $placeholders = implode(',', array_fill(0, count($f_passageiros), '?'));
    $where[] = "passageiros IN ($placeholders)";
    foreach ($f_passageiros as $p) $params[] = (int) $p;
}

if (!empty($f_bagagem)) {
    $condicoesBagagem = [];
    foreach ($f_bagagem as $b) {
        if ($b === 'pequena') $condicoesBagagem[] = 'capacidade_bagagem_litros <= 300';
        if ($b === 'media')   $condicoesBagagem[] = 'capacidade_bagagem_litros BETWEEN 301 AND 450';
        if ($b === 'grande')  $condicoesBagagem[] = 'capacidade_bagagem_litros > 450';
    }
    if ($condicoesBagagem) {
        $where[] = '(' . implode(' OR ', $condicoesBagagem) . ')';
    }
}

if (!empty($f_combustivel)) {
    $condicoesCombustivel = [];
    foreach ($f_combustivel as $comb) {
        $condicoesCombustivel[] = 'combustivel LIKE ?';
        $params[] = '%' . $comb . '%';
    }
    $where[] = '(' . implode(' OR ', $condicoesCombustivel) . ')';
}

if (!empty($f_cambio)) {
    $condicoesCambio = [];
    foreach ($f_cambio as $camb) {
        $condicoesCambio[] = 'cambio LIKE ?';
        $params[] = '%' . $camb . '%';
    }
    $where[] = '(' . implode(' OR ', $condicoesCambio) . ')';
}

if (!empty($f_cor)) {
    $placeholders = implode(',', array_fill(0, count($f_cor), '?'));
    $where[] = "cor IN ($placeholders)";
    foreach ($f_cor as $c) $params[] = $c;
}

if ($busca !== '') {
    $where[] = 'nome LIKE ?';
    $params[] = '%' . $busca . '%';
}

$whereSql = implode(' AND ', $where);

$orderSql = 'nome ASC';
if ($ordenar === 'preco_asc')  $orderSql = 'preco_diaria ASC';
if ($ordenar === 'preco_desc') $orderSql = 'preco_diaria DESC';

$sql = "SELECT * FROM carros WHERE $whereSql ORDER BY $orderSql";
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$carros = $stmt->fetchAll();


$categoriasDisponiveis = $pdo->query('SELECT DISTINCT categoria FROM carros ORDER BY categoria')->fetchAll(PDO::FETCH_COLUMN);
$coresDisponiveis = $pdo->query('SELECT DISTINCT cor FROM carros ORDER BY cor')->fetchAll(PDO::FETCH_COLUMN);

function estaMarcado($array, $valor) {
    return in_array($valor, $array) ? 'checked' : '';
}

function classificarBagagem($litros) {
    if ($litros <= 300) return (int) round($litros / 150); // ~2 malas
    if ($litros <= 450) return (int) round($litros / 120); // ~3-4 malas
    return (int) round($litros / 100); // 5+ malas
}

require __DIR__ . '/views/carros.view.php';
