<?php
	include "conexao.php";
	
	$mes = $_GET["mes"];
	$ano = $_GET["ano"];
	
	$dia = '01';
			
	$dias = date("t", mktime(0,0,0,$mes,'01',$ano));
	$dia = $dias;
	for ($i = 1 ; $i <= $dias; $i++)	
	 {						
		$i += $i;
	}
	$diaate = $i;
	
	//$query = "SELECT FLUDESC AS DESCR, ORIGEM, ORIGEM.ORIDESC AS ORI, VALOR, PARCELA AS PARC, DATAPAG AS DATA FROM fluxo, tipdes, origem where fluxo.ORIGEM = origem.cod and (fluxo.TIPOCOD = tipdes.tidecod) and CONTA='D' and DATAPAG >= date(concat_ws('-', '$ano', '$mes', 1)) and DATAPAG <= date(concat_ws('-', '$ano', '$mes', 1)) UNION ALL SELECT carflu.cafldesc as DESCR, carflu.caflori as ORIGEM, CARORI.CAORDESC AS ORI, carflu.caflval as VALOR, carflu.caflparc as PARC, carflu.cafldata as DATA FROM carflu, tipdes, carori where carflu.caflori = carori.caorcod and (carflu.cafltipo = tipdes.tidecod) and carflu.cafldata >= date(concat_ws('-', '$ano', '$mes', 1)) and carflu.cafldata <= date(concat_ws('-', '$ano', '$mes', 1))";
	$query = "SELECT FLUDESC AS DESCR, ORIGEM, ORIGEM.ORIDESC AS ORI, VALOR, PARCELA AS PARC, DATAPAG AS DATA FROM fluxo, tipdes, origem 
					WHERE fluxo.ORIGEM = origem.cod 
					AND (fluxo.TIPOCOD = tipdes.tidecod) 
					AND CONTA='D' 
					AND DATAPAG >= date(concat_ws('-', '$ano', '$mes', '01', 1)) 
					AND DATAPAG <= date(concat_ws('-', '$ano', '$mes','$diaate', 1))
					UNION ALL 
					SELECT carflu.cafldesc as DESCR, carflu.caflori as ORIGEM, CARORI.CAORDESC AS ORI, carflu.caflval as VALOR, carflu.caflparc as PARC, carflu.cafldata as DATA 
					FROM carflu, tipdes, carori 
					WHERE carflu.caflori = carori.caorcod 
					AND (carflu.cafltipo = tipdes.tidecod) 
					AND carflu.caflfecha >= '$ano-$mes' 
					AND carflu.caflfecha <= '$ano-$mes'";
	//$query = "select TOTAL, TIDECOD, TIDEDESC FROM (select format(sum(carflu.caflval),2,'pt_BR') as TOTAL, tidecod as TIDECOD,tidedesc as TIDEDESC from carflu,tipdes where carflu.cafltipo = tipdes.tidecod and carflu.caflfecha = '$ano-$mes' GROUP BY carflu.cafltipo) as tabela1 order by CAST(TOTAL AS unsigned) DESC";
	
	$queryfechamento = "select sum(cafesaldo) as total from carfec,carori where cafeori = caorcod and cafefecha = '$ano-$mes'";
					
	$resultfechamento = mysqli_query($conexao,$queryfechamento);
	$rowfecha = mysqli_fetch_assoc($resultfechamento);
	
	$total = $rowfecha['total'];
	
	echo'
	<div id="dados">
		<div class="esquerdo">
		<link href="css/stylegrafico.css" rel="stylesheet" type="text/css"/>
		<canvas id="canvas" style="width:100%; display: block;" ></canvas>
		</div>
	   <div class="direito">
	   <link href="css/stylegrafico.css" rel="stylesheet" type="text/css"/>
		<table id=tabela border="1" style="width:80%; text-align:center;">	
			 <thead> 
			  <tr>
				<th>Descrição</th>
				<th>Valor</th> 
				<th>%</th>
			  </tr>
			 </thead>
			<tbody> ';			
				
					$result = mysqli_query($conexao,$query);
					while($row = mysqli_fetch_array($result)) {
							$tipo = $row['TIPO'];
							echo
							"							
							<tr onclick=\"window.open('graflingg.php?mes=$mes&ano=$ano&tipo=".$row['TIPO']."', '_blank') ; mstTabela(".$row['TIPO'].")\";>";
							echo
							"
							<td>
							".$row['DESCR']."
							</td>
							<td>
							".$row['TOTAL']."
							</td>
							<td>
							";
							$valorlinha = floatval($row['TOTAL']);
							$valor = (($valorlinha * 100) / $total);
							echo number_format($valor,2,",",".");
							echo"
							</td>
							";
					};	
				
				echo"				
				</tbody>  
		</table>
		</div>
</div>
";
?>