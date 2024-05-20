	<?php
	include "conexao.php";
	
	$mes = $_GET["mes"];	
	$ano = $_GET["ano"];	
	$tipo = $_GET["tipo"];
	
	$querytabela = "SELECT * FROM carflu, carori where caflori = caorcod and caflfecha = '$ano-$mes' and cafltipo = '$tipo' order by cafldata";
	
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
				<!--<tr onclick=\"window.location='editlanc.php?id=".$row['caflcod']."';\">-->";
				echo"
				<td>
				".$row['cafldesc']."
				</td>
				<td>
				".$row['caordesc']."
				</td>
				<td>
				".$row['caflval']."
				</td>
				<td>
				".$row['caflparc']."
				</td>
				<td>
				".$row['cafldata']."
				</td>		
			";
		};	
		echo"</table>";
	//};		
				?>