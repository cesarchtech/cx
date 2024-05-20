<?php
	include "conexao.php";
	
	$mes = $_GET["mes"];
	$ano = $_GET["ano"];
	$tipo = $_GET["tipo"];
	
	$query = "select TOTAL, MES FROM (select format(sum(carflu.caflval),2,'pt_BR') as TOTAL, CAFLFECHA as MES, CAFLTIPO from carflu where cafltipo = '$tipo' and caflfecha <= '$ano-$mes' GROUP BY caflfecha) as tabela1";
	$querymedia = "SELECT format (AVG(TOTAL),2,'pt_BR') as MEDIA FROM (select TOTAL, MES FROM (select format(sum(carflu.caflval),2,'pt_BR') as TOTAL, CAFLFECHA as MES, CAFLTIPO from carflu where cafltipo = '$tipo' and caflfecha <= '$ano-$mes' GROUP BY caflfecha) as tabela1) AS TABELA2";
	
	$result = mysqli_query($conexao,$querymedia);
	$row = mysqli_fetch_assoc($result);
	$media = $row['MEDIA'];	
	
	$result = mysqli_query($conexao,$query);
	while($resultado = mysqli_fetch_array($result)) {
			
	$dados[] = array("MES" => $resultado['MES'], "TOTAL" => $resultado['TOTAL'], "MEDIA" => $media); // assim por diante com todos os campos
	}	
	
	echo json_encode($dados, JSON_PRETTY_PRINT);
	
?>