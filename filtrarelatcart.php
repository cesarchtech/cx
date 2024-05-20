<?php
	include "conexao.php";
	
	$mes = $_GET["mes"];
	$ano = $_GET["ano"];
	
	$query = "select TOTAL, TIDECOD, TIDEDESC FROM (select format(sum(carflu.caflval),2,'pt_BR') as TOTAL, tidecod as TIDECOD,tidedesc as TIDEDESC from carflu,tipdes where carflu.cafltipo = tipdes.tidecod and carflu.caflfecha = '$ano-$mes' GROUP BY carflu.cafltipo) as tabela1 order by CAST(TOTAL AS unsigned) DESC";
	
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
							$tipo = $row['TIDECOD'];
							echo
							"							
							<tr onclick=\"window.open('graflincart.php?mes=$mes&ano=$ano&tipo=".$row['TIDECOD']."', '_blank') ; mstTabela(".$row['TIDECOD'].")\";>";
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
					$queryfechamento = "select * from carfec,carori where cafeori = caorcod and cafefecha = '$ano-$mes'";
					$resultfechamento = mysqli_query($conexao,$queryfechamento);
					while($rowfecha = mysqli_fetch_array($resultfechamento)) {
						
						echo"
						<h4>
						<a href='resumofatcart.php?id=".$rowfecha['caorcod']."&mes=$mes&ano=$ano'>
						Total ".$rowfecha['caordesc']." = ".$rowfecha['cafesaldo']."
						</a>
						</h4>
						";					
					}				
					
		
		echo'
		</div>
</div>
';
?>