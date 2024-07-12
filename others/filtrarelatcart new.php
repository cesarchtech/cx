<?php
	$hostName = 'localhost';
	$userName = 'root';
	$passWord = 'metalica';
	$nomeBanco = 'caixa';
	
	$conexao = mysqli_connect($hostName,$userName,$passWord,$nomeBanco);
	
	//$query = "SELECT * FROM cartao";
	$mes = $_GET["mes"];
	$ano = $_GET["ano"];
	
	$query = "select TOTAL, CATICOD, CATIDESC FROM (select format(sum(carflu.caflval),2,'pt_BR') as TOTAL, CARTIP.CATIDESC as CATIDESC, CARTIP.CATICOD as CATICOD from carflu,cartip where carflu.cafltipo = cartip.caticod and carflu.caflfecha = '$ano-$mes' GROUP BY carflu.cafltipo) as tabela1 order by CAST(TOTAL AS unsigned) DESC";
	//$query = "select format(sum(carflu.caflval),2,'pt_BR') as TOTAL, CARTIP.CATIDESC from carflu,cartip where carflu.cafltipo = cartip.caticod and carflu.caflfecha = '$ano-$mes' GROUP BY carflu.cafltipo";
	$queryfechamento = "select * from carfec where cafefecha = 	'$ano-$mes'";
	
	
					$resultfechamento = mysqli_query($conexao,$queryfechamento);
					$rowfecha = mysqli_fetch_assoc($resultfechamento);
					$total = $rowfecha['cafesaldo'];
	
	
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
							$tipo = $row['CATICOD'];
							echo
							"							
							<tr onclick=\"myFunction(".$row['CATICOD'].")\";>";
							echo
							"
							<td>
							".$row['CATIDESC']."
							</td>
							<td>
							".$row['TOTAL']."
							</td>
							<td>
							";
							$valorlinha = floatval($row['TOTAL']);
							$valor = (($valorlinha * 100) / $total);
							echo number_format("$valor",2,",",".");
							echo"
							</td>
							";
					};	
				
				echo"				
				</tbody>  
		</table>
				";		
					echo"
					<h4><strong>Valor Total: $total</strong></h4>
					";
		
		echo'
		</div>
</div>

	<div class=tabela-result>
	<table border="1" style="width:100%; text-align:center;">	
		<tr>		
		<th>Descrição</th>
		<th>Valor</th>
		<th>Parcela</th>
		<th>Data Trans.</th>
		</tr>		';
		
			$querytabela = "select * from carflu where caflfecha = '$ano-$mes' and cafltipo='$tipo'";
			$result1 = mysqli_query($conexao,$querytabela);
			while($row1 = mysqli_fetch_array($result1)) {
					echo
					"					
					<tr>
					<td>
					".$row1['cafldesc']."
					</td>
					<td>
					".$row1['caflval']."
					</td>
					<td>
					".$row1['caflparc']."
					</td>
					<td>
					".$row1['cafldata']."
					</td>
					";
			};				
		echo'
		</table>	
	</div>
	
	<script type="text/javascript">
		function myFunction(tipo){
		window.open("graflincart.php?mes=$mes&ano=$ano&tipo="+tipo+", "_blank", "width=900,height=500");
		outraFun(tipo);
		}
	</script>
';
?>