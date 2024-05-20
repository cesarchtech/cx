	<?php
	include "conexao.php";
	
	//$query = "SELECT * FROM cartao";
	$diade = $_GET["diade"];
	$diaate = $_GET["diaate"];
	
	$mes = $_GET["mesde"];
	$mesate = $_GET["mesate"];
	
	$ano = $_GET["anode"];
	$anoate = $_GET["anoate"];
	
	$conta = $_GET["conta"];
	$tipo = $_GET["tipo"];
	
	//$querytipo = "SELECT *, tiprec.tiredesc as TIP FROM fluxo, tiprec, origem where fluxo.ORIGEM = origem.cod and (fluxo.TIPOCOD = tiprec.tirecod) and CONTA='$conta' and DAY(DATAPAG) BETWEEN '$diade' and '$diaate' and MONTH(DATAPAG) BETWEEN '$mes' AND '$mesate' and YEAR(DATAPAG) BETWEEN '$ano' AND '$anoate' AND tiprec.tirecod like '%$tipo%' ORDER BY DATAPAG ASC"
	$querytipo = "SELECT ROUND(SUM(valor),2) as valor from fluxo where CONTA='$conta' and DATAPAG >= date(concat_ws('-', '$ano', '$mes', '$diade', 1)) and DATAPAG <= date(concat_ws('-', '$anoate', '$mesate','$diaate', 1)) AND TIPOCOD = '$tipo'";
	//	$querytipo = "SELECT ROUND(SUM(valor),2) as valor from fluxo where CONTA='$conta' and DATAPAG >= (date(concat_ws('-', '$ano', '$mes', '01', 1))) and DATAPAG <= last_day(date(concat_ws('-', '$ano', '$mes', 1))) AND TIPOCOD like '%$tipo%'";

/*	
	$querymontante = "SELECT ROUND(SUM(saldo),2) as montante from origem where ORIDESC <>'Cartao'";
	
	$querytotalrec = "SELECT ROUND(SUM(valor),2) as valor from fluxo where CONTA='R' and DATAPAG >= (date(concat_ws('-', '$ano', '$mes', '01', 1))) and DATAPAG <= last_day(date(concat_ws('-', '$ano', '$mes', 1)))";
	$querytotaldep = "SELECT ROUND(SUM(valor),2) as valor from fluxo where CONTA='D' and DATAPAG >= (date(concat_ws('-', '$ano', '$mes', '01', 1))) and DATAPAG <= last_day(date(concat_ws('-', '$ano', '$mes', 1)))";
	
	$querytotalrecebido = "SELECT ROUND(SUM(valor),2) as valor from fluxo where PAGO = 'S' and CONTA='R' and DATAPAG >= (date(concat_ws('-', '$ano', '$mes', '01', 1))) and DATAPAG <= date(now())";
	$querytotalpago = "SELECT ROUND(SUM(valor),2) as valor from fluxo where PAGO = 'S' and CONTA='D' and DATAPAG >= (date(concat_ws('-', '$ano', '$mes', '01', 1))) and DATAPAG <= date(now())";
	
	$queryprevisaorec = "SELECT ROUND(SUM(valor),2) as valor from fluxo where PAGO = 'N' and CONTA='R' and DATAPAG <= last_day(date(concat_ws('-', '$ano', '$mes', 1)))";
	$queryprevisaodep = "SELECT ROUND(SUM(valor),2) as valor from fluxo where PAGO = 'N' and CONTA='D' and DATAPAG <= last_day(date(concat_ws('-', '$ano', '$mes', 1)))";
	//$queryprevisao = "SELECT ROUND(SUM(valor),2) as valor from fluxo where PAGO = 'N' and MONTH(DATAPAG) ='$mes' and YEAR(DATAPAG) = '$ano' ORDER BY DATAPAG ASC";	
	*/
	echo'
	<div id="tabela">
	<div id=blocofuturo>
	</div>
	<div id=blocomes>
	</div>
	';

	setlocale(LC_MONETARY, 'pt_BR');	
	$resulttp = mysqli_query($conexao,$querytipo);
	$rowtp = mysqli_fetch_assoc($resulttp);
	$tipos = $rowtp['valor'];
	echo"Saldo do Tipo: ".$rowtp['valor']."<br><br>";
	
	/*
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
		
	echo" <br> Saldo Previsto:  $previsto <br>";			
	
	$result5 = mysqli_query($conexao,$querytotalrec);
	$row5 = mysqli_fetch_assoc($result5);
	$receitasmes = $row5['valor'];	
	echo" <br> Receitas do mês:  $receitasmes";	
	
	$result6 = mysqli_query($conexao,$querytotaldep);
	$row6 = mysqli_fetch_assoc($result6);
	$despesasmes = $row6['valor'];		
	echo" <br> Despesas do mês:  $despesasmes";	
	
	
	$totalmes =  ($receitasmes - $despesasmes);
	
	echo" <br>Total Mês:  $totalmes <br> <br>";		
		*/
	echo'
	<table border="1" style="width:100%; text-align:center;">	
		<tr>		
		<th>Conta</th>
		<th>Tipo</th>
		<th>Descrição</th>
		<th>Origem</th>
		<th>Valor</th>
		<th>Parcela</th>
		<th>Data Trans.</th>
		<th>Pago</th>
		<th>Data Pag.</th>
		</tr>';
	
//	$sql=mysqli_query($conexao,"SELECT * FROM fluxo, origem where fluxo.ORIGEM = origem.cod and CONTA='$conta' and MONTH(DATAPAG) ='$mes' and YEAR(DATAPAG) = '$ano' AND TIPOCOD = '$tipo' ORDER BY DATAPAG ASC");
	//$sql=mysqli_query($conexao,"SELECT * FROM fluxo, tipo, origem where fluxo.ORIGEM = origem.cod and (fluxo.TIPOCOD = tipo.tipocodigo) and CONTA='$conta' and MONTH(DATAPAG) ='$mes' and YEAR(DATAPAG) = '$ano' AND TIPOCOD like '%$tipo%' ORDER BY DATAPAG ASC");
	if ($conta == 'R')
	{
		$sql=mysqli_query($conexao,"SELECT *, tiprec.tiredesc as TIP FROM fluxo, tiprec, origem where fluxo.ORIGEM = origem.cod and (fluxo.TIPOCOD = tiprec.tirecod) and CONTA='$conta' and DATAPAG >= date(concat_ws('-', '$ano', '$mes', '$diade', 1)) and DATAPAG <= date(concat_ws('-', '$anoate', '$mesate','$diaate', 1)) AND tiprec.tirecod = '$tipo' ORDER BY DATAPAG ASC");
		//$sql=mysqli_query($conexao,"SELECT *, tiprec.tiredesc as TIP FROM fluxo, tiprec, origem where fluxo.ORIGEM = origem.cod and (fluxo.TIPOCOD = tiprec.tirecod) and CONTA='$conta' and DAY(DATAPAG) BETWEEN '$diade' and '$diaate' and MONTH(DATAPAG) BETWEEN '$mes' AND '$mesate' and YEAR(DATAPAG) BETWEEN '$ano' AND '$anoate' AND tiprec.tirecod like '%$tipo%' ORDER BY DATAPAG ASC");
		//$sql=mysqli_query($conexao,"SELECT *, tipdes as TIP FROM fluxo, tipdes, tiprec, origem where fluxo.ORIGEM = origem.cod and (fluxo.TIPOCOD = tiprec.tirecod) and CONTA='$conta' and DAY(DATAPAG)= '$diade' and MONTH(DATAPAG) ='$mes' and YEAR(DATAPAG) = '$ano' AND tiprec.tirecod like '%$tipo%' ORDER BY DATAPAG ASC");
	}else
	{
		$sql=mysqli_query($conexao,"SELECT *, tipdes.tidedesc as TIP FROM fluxo, tipdes, origem where fluxo.ORIGEM = origem.cod and (fluxo.TIPOCOD = tipdes.tidecod) and CONTA='$conta' and DATAPAG >= date(concat_ws('-', '$ano', '$mes', '$diade', 1)) and DATAPAG <= date(concat_ws('-', '$anoate', '$mesate','$diaate', 1)) AND tipdes.tidecod = '$tipo' ORDER BY DATAPAG ASC");
		//$sql=mysqli_query($conexao,"SELECT *, tiprec as TIP FROM fluxo, tipdes, tiprec, origem where fluxo.ORIGEM = origem.cod and (fluxo.TIPOCOD = tipdes.tidecod) and CONTA='$conta' and DAY(DATAPAG)= '$diade' and MONTH(DATAPAG) ='$mes' and YEAR(DATAPAG) = '$ano' AND tipdes.tidecod like '%$tipo%' ORDER BY DATAPAG ASC");
	}
	
	
	//if(mysqli_num_rows($sql)){
		while($row = mysqli_fetch_array($sql)) {
				echo"<tr>
				<!--<tr onclick=\"window.location='editlanc.php?id=".$row['FLUCOD']."';\">-->";
				echo"
				<td>
				".$row['CONTA']."
				</td>
				<td>
				".$row['TIP']."
				</td>
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
				".$row['DATATRANS']."
				</td>
				<td>
				".$row['PAGO']."
				</td>
				<td>
				".$row['DATAPAG']."
				</td>			
			";
		};	
		echo"</table>";
	//};		
				?>