<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link rel="stylesheet" href="style.css">

</head>
<body>


<?php 
    // Irei obter o valor do formulário e caso o usuário não adicione nada, então o valor zero será apresentado.
    $valor = $_POST['valor'] ?? 0;
?>  

    <!-- O meu formulário ficará dentro do serv PHP e não precisarei retornar ao HTML para digitar o valor em Reais. Além disso, ele ficará presente na tela sem que desapareça após conversão -->
    <main> 
    <form action="<?php echo $_SERVER['PHP_SELF'] ?>"method="post">
    <label for="valor">valor</label>
    <input type="number" name="valor" id="valor" value="<?=$valor?>">
    <input type="submit" value="Converter"></form></main>

    <section>
    <?php   
    // Cotação vinda da API do Banco Central
        $inicio = date("m-d-Y", strtotime("-7 days"));
        $fim = date("m-d-Y");
        $url = 'https://olinda.bcb.gov.br/olinda/servico/PTAX/versao/v1/odata/CotacaoDolarPeriodo(dataInicial=@dataInicial,dataFinalCotacao=@dataFinalCotacao)?@dataInicial=\''.$inicio.'\'&@dataFinalCotacao=\''.$fim.'\'&$top=1&$orderby=dataHoraCotacao%20desc&$format=json&$select=cotacaoCompra,dataHoraCotacao';

    $dados = json_decode(file_get_contents($url), True);
    // Cotação de compra do Dólar
    $cotação = $dados["value"] [0] ["cotacaoCompra"];

    // Convertendo o valor de Real para Dólar
    $conversor = $valor / $cotação;
    echo "Seus R\$ " . number_format($valor, 2)  . " Reais equivalem a US/$ " . number_format($conversor). " Dólares";   
    ?>  
    </section>  
</body>
</html>