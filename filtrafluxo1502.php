<?php
	include "conexao.php";
	
	//$query = "SELECT * FROM cartao";
	$mes = $_GET["mes"];
	$ano = $_GET["ano"];
	$conta = $_GET["conta"];
	
	$querymontante = "SELECT ROUND(SUM(saldo),2) as montante from origem where ORIDESC <>'Cartao'";
	
	$querytotalrec = "SELECT ROUND(SUM(valor),2) as valor from fluxo where CONTA='R' and DATAPAG >= (date(concat_ws('-', '$ano', '$mes', '01', 1))) and DATAPAG <= last_day(date(concat_ws('-', '$ano', '$mes', 1)))";
	$querytotaldep = "SELECT ROUND(SUM(valor),2) as valor from fluxo where CONTA='D' and DATAPAG >= (date(concat_ws('-', '$ano', '$mes', '01', 1))) and DATAPAG <= last_day(date(concat_ws('-', '$ano', '$mes', 1)))";
	
	$querytotalrecebido = "SELECT ROUND(SUM(valor),2) as valor from fluxo where PAGO = 'S' and CONTA='R' and DATAPAG >= (date(concat_ws('-', '$ano', '$mes', '01', 1))) and DATAPAG <= date(now())";
	$querytotalpago = "SELECT ROUND(SUM(valor),2) as valor from fluxo where PAGO = 'S' and CONTA='D' and DATAPAG >= (date(concat_ws('-', '$ano', '$mes', '01', 1))) and DATAPAG <= date(now())";
	
	$queryprevisaorec = "SELECT ROUND(SUM(valor),2) as valor from fluxo where PAGO = 'N' and CONTA='R' and DATAPAG <= last_day(date(concat_ws('-', '$ano', '$mes', 1)))";
	$queryprevisaodep = "SELECT ROUND(SUM(valor),2) as valor from fluxo where PAGO = 'N' and CONTA='D' and DATAPAG <= last_day(date(concat_ws('-', '$ano', '$mes', 1)))";
	//$queryprevisao = "SELECT ROUND(SUM(valor),2) as valor from fluxo where PAGO = 'N' and MONTH(DATAPAG) ='$mes' and YEAR(DATAPAG) = '$ano' ORDER BY DATAPAG ASC";	
	
	echo'
	<div id="tabela">
	<div id=blocofuturo>
	</div>
	<div id=blocomes>
	</div>
	';

	setlocale(LC_MONETARY, 'pt_BR');	
	
	$result = mysqli_query($conexao,$querymontante);
	$row = mysqli_fetch_assoc($result);
	$montante = $row['montante'];
	echo"Saldo Atual: ".$row['montante']."<br>";
		
	$result1 = mysqli_query($conexao,$queryprevisaorec);
	$row1 = mysqli_fetch_assoc($result1);
	$receitas = $row1['valor'];	
	echo" <br> Receitas à receber:  $receitas";	
	
	$result2 = mysqli_query($conexao,$queryprevisaodep);
	$row2 = mysqli_fetch_assoc($result2);
	$despesas = $row2['valor'];		
	echo" <br> Despesas à pagar:  $despesas" ;	
	
	$previsto =  ($montante + $receitas - $despesas);
		
	echo" <br> Saldo Previsto:  $previsto <br><br>";			
		
	echo'
	<table border="1" style="width:100%; text-align:center;">	
		<tr>		
		<th>Descrição</th>
		<th>Origem</th>
		<th>Valor</th>
		<th>Parcela</th>
		<th>Data Trans.</th>
		<th>Pago</th>
		<th>Data Pag.</th>
		</tr>';
	
	
	$sql=mysqli_query($conexao,"SELECT * FROM fluxo, origem where fluxo.ORIGEM = origem.cod and CONTA='$conta' and MONTH(DATAPAG) ='$mes' and YEAR(DATAPAG) = '$ano' ORDER BY DATAPAG ASC");
	//if(mysqli_num_rows($sql)){
		while($row = mysqli_fetch_array($sql)) {
				echo"
				<tr onclick=\"window.location='editlanc.php?id=".$row['FLUCOD']."';\">";
				echo"
				<td>
				".$row['FLUDESC']."
				</td>
				<td>
				".$row['ORIDESC']."
				</td>
				<td>
				".$row['VALOR']."
				</td>
				<td>
				".$row['PARCELA']."
				</td>
				<td>
				";
				echo
				date("d/m", strtotime($row['DATATRANS']));
				echo"
				</td>
				<td>
				".$row['PAGO']."
				</td>
				<td>
				";
				echo
				date("d/m", strtotime($row['DATAPAG']));
				echo"
				</td>			
			";
		};	
		echo"</table>";
	//};		
				?>