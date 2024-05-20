	<?php
	include "conexao.php";
	
	$mes = $_GET["mes"];	
	$ano = $_GET["ano"];	
	$tipo = $_GET["tipo"];
	
	//$querytabela = "SELECT * FROM carflu, carori where caflori = caorcod and caflfecha = '$ano-$mes' and cafltipo = '$tipo' order by cafldata";
	$querytabela = "SELECT * FROM fluxo WHERE CONTA = 'D' AND LEFT(DATAPAG,7) = '$ano-$mes' and TIPOCOD = '$tipo' order by DATAPAG";
	
	$sql=mysqli_query($conexao,$querytabela);
	
	echo'
	<table border="1" style="width:100%; text-align:center;">	
		<tr>		
		<th>Descrição</th>
		<th>Origem</th>
		<th>Valor</th>
		<th>Parcela</th>
		<th>Data Trans.</th>
		</tr>';
	

		while($row = mysqli_fetch_array($sql)) {
				echo"<tr>
				<!--<tr onclick=\"window.location='editlanc.php?id=".$row['FLUCOD']."';\">-->";
				echo"
				<td>
				".$row['FLUDESC']."
				</td>
				<td>
				".$row['ORIGEM']."
				</td>
				<td>
				".$row['VALOR']."
				</td>
				<td>
				".$row['PARCELA']."
				</td>
				<td>
				".$row['DATATRANS']."
				</td>		
			";
		};	
		echo"</table>";
	//};		
				?>