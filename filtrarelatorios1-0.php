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
	if ($tipo == 0){
		$tipo = '';
	}
	$origem = $_GET["origem"];
	$busca = $_GET["busca"];
	
	//echo "$mes-$ano";
	$fechamento = date('Y-m', strtotime("$ano-$mes"));
	$fechamentoate = date('Y-m', strtotime("$anoate-$mesate"));
	//echo "$fechamento";
	//echo "$fechamentoate";
	
	//if ($tipo == '0')
	//{
		//$tipo = '';		
//	}	
	
	
	
	if ($busca <> '')
	{
		//$querytodos= "SELECT FLUDESC AS DESCR, ORIGEM, ORIGEM.ORIDESC AS ORI, VALOR, PARCELA AS PARC, DATAPAG AS DATA FROM fluxo, tipdes, origem where fluxo.ORIGEM = origem.cod and (fluxo.TIPOCOD = tipdes.tidecod) and CONTA='$conta' and DATAPAG >= date(concat_ws('-', '$ano', '$mes', '$diade', 1)) and DATAPAG <= date(concat_ws('-', '$anoate', '$mesate','$diaate', 1)) AND tipdes.tidecod = '$tipo' and fluxo.FLUDESC like '%$busca%' UNION ALL SELECT carflu.cafldesc as DESCR, carflu.caflori as ORIGEM, CARORI.CAORDESC AS ORI, carflu.caflval as VALOR, carflu.caflparc as PARC, carflu.cafldata as DATA FROM carflu, tipdes, carori where carflu.caflori = carori.caorcod and (carflu.cafltipo = tipdes.tidecod) and carflu.cafldata >= date(concat_ws('-', '$ano', '$mes', '$diade', 1)) and carflu.cafldata <= date(concat_ws('-', '$anoate', '$mesate','$diaate', 1)) AND tipdes.tidecod = '$tipo' and carflu.cafldesc like '%$busca%'";
		$querytodos= "SELECT FLUDESC AS DESCR, ORIGEM, ORIGEM.ORIDESC AS ORI, VALOR, PARCELA AS PARC, DATAPAG AS DATA FROM fluxo, tipdes, origem where fluxo.ORIGEM = origem.cod and (fluxo.TIPOCOD = tipdes.tidecod) and CONTA='$conta' and DATAPAG >= date(concat_ws('-', '$ano', '$mes', '$diade', 1)) and DATAPAG <= date(concat_ws('-', '$anoate', '$mesate','$diaate', 1)) AND tipdes.tidecod = '$tipo' and fluxo.FLUDESC like '%$busca%' UNION ALL SELECT carflu.cafldesc as DESCR, carflu.caflori as ORIGEM, CARORI.CAORDESC AS ORI, carflu.caflval as VALOR, carflu.caflparc as PARC, carflu.cafldata as DATA FROM carflu, tipdes, carori where carflu.caflori = carori.caorcod and (carflu.cafltipo = tipdes.tidecod) and carflu.caflfecha >= date(concat_ws('-', '$ano', '$mes', 1)) and carflu.caflfecha <= date(concat_ws('-', '$anoate', '$mesate', 1)) AND tipdes.tidecod = '$tipo' and carflu.cafldesc like '%$busca%'";
		$querytodosT= "SELECT FLUDESC AS DESCR, ORIGEM, ORIGEM.ORIDESC AS ORI, VALOR, PARCELA AS PARC, DATAPAG AS DATA FROM fluxo, tipdes, origem where fluxo.ORIGEM = origem.cod and (fluxo.TIPOCOD = tipdes.tidecod) and CONTA='$conta' and DATAPAG >= date(concat_ws('-', '$ano', '$mes', '$diade', 1)) and DATAPAG <= date(concat_ws('-', '$anoate', '$mesate','$diaate', 1)) AND tipdes.tidecod like '%$tipo%' and fluxo.FLUDESC like '%$busca%' UNION ALL SELECT carflu.cafldesc as DESCR, carflu.caflori as ORIGEM, CARORI.CAORDESC AS ORI, carflu.caflval as VALOR, carflu.caflparc as PARC, carflu.cafldata as DATA FROM carflu, tipdes, carori where carflu.caflori = carori.caorcod and (carflu.cafltipo = tipdes.tidecod) and carflu.caflfecha >= date(concat_ws('-', '$ano', '$mes', 1)) and carflu.caflfecha <= date(concat_ws('-', '$anoate', '$mesate', 1)) AND tipdes.tidecod like '%$tipo%' and carflu.cafldesc like '%$busca%'";
		$querydinR = "SELECT FLUDESC AS DESCR, ORIGEM, ORIGEM.ORIDESC AS ORI, VALOR, PARCELA AS PARC, DATAPAG AS DATA FROM fluxo, tiprec, origem where fluxo.ORIGEM = origem.cod and (fluxo.TIPOCOD = tiprec.tirecod) and CONTA='$conta' and DATAPAG >= date(concat_ws('-', '$ano', '$mes', '$diade', 1)) and DATAPAG <= date(concat_ws('-', '$anoate', '$mesate','$diaate', 1)) AND tiprec.tirecod = '$tipo' and fluxo.FLUDESC like '%$busca%' ORDER BY DATAPAG ASC";
		$querydinD = "SELECT FLUDESC AS DESCR, ORIGEM, ORIGEM.ORIDESC AS ORI, VALOR, PARCELA AS PARC, DATAPAG AS DATA FROM fluxo, tipdes, origem where fluxo.ORIGEM = origem.cod and (fluxo.TIPOCOD = tipdes.tidecod) and CONTA='$conta' and DATAPAG >= date(concat_ws('-', '$ano', '$mes', '$diade', 1)) and DATAPAG <= date(concat_ws('-', '$anoate', '$mesate','$diaate', 1)) AND tipdes.tidecod = '$tipo' and fluxo.FLUDESC like '%$busca%' ORDER BY DATAPAG ASC";	
	}else
	{	
		//$querytipo = "SELECT ROUND(SUM(valor),2) as valor from fluxo where CONTA='$conta' and DATAPAG >= date(concat_ws('-', '$ano', '$mes', '$diade', 1)) and DATAPAG <= date(concat_ws('-', '$anoate', '$mesate','$diaate', 1)) AND TIPOCOD = '$tipo'";
		//$querytodos = "SELECT FLUDESC AS DESCR, ORIGEM, ORIGEM.ORIDESC AS ORI, VALOR, PARCELA AS PARC, DATAPAG AS DATA FROM fluxo, tipdes, origem where fluxo.ORIGEM = origem.cod and (fluxo.TIPOCOD = tipdes.tidecod) and CONTA='$conta' and DATAPAG >= date(concat_ws('-', '$ano', '$mes', '$diade', 1)) and DATAPAG <= date(concat_ws('-', '$anoate', '$mesate','$diaate', 1)) AND tipdes.tidecod = '$tipo' UNION ALL SELECT carflu.cafldesc as DESCR, carflu.caflori as ORIGEM, CARORI.CAORDESC AS ORI, carflu.caflval as VALOR, carflu.caflparc as PARC, carflu.cafldata as DATA FROM carflu, tipdes, carori where carflu.caflori = carori.caorcod and (carflu.cafltipo = tipdes.tidecod) and carflu.cafldata >= date(concat_ws('-', '$ano', '$mes', '$diade', 1)) and carflu.cafldata <= date(concat_ws('-', '$anoate', '$mesate','$diaate', 1)) AND tipdes.tidecod = '$tipo'";
		$querytodos = "SELECT FLUDESC AS DESCR, ORIGEM, ORIGEM.ORIDESC AS ORI, VALOR, PARCELA AS PARC, DATAPAG AS DATA FROM fluxo, tipdes, origem where fluxo.ORIGEM = origem.cod and (fluxo.TIPOCOD = tipdes.tidecod) and CONTA='$conta' and DATAPAG >= date(concat_ws('-', '$ano', '$mes', '$diade', 1)) and DATAPAG <= date(concat_ws('-', '$anoate', '$mesate','$diaate', 1)) AND tipdes.tidecod = '$tipo' UNION ALL SELECT carflu.cafldesc as DESCR, carflu.caflori as ORIGEM, CARORI.CAORDESC AS ORI, carflu.caflval as VALOR, carflu.caflparc as PARC, carflu.cafldata as DATA FROM carflu, tipdes, carori where carflu.caflori = carori.caorcod and (carflu.cafltipo = tipdes.tidecod) and carflu.caflfecha >= '$fechamento' and carflu.caflfecha <= '$fechamentoate' AND tipdes.tidecod = '$tipo'";
		$querytodosT = "SELECT FLUDESC AS DESCR, ORIGEM, ORIGEM.ORIDESC AS ORI, VALOR, PARCELA AS PARC, DATAPAG AS DATA FROM fluxo, tipdes, origem where fluxo.ORIGEM = origem.cod and (fluxo.TIPOCOD = tipdes.tidecod) and CONTA='$conta' and DATAPAG >= date(concat_ws('-', '$ano', '$mes', '$diade', 1)) and DATAPAG <= date(concat_ws('-', '$anoate', '$mesate','$diaate', 1)) AND tipdes.tidecod like '%$tipo%' UNION ALL SELECT carflu.cafldesc as DESCR, carflu.caflori as ORIGEM, CARORI.CAORDESC AS ORI, carflu.caflval as VALOR, carflu.caflparc as PARC, carflu.cafldata as DATA FROM carflu, tipdes, carori where carflu.caflori = carori.caorcod and (carflu.cafltipo = tipdes.tidecod) and carflu.caflfecha >= '$fechamento' and carflu.caflfecha <= '$fechamentoate' AND tipdes.tidecod like '%$tipo%'";
		$querydinR = "SELECT FLUDESC AS DESCR, ORIGEM, ORIGEM.ORIDESC AS ORI, VALOR, PARCELA AS PARC, DATAPAG AS DATA FROM fluxo, tiprec, origem where fluxo.ORIGEM = origem.cod and (fluxo.TIPOCOD = tiprec.tirecod) and CONTA='$conta' and DATAPAG >= date(concat_ws('-', '$ano', '$mes', '$diade', 1)) and DATAPAG <= date(concat_ws('-', '$anoate', '$mesate','$diaate', 1)) AND tiprec.tirecod = '$tipo' ORDER BY DATAPAG ASC";
		$querydinD = "SELECT FLUDESC AS DESCR, ORIGEM, ORIGEM.ORIDESC AS ORI, VALOR, PARCELA AS PARC, DATAPAG AS DATA FROM fluxo, tipdes, origem where fluxo.ORIGEM = origem.cod and (fluxo.TIPOCOD = tipdes.tidecod) and CONTA='$conta' and DATAPAG >= date(concat_ws('-', '$ano', '$mes', '$diade', 1)) and DATAPAG <= date(concat_ws('-', '$anoate', '$mesate','$diaate', 1)) AND tipdes.tidecod = '$tipo' ORDER BY DATAPAG ASC";
	}
	
	$querycart = "SELECT carflu.cafldesc as DESCR, carflu.caflori as ORIGEM, CARORI.CAORDESC AS ORI, carflu.caflval as VALOR, carflu.caflparc as PARC, carflu.cafldata as DATA FROM carflu, tipdes, carori where carflu.caflori = carori.caorcod and (carflu.cafltipo = tipdes.tidecod) and carflu.cafldata >= date(concat_ws('-', '$ano', '$mes', '$diade', 1)) and carflu.cafldata <= date(concat_ws('-', '$anoate', '$mesate','$diaate', 1)) AND tipdes.tidecod = '$tipo' ORDER BY carflu.cafldata ASC";
	
	if ($origem == 'D' && $conta == 'R')
	{
		$sql=mysqli_query($conexao,$querydinR);
		$querytipo = "SELECT ROUND(SUM(VALOR),2) as valor from (".$querydinR.") as selecao";		
	}else
	{
		$sql=mysqli_query($conexao,$querydinD);
		$querytipo = "SELECT ROUND(SUM(VALOR),2) as valor from (".$querydinD.") as selecao";
		
	}

	if ($origem == 'C' && $conta == 'D')
	{
		$sql=mysqli_query($conexao,$querycart);
		$querytipo = "SELECT ROUND(SUM(VALOR),2) as valor from (".$querycart.") as selecao";		
	}
	
	if ($origem == 'T' && $conta == 'D' )
	{
		$sql=mysqli_query($conexao,$querytodos);	
		$querytipo = "SELECT ROUND(SUM(VALOR),2) as valor from (".$querytodos.") as selecao";				
	}	


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
	//echo"$querytodos";
	
	
	echo'
	<table border="1" style="width:100%; text-align:center;">	
		<tr>		
		<th>Descrição</th>
		<th>Origem</th>
		<th>Valor</th>
		<th>Parcela</th>
		<th>Data Pag.</th>
		</tr>';
	
//	$sql=mysqli_query($conexao,"SELECT * FROM fluxo, origem where fluxo.ORIGEM = origem.cod and CONTA='$conta' and MONTH(DATAPAG) ='$mes' and YEAR(DATAPAG) = '$ano' AND TIPOCOD = '$tipo' ORDER BY DATAPAG ASC");
	//$sql=mysqli_query($conexao,"SELECT * FROM fluxo, tipo, origem where fluxo.ORIGEM = origem.cod and (fluxo.TIPOCOD = tipo.tipocodigo) and CONTA='$conta' and MONTH(DATAPAG) ='$mes' and YEAR(DATAPAG) = '$ano' AND TIPOCOD = '$tipo' ORDER BY DATAPAG ASC");

	
	
	
	//if(mysqli_num_rows($sql)){
		while($row = mysqli_fetch_array($sql)) {
				echo"<tr>
				";
				echo"
				<td>
				".$row['DESCR']."
				</td>
				<td>
				".$row['ORI']."
				</td>
				<td>
				".$row['VALOR']."
				</td>
				<td>
				".$row['PARC']."
				</td>
				<td>
				".$row['DATA']."
				</td>			
			";
		};	
		echo"</table>";
	//};		
				?>