<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Fluxo de Caixa</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/styleMenu.css">
    <link rel="stylesheet" href="css/styleGrafico.css">
</head>
<body>
    <?php include 'menu.html'; ?>

    <div class="conteudo">
        <h1>Fluxo de Caixa - Julho</h1>
        <table id="fluxoCaixa">
            <thead>
                <tr>
                    <th>Dia</th>
                    <th>Saldo Inicial</th>
                    <th>Entradas</th>
                    <th>Saídas</th>
                    <th>Saldo Final</th>
                    <th>Entradas em Atraso</th>
                    <th>Saídas em Atraso</th>
                </tr>
            </thead>
            <tbody>
                <!-- Linhas serão preenchidas dinamicamente pelo PHP -->
                <?php
                    // Exemplo de como preencher a tabela usando PHP
                    $dados = [
                        ['dia' => 1, 'saldoInicial' => 3220.39, 'entradas' => 3569, 'saidas' => 0, 'saldoFinal' => 6789.39, 'entradasAtraso' => 0, 'saidasAtraso' => 0],
                        // Adicione mais dados conforme necessário
                    ];

                    foreach ($dados as $dado) {
                        echo "<tr>
                            <td>{$dado['dia']}</td>
                            <td>{$dado['saldoInicial']}</td>
                            <td>{$dado['entradas']}</td>
                            <td>{$dado['saidas']}</td>
                            <td>{$dado['saldoFinal']}</td>
                            <td>{$dado['entradasAtraso']}</td>
                            <td>{$dado['saidasAtraso']}</td>
                        </tr>";
                    }
                ?>
            </tbody>
        </table>
        <canvas id="graficoFluxoCaixa" width="400" height="200"></canvas>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="js/script.js"></script>
</body>
</html>
