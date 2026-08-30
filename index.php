<?php
$equipamentos = [
    ["nome" => "Mouse USB", "quantidade" => 12, "minimo" => 5, "valor" => 45.90],
    ["nome" => "Teclado USB", "quantidade" => 8, "minimo" => 5, "valor" => 79.90],
    ["nome" => "Cabo HDMI", "quantidade" => 3, "minimo" => 4, "valor" => 32.50],
    ["nome" => "SSD 480 GB", "quantidade" => 2, "minimo" => 3, "valor" => 219.90],
    ["nome" => "Memória RAM 8 GB", "quantidade" => 6, "minimo" => 4, "valor" => 149.90],
    ["nome" => "Adaptador Wi-Fi USB", "quantidade" => 4, "minimo" => 4, "valor" => 89.90]
];

function situacaoEstoque(int $quantidade, int $minimo): string
{
    if ($quantidade < $minimo) {
        return "Baixo";
    }

    if ($quantidade == $minimo) {
        return "Atenção";
    }

    return "Normal";
}

function valorTotalItem(int $quantidade, float $valorUnitario): float
{
    return $quantidade * $valorUnitario;
}

function resumoEstoque(array $itens): array
{
    $totalUnidades = 0;
    $valorTotal = 0;
    $itensBaixos = 0;

    foreach ($itens as $item) {
        $totalUnidades += $item["quantidade"];
        $valorTotal += valorTotalItem($item["quantidade"], $item["valor"]);

        if ($item["quantidade"] < $item["minimo"]) {
            $itensBaixos++;
        }
    }

    return [
        "unidades" => $totalUnidades,
        "valor" => $valorTotal,
        "baixos" => $itensBaixos
    ];
}

$resumo = resumoEstoque($equipamentos);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Controle de Estoque de TI</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <main class="container">
        <header class="topo">
            <div>
                <p class="tag">Desenvolvimento de Sistemas II • Agenda 04</p>
                <h1>Controle de Estoque de TI</h1>
                <p class="subtitulo">
                    Exemplo simples em PHP utilizando funções e estrutura de repetição.
                </p>
            </div>
        </header>

        <section class="resumo">
            <article class="card-resumo">
                <span>Total de unidades</span>
                <strong><?= $resumo["unidades"] ?></strong>
            </article>

            <article class="card-resumo">
                <span>Itens com estoque baixo</span>
                <strong><?= $resumo["baixos"] ?></strong>
            </article>

            <article class="card-resumo">
                <span>Valor estimado do estoque</span>
                <strong>R$ <?= number_format($resumo["valor"], 2, ",", ".") ?></strong>
            </article>
        </section>

        <section class="painel">
            <div class="cabecalho-secao">
                <div>
                    <h2>Equipamentos cadastrados</h2>
                    <p>O laço <code>foreach</code> percorre o array e gera uma linha para cada equipamento.</p>
                </div>
            </div>

            <div class="tabela-responsiva">
                <table>
                    <thead>
                        <tr>
                            <th>Equipamento</th>
                            <th>Quantidade</th>
                            <th>Estoque mínimo</th>
                            <th>Valor unitário</th>
                            <th>Valor em estoque</th>
                            <th>Situação</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($equipamentos as $item): ?>
                            <?php $situacao = situacaoEstoque($item["quantidade"], $item["minimo"]); ?>
                            <tr>
                                <td><?= htmlspecialchars($item["nome"]) ?></td>
                                <td><?= $item["quantidade"] ?></td>
                                <td><?= $item["minimo"] ?></td>
                                <td>R$ <?= number_format($item["valor"], 2, ",", ".") ?></td>
                                <td>
                                    R$ <?= number_format(
                                        valorTotalItem($item["quantidade"], $item["valor"]),
                                        2,
                                        ",",
                                        "."
                                    ) ?>
                                </td>
                                <td>
                                    <span class="status status-<?= strtolower($situacao) ?>">
                                        <?= $situacao ?>
                                    </span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </section>

        <section class="conceitos">
            <h2>Conceitos demonstrados</h2>
            <div class="grade-conceitos">
                <article>
                    <h3>Funções</h3>
                    <p>
                        <code>situacaoEstoque()</code>, <code>valorTotalItem()</code> e
                        <code>resumoEstoque()</code> evitam repetir a mesma lógica em vários pontos.
                    </p>
                </article>
                <article>
                    <h3>Estrutura de repetição</h3>
                    <p>
                        O <code>foreach</code> percorre os equipamentos para montar a tabela e
                        também é utilizado na função que calcula o resumo do estoque.
                    </p>
                </article>
            </div>
        </section>
    </main>
</body>
</html>
