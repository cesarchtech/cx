<?php
$hostName = 'localhost';
	$userName = 'root';
	$passWord = 'metalica';
	$nomeBanco = 'caixa';
	
	$conexao = mysqli_connect($hostName,$userName,$passWord,$nomeBanco);
	
	$mes = $_GET["mes"];
	$ano = $_GET["ano"];
	$tipo = $_GET["tipo"];
	
	$query = "SELECT TIPOCOD, TIDEDESC, YEAR(DATAPAG)as ANO, MONTH(DATAPAG) as MES, format (sum(fluxo.valor),2,'pt_BR') as TOTAL FROM fluxo, tipdes WHERE fluxo.tipocod = tipdes.tidecod AND LEFT(DATAPAG,7) <= '$ano-$mes' AND CONTA = 'D' AND TIPOCOD = '$tipo' GROUP BY TIPOCOD, YEAR(DATAPAG), MONTH(DATAPAG)";
	//$query = "select TOTAL, MES FROM (select format(sum(fluxo.valor),2,'pt_BR') as TOTAL, CAFLFECHA as MES, CAFLTIPO from carflu where cafltipo = $tipo and caflfecha <= '$ano-$mes' GROUP BY caflfecha) as tabela1";
	
	$result = mysqli_query($conexao,$query);
	while($resultado = mysqli_fetch_array($result)) {
			
	$dados[] = array("MES" => $resultado['MES'].'-'.$resultado['ANO'], "TOTAL" => $resultado['TOTAL']); // assim por diante com todos os campos
	}	
	
	echo json_encode($dados, JSON_PRETTY_PRINT);
	
?>