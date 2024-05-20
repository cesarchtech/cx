<?php
	include "conexao.php";
	
	$id = $_GET["id"];
	$mes = $_GET["mes"];
	$ano = $_GET["ano"];
	$conta = $_GET["conta"];
	
	//$query = "SELECT * FROM `carflu` WHERE caflori = '$id' and caflfecha = '$ano-$mes' ORDER BY cafldata DESC";
	$query = "SELECT * FROM fluxo WHERE ORIGEM = '$id' and conta = '$conta' and DATAPAG like '%$ano-$mes%' ORDER BY DATAPAG ASC";
	
	$queryfechamento = "select sum(VALOR) as total FROM fluxo WHERE ORIGEM = '$id' and conta = '$conta' and DATAPAG like '%$ano-$mes%' ORDER BY DATAPAG ASC";
					
	$resultfechamento = mysqli_query($conexao,$queryfechamento);
	$rowfecha = mysqli_fetch_assoc($resultfechamento);
	
	$total = $rowfecha['total'];
	
	echo'
		<table id=tabela border="1" style="width:80%; text-align:center;">	
			 <thead> 
			  <tr>
				<th>Descrição</th>
				<th>Valor</th> 
				<th>Data</th>
			  </tr>
			 </thead>
			<tbody> ';			
				
					$result = mysqli_query($conexao,$query);
					$valortotal = 0;
					while($row = mysqli_fetch_array($result)) {
							//$tipo = $row['TIDECOD'];
							echo
							"							
							<tr>
							<td>
							".$row['FLUDESC']."
							<td>
							".$row['VALOR']."
							</td>
							<td>
							".$row['DATAPAG']."
							</td>							
							";
							$valor = floatval($row['VALOR']);							
							$valortotal = ($valor + $valortotal);
							//$valorlinha = floatval($row['TOTAL']);
							//$valor = (($valorlinha * 100) / $total);				
							
					};	echo "Total: "; echo number_format($valortotal,2,",",".");
				echo"				
				</tbody>  
		</table>
				";	
				
?>