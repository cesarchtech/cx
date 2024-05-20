<?php

	session_start();
	if (empty($_SESSION['user'])) 
	{
		return header('location: login.html');
	}
	
?>
<?php
function convert_number_to_words($number) {

    $hyphen      = '-';
    $conjunction = ' e ';
    $separator   = ', ';
    $negative    = 'menos ';
    $decimal     = ' ponto ';
    $dictionary  = array(
        0                   => 'zero',
        1                   => 'um',
        2                   => 'dois',
        3                   => 'três',
        4                   => 'quatro',
        5                   => 'cinco',
        6                   => 'seis',
        7                   => 'sete',
        8                   => 'oito',
        9                   => 'nove',
        10                  => 'dez',
        11                  => 'onze',
        12                  => 'doze',
        13                  => 'treze',
        14                  => 'quatorze',
        15                  => 'quinze',
        16                  => 'dezesseis',
        17                  => 'dezessete',
        18                  => 'dezoito',
        19                  => 'dezenove',
        20                  => 'vinte',
        30                  => 'trinta',
        40                  => 'quarenta',
        50                  => 'cinquenta',
        60                  => 'sessenta',
        70                  => 'setenta',
        80                  => 'oitenta',
        90                  => 'noventa',
        100                 => 'cento',
        200                 => 'duzentos',
        300                 => 'trezentos',
        400                 => 'quatrocentos',
        500                 => 'quinhentos',
        600                 => 'seiscentos',
        700                 => 'setecentos',
        800                 => 'oitocentos',
        900                 => 'novecentos',
        1000                => 'mil',
        1000000             => array('milhão', 'milhões'),
        1000000000          => array('bilhão', 'bilhões'),
        1000000000000       => array('trilhão', 'trilhões'),
        1000000000000000    => array('quatrilhão', 'quatrilhões'),
        1000000000000000000 => array('quinquilhão', 'quinquilhões')
    );

    if (!is_numeric($number)) {
        return false;
    }

    if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
        // overflow
        trigger_error(
            'convert_number_to_words só aceita números entre ' . PHP_INT_MAX . ' à ' . PHP_INT_MAX,
            E_USER_WARNING
        );
        return false;
    }

    if ($number < 0) {
        return $negative . convert_number_to_words(abs($number));
    }

    $string = $fraction = null;

    if (strpos($number, '.') !== false) {
        list($number, $fraction) = explode('.', $number);
    }

    switch (true) {
        case $number < 21:
            $string = $dictionary[$number];
            break;
        case $number < 100:
            $tens   = ((int) ($number / 10)) * 10;
            $units  = $number % 10;
            $string = $dictionary[$tens];
            if ($units) {
                $string .= $conjunction . $dictionary[$units];
            }
            break;
        case $number < 1000:
            $hundreds  = floor($number / 100)*100;
            $remainder = $number % 100;
            $string = $dictionary[$hundreds];
            if ($remainder) {
                $string .= $conjunction . convert_number_to_words($remainder);
            }
            break;
        default:
            $baseUnit = pow(1000, floor(log($number, 1000)));
            $numBaseUnits = (int) ($number / $baseUnit);
            $remainder = $number % $baseUnit;
            if ($baseUnit == 1000) {
                $string = convert_number_to_words($numBaseUnits) . ' ' . $dictionary[1000];
            } elseif ($numBaseUnits == 1) {
                $string = convert_number_to_words($numBaseUnits) . ' ' . $dictionary[$baseUnit][0];
            } else {
                $string = convert_number_to_words($numBaseUnits) . ' ' . $dictionary[$baseUnit][1];
            }
            if ($remainder) {
                $string .= $remainder < 100 ? $conjunction : $separator;
                $string .= convert_number_to_words($remainder);
            }
            break;
    }

    if (null !== $fraction && is_numeric($fraction)) {
        $string .= $decimal;
        $words = array();
        foreach (str_split((string) $fraction) as $number) {
            $words[] = $dictionary[$number];
        }
        $string .= implode(' ', $words);
    }

    return $string;
}

?>
<?php
	$hostName = 'localhost';
	$userName = 'root';
	$passWord = 'metalica';
	$nomeBanco = 'caixa';
	
	$conexao = mysqli_connect($hostName,$userName,$passWord,$nomeBanco);
	
	$id = $_POST["id"];
	
	$busca = mysqli_query($conexao, "SELECT * FROM saldo WHERE salcod = $id");
	
	while($row = mysqli_fetch_array($busca)){
    $flucod = $id;	
	$data = $row["saldata"];
	$nome = $row["salnome"];		
	$total = $row["saltotal"];
	$adian = $row["saladian"];
	$saldo = $row["salsaldo"];
	$pagamento = $row["salpago"];
	$placa = $row["salplaca"];
	$destino = $row["saldestino"];
	$peso = $row["salpeso"];
	} 
	
echo"
<html>
	<head>
		<title>PLAMAX TRANSPORTES LTDA</title>
		<link href='https://fonts.googleapis.com/css?family=Lobster|Pangolin|Sansita' rel='stylesheet'>
		<meta charset='utf-8'/>
		<meta name='description' content='Página Inicial.'/>
		<link href='css/stylerecibo.css' rel='stylesheet' type='text/css'/>
		<meta name='viewport' content='width=device-width, initial-scale=1'>				
	</head>

<div class='conteudo-tela'>	
<p><a href='javascript:print()'>Imprimir</a></p>
</div>
<h4 align='left'>Recibo N°: $flucod</h4>
<h3 align='center'><font style='font-family:Verdana, Arial, Helvetica, sans-serif'>RECIBO</font></h3>
<p align='right'><font style='font-family:Verdana, Arial, Helvetica, sans-serif'>RECIBO: "; echo 'R$' . number_format($saldo, 2, ',', '.'); echo"</font></p>
<p align='justify'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Recebi(emos) de (a) <strong>PLAMAX TRANSPORTES LTDA</strong> portador (a) do CNPJ: <strong>15.520.834/0001-03</strong>, a import&acirc;ncia de R$ <strong>";
echo convert_number_to_words($saldo);
echo ' reais';
echo "</strong> referente ao <strong>adiantamento do cte $cte.</strong></font></p>
<p align='left'>Destino: $destino.</p>
<p align='left'>Peso: $peso.</p>
<p align='left'>Adiantamento Feito: "; echo 'R$' . number_format($adian, 2, ',', '.'); echo".</p>
<p align='left'>E, por ser esta a expressão de verdade e fé, firmo(amos) o presente.</p>
<p align='center'><font style='font-family:Verdana, Arial, Helvetica, sans-serif'>Apucarana, ";
setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Sao_Paulo');
echo strftime('%A, %d de %B de %Y', strtotime('today'));
echo".</p>
<p>&nbsp;</p>
<p align='center'>________________________________________<br /><font style='font-family:Verdana, Arial, Helvetica, sans-serif'>$nome</font></p>
<p align='center'><font style='font-family:Verdana, Arial, Helvetica, sans-serif'>$placa</font></p>
";
?>