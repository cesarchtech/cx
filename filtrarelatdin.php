<?php
	include "conexao.php";
	
	$mes = $_GET["mes"];
	$ano = $_GET["ano"];
	
	$query = "select TOTAL, TIDECOD, TIDEDESC FROM (select format (sum(fluxo.valor),2,'pt_BR') as TOTAL, tidecod, tidedesc from fluxo,tipdes where fluxo.tipocod = tipdes.tidecod AND fluxo.DATAPAG like '%$ano-$mes%' AND fluxo.CONTA = 'D' GROUP BY fluxo.tipocod ORDER BY tipdes.tidedesc) as tabela1 order by CAST(TOTAL AS unsigned) DESC";	
	
	$queryfechamento = "select sum(valor) as total from fluxo where CONTA = 'D' and datapag like '%$ano-$mes%'";			
	
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
							$tipo = $row['TIDECOD'];
							echo
							"							
							<tr onclick=\"window.open('graflindin.php?mes=$mes&ano=$ano&tipo=".$row['TIDECOD']."', '_blank', 'width=900,height=500') ; mstTabela(".$row['TIDECOD'].")\";>";
							echo
							"
							<td>
							".$row['TIDEDESC']."
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
				";	
					$queryfechamento = "select format (sum(fluxo.valor),2,'pt_BR') as total from fluxo where CONTA = 'D' and datapag like '%$ano-$mes%'";
					$resultfechamento = mysqli_query($conexao,$queryfechamento);
					while($rowfecha = mysqli_fetch_array($resultfechamento)) {
						
						echo"
						<h4>
						Total = ".$rowfecha['total']."
						</h4>
						";					
					}				
					
		
		echo'
		</div>
</div>
';
?>