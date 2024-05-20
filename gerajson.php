<?php
	include "conexao.php";
	
	//$query = "SELECT * FROM cartao";
	$mes = $_GET["mes"];
	$ano = $_GET["ano"];
	$tipo = $_GET["tipo"];
	
	//$query = "select TOTAL, MES FROM (select format(sum(carflu.caflval),2,'pt_BR') as TOTAL, CAFLFECHA as MES, CAFLTIPO from carflu where cafltipo = $tipo and caflfecha <= '$ano-$mes' GROUP BY caflfecha) as tabela1";
	
	$query = "select TOTAL, CATIDESC FROM (select format(sum(carflu.caflval),2,'pt_BR') as TOTAL, CARTIP.CATIDESC as CATIDESC from carflu,cartip where carflu.cafltipo = cartip.caticod and carflu.caflfecha = '$ano-$mes' GROUP BY carflu.cafltipo) as tabela1 order by CAST(TOTAL AS unsigned) DESC";
	//$query = "select format(sum(carflu.caflval),2,'pt_BR') as TOTAL, CARTIP.CATIDESC from carflu,cartip where carflu.cafltipo = cartip.caticod and carflu.caflfecha = '$ano-$mes' GROUP BY carflu.cafltipo";
	$queryfechamento = "select * from carfec where cafefecha = 	'$ano-$mes'";	
	
	$result = mysqli_query($conexao,$query);
	while($resultado = mysqli_fetch_array($result)) {
			
		
	//$dados[] = array("MES" => $resultado['MES'], "TOTAL" => $resultado['TOTAL']); // assim por diante com todos os campos
	$dados[] = array("CATIDESC" => $resultado['CATIDESC'], "TOTAL" => $resultado['TOTAL']); // assim por diante com todos os campos
	}	
	
	//echo '<pre>';
	echo json_encode($dados, JSON_PRETTY_PRINT);
	//echo '</pre>';
	
	//$result->free();

//$table['rows'] = $rows;

//$jsonTable = json_encode($table, true);
//echo $jsonTable;



	

	?>