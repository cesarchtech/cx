<?php
	include "conexao.php";
	
	$id = $_GET["id"];
	$mes = $_GET["mes"];
	$ano = $_GET["ano"];
	
	$query = "SELECT * FROM `carflu` WHERE caflori = '$id' and caflfecha = '$ano-$mes' ORDER BY cafldata DESC";
	
	//$queryfechamento = "select sum(cafesaldo) as total from carfec,carori where cafeori = caorcod and cafefecha = '$ano-$mes'";
					
	//$resultfechamento = mysqli_query($conexao,$queryfechamento);
	//$rowfecha = mysqli_fetch_assoc($resultfechamento);
	
	//$total = $rowfecha['total'];
	
	echo'
		<table id=tabela border="1" style="width:80%; text-align:center;">	
			 <thead> 
			  <tr>
				<th>Descrição</th>
				<th>Valor</th> 
				<th>Data</th>
				<th>Parcela</th>
			  </tr>
			 </thead>
			<tbody> ';			
				
					$result = mysqli_query($conexao,$query);
					$valortotal = 0;
					while($row = mysqli_fetch_array($result)) {
							//$tipo = $row['TIDECOD'];
							echo
							"							
							<tr onclick=\"window.location='editlanccartao.php?id=".$row['caflcod']."';\">
							<td>
							".$row['cafldesc']."
							<td>
							".$row['caflval']."
							</td>
							<td>
							".date("d/m", strtotime($row['cafldata']))."
							</td>
							<td>
							".$row['caflparc']."
							</td>							
							";
							$valor = floatval($row['caflval']);							
							$valortotal = ($valor + $valortotal);
							//$valorlinha = floatval($row['TOTAL']);
							//$valor = (($valorlinha * 100) / $total);				
							
					};	echo "Total: "; echo number_format($valortotal,2,",",".");
				echo"				
				</tbody>  
		</table>
				";	
				
?>