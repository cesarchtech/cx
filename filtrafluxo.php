<?php
	include "conexao.php";
	
	//$query = "SELECT * FROM cartao";
	$mes = $_GET["mes"];
	$ano = $_GET["ano"];
	$conta = $_GET["conta"];
	$origem = $_GET["origem"];
	
	if ($origem == '0')
		$origem = NULL;
	
	//if ($conta == '0')
		//$conta = NULL;
		
	
	$querymontante = "SELECT ROUND(SUM(saldo),2) as montante from origem where ORIDESC <>'Cartao'";
	
	
	$querytotalrec = "SELECT ROUND(SUM(valor),2) as valor from fluxo WHERE CONTA='R' and DATAPAG >= (date(concat_ws('-', '$ano', '$mes', '01', 1))) and DATAPAG <= last_day(date(concat_ws('-', '$ano', '$mes', 1)))";
	if(!empty($origem)){
	$querytotalrec.= "and fluxo.ORIGEM = '$origem'";
	}
	
	$querytotaldep = "SELECT ROUND(SUM(valor),2) as valor from fluxo WHERE CONTA='D' and DATAPAG >= (date(concat_ws('-', '$ano', '$mes', '01', 1))) and DATAPAG <= last_day(date(concat_ws('-', '$ano', '$mes', 1)))";
	if(!empty($origem)){
	$querytotaldep.= "and fluxo.ORIGEM = '$origem'";
	}
	
	$querytotalrecebido = "SELECT ROUND(SUM(valor),2) as valor from fluxo WHERE PAGO = 'S' and CONTA='R' and DATAPAG >= (date(concat_ws('-', '$ano', '$mes', '01', 1))) and DATAPAG <= date(now())";
	if(!empty($origem)){
	$querytotalrecebido.= "and fluxo.ORIGEM = '$origem'";
	}
	
	$querytotalpago = "SELECT ROUND(SUM(valor),2) as valor from fluxo WHERE PAGO = 'S' and CONTA='D' and DATAPAG >= (date(concat_ws('-', '$ano', '$mes', '01', 1))) and DATAPAG <= date(now())";
	if(!empty($origem)){
	$querytotalpago.= "and fluxo.ORIGEM = '$origem'";
	}
	
	$queryprevisaorec = "SELECT ROUND(SUM(valor),2) as valor from fluxo WHERE PAGO = 'N' and CONTA='R' and DATAPAG <= last_day(date(concat_ws('-', '$ano', '$mes', 1)))";
	if(!empty($origem)){
	$queryprevisaorec.= "and fluxo.ORIGEM = '$origem'";
	}
	
	$queryprevisaodep = "SELECT ROUND(SUM(valor),2) as valor from fluxo WHERE PAGO = 'N' and CONTA='D' and DATAPAG <= last_day(date(concat_ws('-', '$ano', '$mes', 1)))";
	if(!empty($origem)){
	$queryprevisaodep.= "and fluxo.ORIGEM = '$origem'";
	}
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
	
	
	//$sql=mysqli_query($conexao,"SELECT * FROM fluxo, origem WHERE fluxo.ORIGEM and ('$origem' IS NULL OR fluxo.ORIGEM=@'$origem') and fluxo.ORIGEM = origem.cod and CONTA='$conta' and MONTH(DATAPAG) ='$mes' and YEAR(DATAPAG) = '$ano' ORDER BY DATAPAG ASC");
	$query = "SELECT * FROM fluxo, origem WHERE ";
	if(!empty($origem)){
	$query.= "fluxo.ORIGEM = '$origem' and ";
	}
	$query.= "fluxo.ORIGEM = origem.cod and CONTA='$conta' and MONTH(DATAPAG) ='$mes' and YEAR(DATAPAG) = '$ano' ORDER BY DATAPAG ASC";
	$sql=mysqli_query($conexao,$query);
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