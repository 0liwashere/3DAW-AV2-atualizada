<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Carros - Rent a Car</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/carros.css">
</head>
<body>

<?php include __DIR__ . '/partials/header.php'; ?>

<div class="carros-layout">

    <!-- Sidebar de filtros -->
    <form class="filtros-sidebar" method="GET" action="carros.php">

        <div class="filtro-grupo">
            <h4>Categorias</h4>
            <?php foreach ($categoriasDisponiveis as $cat): ?>
                <label class="filtro-opcao">
                    <input type="checkbox" name="categorias[]" value="<?= htmlspecialchars($cat) ?>" <?= estaMarcado($f_categorias, $cat) ?>>
                    <?= htmlspecialchars($cat) ?>
                </label>
            <?php endforeach; ?>
        </div>

        <div class="filtro-grupo">
            <h4>Passageiros</h4>
            <div class="filtro-passageiros">
                <?php foreach ([2, 5, 7] as $p): ?>
                    <label>
                        <input type="checkbox" name="passageiros[]" value="<?= $p ?>" <?= estaMarcado($f_passageiros, (string) $p) ?>>
                        <span><?= $p ?></span>
                    </label>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="filtro-grupo">
            <h4>Capacidade de Bagagem</h4>
            <label class="filtro-opcao"><input type="checkbox" name="bagagem[]" value="pequena" <?= estaMarcado($f_bagagem, 'pequena') ?>> Pequena (1-2 malas)</label>
            <label class="filtro-opcao"><input type="checkbox" name="bagagem[]" value="media" <?= estaMarcado($f_bagagem, 'media') ?>> Média (3-4 malas)</label>
            <label class="filtro-opcao"><input type="checkbox" name="bagagem[]" value="grande" <?= estaMarcado($f_bagagem, 'grande') ?>> Grande (5 ou mais malas)</label>
        </div>

        <div class="filtro-grupo">
            <h4>Tipo de Combustível</h4>
            <?php foreach (['Gasolina', 'Diesel', 'Etanol', 'Elétrico'] as $comb): ?>
                <label class="filtro-opcao">
                    <input type="checkbox" name="combustivel[]" value="<?= $comb ?>" <?= estaMarcado($f_combustivel, $comb) ?>>
                    <?= $comb ?>
                </label>
            <?php endforeach; ?>
        </div>

        <div class="filtro-grupo">
            <h4>Tipo de Câmbio</h4>
            <?php foreach (['Manual', 'Automático'] as $camb): ?>
                <label class="filtro-opcao">
                    <input type="checkbox" name="cambio[]" value="<?= $camb ?>" <?= estaMarcado($f_cambio, $camb) ?>>
                    <?= $camb ?>
                </label>
            <?php endforeach; ?>
        </div>

        <div class="filtro-grupo">
            <h4>Coloração do Veículo</h4>
            <?php foreach ($coresDisponiveis as $cor): ?>
                <label class="filtro-opcao">
                    <input type="checkbox" name="cor[]" value="<?= htmlspecialchars($cor) ?>" <?= estaMarcado($f_cor, $cor) ?>>
                    <?= htmlspecialchars($cor) ?>
                </label>
            <?php endforeach; ?>
        </div>

        <button type="submit" class="btn-primario">Filtrar</button>
    </form>

    <!-- Área principal -->
    <div class="carros-principal">
        <div class="carros-topo">
            <h2><?= count($carros) ?> carro<?= count($carros) === 1 ? '' : 's' ?> encontrado<?= count($carros) === 1 ? '' : 's' ?></h2>
            <form class="carros-topo-acoes" method="GET" action="carros.php">
                <input type="text" name="busca" placeholder="Busque por carros" value="<?= htmlspecialchars($busca) ?>">
                <select name="ordenar" onchange="this.form.submit()">
                    <option value="">Ordenar por</option>
                    <option value="preco_asc" <?= $ordenar === 'preco_asc' ? 'selected' : '' ?>>Menor preço</option>
                    <option value="preco_desc" <?= $ordenar === 'preco_desc' ? 'selected' : '' ?>>Maior preço</option>
                </select>
            </form>
        </div>

        <?php if (empty($carros)): ?>
            <div class="sem-resultados">
                Nenhum carro encontrado com os filtros selecionados.
            </div>
        <?php else: ?>
            <?php foreach ($carros as $carro): ?>
                <div class="carro-card">
                    <img src="<?= htmlspecialchars($carro['imagem']) ?>" alt="<?= htmlspecialchars($carro['nome']) ?>">
                    <div class="carro-info">
                        <h3><?= htmlspecialchars($carro['nome']) ?></h3>
                        <?php if ($carro['selo']): ?><span class="tag-verde"><?= htmlspecialchars($carro['selo']) ?></span><?php endif; ?>

                        <div class="carro-specs">
                            <span>&#10052; AC</span>
                            <span>&#128100; <?= $carro['passageiros'] ?></span>
                            <span>&#128188; <?= classificarBagagem($carro['capacidade_bagagem_litros']) ?></span>
                            <span>&#9881; <?= htmlspecialchars($carro['cambio']) ?></span>
                        </div>

                        <div class="carro-tags">
                            &#10003; Proteção veicular &nbsp;&nbsp; &#10003; Proteção contra roubo<br>
                            <span class="tag-info">&#9432; Informações importantes!</span>
                        </div>
                    </div>

                    <div class="carro-precos">
                        <div class="preco">R$ <?= number_format($carro['preco_diaria'], 2, ',', '.') ?></div>
                        <a href="carro_detalhe.php?id=<?= $carro['id'] ?>" class="btn-primario">Reservar</a>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<?php include __DIR__ . '/partials/footer.php'; ?>

</body>
</html>
