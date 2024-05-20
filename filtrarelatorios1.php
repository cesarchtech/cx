<?php 
include "conexao.php";

$conta = $_GET["conta"];
$modo = $_GET["modo"];
$tipo = $_GET["tipo"];
$diade = $_GET["diade"];
$diaate = $_GET["diaate"];
$mesde = $_GET["mesde"];
$mesate = $_GET["mesate"];
$anode = $_GET["anode"];
$anoate = $_GET["anoate"];
$busca = $_GET["busca"];
$mes = $_GET["mesde"];
$ano = $_GET["anode"];

/*if ($conta == "R") {
    $query = "SELECT FLUDESC AS DESCR, ORIGEM.ORIDESC AS ORI, VALOR, PARCELA AS PARC, DATAPAG AS DATA 
FROM fluxo 
JOIN origem ON fluxo.ORIGEM = origem.cod 
JOIN tiprec ON fluxo.TIPOCOD = tiprec.tirecod 
WHERE fluxo.CONTA = '$conta' AND fluxo.DATAPAG >= '$anode-$mesde-$diade' AND fluxo.DATAPAG <= '$anoate-$mesate-$diaate' AND tiprec.tirecod = '$tipo' AND fluxo.FLUDESC LIKE '%$busca%' 
ORDER BY DATAPAG ASC
";
} else {
    // montar query para buscar em todas as tabelas relacionadas
}*/

if ($conta == "R") {
  /*$query = "SELECT FLUDESC AS DESCR, ORIGEM.ORIDESC AS ORI , VALOR, PARCELA AS PARC, DATAPAG AS DATA 
            FROM fluxo, tiprec, origem 
            WHERE fluxo.TIPOCOD = tiprec.tirecod 
			AND CONTA='$conta'
			AND fluxo.ORIGEM = origem.COD
            AND DATAPAG >= date(concat_ws('-', '$ano', '$mes', '$diade', 1)) 
            AND DATAPAG <= date(concat_ws('-', '$anoate', '$mesate','$diaate', 1)) 
            AND tiprec.tirecod = '$tipo' 
            AND fluxo.FLUDESC LIKE '%$busca%' 
            ORDER BY DATAPAG ASC";*/
	$query = "SELECT FLUDESC AS DESCR, ORIGEM.ORIDESC AS ORI , VALOR, PARCELA AS PARC, DATAPAG AS DATA 
			FROM fluxo, tiprec, origem 
			WHERE fluxo.TIPOCOD = tiprec.tirecod 
			AND CONTA='$conta'
			AND fluxo.ORIGEM = origem.COD
			AND DATAPAG >= date(concat_ws('-', '$ano', '$mes', '$diade', 1)) 
			AND DATAPAG <= date(concat_ws('-', '$anoate', '$mesate','$diaate', 1)) 
			AND (tiprec.tirecod = '$tipo' OR '$tipo' = '0')
			AND fluxo.FLUDESC LIKE '%$busca%' 
			ORDER BY DATAPAG ASC;
		";
} else {
    if ($modo == "T") {
        // Código para a consulta completa com as tabelas fluxo, carflu, tipdes, origem e carori
        /*$query = "SELECT FLUDESC AS DESCR, ORIGEM, ORIGEM.ORIDESC AS ORI, VALOR, PARCELA AS PARC, DATAPAG AS DATA FROM fluxo, tipdes, origem 
					WHERE fluxo.ORIGEM = origem.cod 
					AND (fluxo.TIPOCOD = tipdes.tidecod) 
					AND CONTA='$conta' 
					AND DATAPAG >= date(concat_ws('-', '$ano', '$mes', '$diade', 1)) 
					AND DATAPAG <= date(concat_ws('-', '$anoate', '$mesate','$diaate', 1)) 
					AND tipdes.tidecod = '$tipo' 
					AND fluxo.FLUDESC like '%$busca%' 
					UNION ALL 
					SELECT carflu.cafldesc as DESCR, carflu.caflori as ORIGEM, CARORI.CAORDESC AS ORI, carflu.caflval as VALOR, carflu.caflparc as PARC, carflu.cafldata as DATA 
					FROM carflu, tipdes, carori 
					WHERE carflu.caflori = carori.caorcod 
					AND (carflu.cafltipo = tipdes.tidecod) 
					AND carflu.caflfecha >= '$anode-$mesde' 
					AND carflu.caflfecha <= '$anoate-$mesate' 
					AND tipdes.tidecod = '$tipo' 
					AND carflu.cafldesc like '%$busca%'
				";*/
				$query = "SELECT FLUDESC AS DESCR, ORIGEM, ORIGEM.ORIDESC AS ORI, VALOR, PARCELA AS PARC, DATAPAG AS DATA FROM fluxo, tipdes, origem 
					WHERE fluxo.ORIGEM = origem.cod 
					AND (fluxo.TIPOCOD = tipdes.tidecod) 
					AND CONTA='$conta' 
					AND DATAPAG >= date(concat_ws('-', '$ano', '$mes', '$diade', 1)) 
					AND DATAPAG <= date(concat_ws('-', '$anoate', '$mesate','$diaate', 1))";
					if ($tipo != 0) {
						$query .= " AND tipdes.tidecod = '$tipo'";
					}
					$query .= " AND fluxo.FLUDESC like '%$busca%' 
					UNION ALL 
					SELECT carflu.cafldesc as DESCR, carflu.caflori as ORIGEM, CARORI.CAORDESC AS ORI, carflu.caflval as VALOR, carflu.caflparc as PARC, carflu.cafldata as DATA 
					FROM carflu, tipdes, carori 
					WHERE carflu.caflori = carori.caorcod 
					AND (carflu.cafltipo = tipdes.tidecod) 
					AND carflu.caflfecha >= '$anode-$mesde' 
					AND carflu.caflfecha <= '$anoate-$mesate'";
					if ($tipo != 0) {
						$query .= " AND tipdes.tidecod = '$tipo'";
					}
					$query .= " AND carflu.cafldesc like '%$busca%'";
    } else if ($modo == "D") {
        // Código para a consulta sem as tabelas carflu e carori			  
			/*$query = "SELECT FLUDESC AS DESCR, ORIGEM, ORIGEM.ORIDESC AS ORI, VALOR, PARCELA AS PARC, DATAPAG AS DATA FROM fluxo, tipdes, origem 
						WHERE fluxo.ORIGEM = origem.cod 
						AND (fluxo.TIPOCOD = tipdes.tidecod) 
						AND CONTA='$conta' 
						AND DATAPAG >= date(concat_ws('-', '$ano', '$mes', '$diade', 1)) 
						AND DATAPAG <= date(concat_ws('-', '$anoate', '$mesate','$diaate', 1))
						AND tipdes.tidecod = '$tipo' 
						AND fluxo.FLUDESC like '%$busca%'
						ORDER BY DATAPAG ASC
					";*/
				$query = "SELECT FLUDESC AS DESCR, ORIGEM, ORIGEM.ORIDESC AS ORI, VALOR, PARCELA AS PARC, DATAPAG AS DATA FROM fluxo, tipdes, origem 
						WHERE fluxo.ORIGEM = origem.cod 
						AND (fluxo.TIPOCOD = tipdes.tidecod) 
						AND CONTA='$conta' 
						AND DATAPAG >= date(concat_ws('-', '$ano', '$mes', '$diade', 1)) 
						AND DATAPAG <= date(concat_ws('-', '$anoate', '$mesate','$diaate', 1))
						AND (tipdes.tidecod = '$tipo' OR '$tipo' = 0)
						AND fluxo.FLUDESC like '%$busca%'
						ORDER BY DATAPAG ASC
					";
    } else if ($modo == "C") {
        // Código para a consulta sem as tabelas fluxo e origem
        /*$query = "SELECT carflu.cafldesc AS DESCR, carflu.caflori AS ORIGEM, CARORI.CAORDESC AS ORI, carflu.caflval AS VALOR, carflu.caflparc AS PARC, carflu.cafldata AS DATA
					FROM carflu, tipdes, carori
					WHERE carflu.caflori = carori.caorcod
					AND (carflu.cafltipo = tipdes.tidecod)
					AND carflu.caflfecha >= '$anode-$mesde'
					AND carflu.caflfecha <= '$anoate-$mesate'
					AND tipdes.tidecod = '$tipo'
					AND carflu.cafldesc like '%$busca%'
					ORDER BY carflu.cafldata ASC
				 ";*/
			$query = "SELECT carflu.cafldesc AS DESCR, carflu.caflori AS ORIGEM, CARORI.CAORDESC AS ORI, carflu.caflval AS VALOR, carflu.caflparc AS PARC, carflu.cafldata AS DATA
					FROM carflu, tipdes, carori
					WHERE carflu.caflori = carori.caorcod
					AND (carflu.cafltipo = tipdes.tidecod)
					AND carflu.caflfecha >= '$anode-$mesde'
					AND carflu.caflfecha <= '$anoate-$mesate'
					AND (tipdes.tidecod = '$tipo' OR ('$tipo' = '0'))
					AND carflu.cafldesc like '%$busca%'
					ORDER BY carflu.cafldata ASC

				 ";			
	}
}
				  
//echo $query;

echo'
	<div id="tabela">
	<div id=blocofuturo>
	</div>
	<div id=blocomes>
	</div>
	';

setlocale(LC_MONETARY, 'pt_BR');
$result = mysqli_query($conexao, $query);
$resultsom = mysqli_query($conexao, $query);
$soma = 0;
while($rowsom = mysqli_fetch_array($resultsom)) {
    $soma += $rowsom['VALOR'];
}
echo "Saldo do Total: " . $soma;

echo'
	<table border="1" style="width:100%; text-align:center;">	
		<tr>		
		<th>Descrição</th>
		<th>Origem</th>
		<th>Valor</th>
		<th>Parcela</th>
		<th>Data Pag.</th>
		</tr>';
	
		while($row = mysqli_fetch_array($result)) {
				echo"<tr>";
				echo"
				<td>
				".$row['DESCR']."
				</td>
				<td>
				".$row['ORI']."
				</td>
				<td>
				".$row['VALOR']."
				</td>
				<td>
				".$row['PARC']."
				</td>
				<td>
				".$row['DATA']."
				</td>			
			";
			$soma += $row['VALOR'];
		};	
		echo"</table>";
?>