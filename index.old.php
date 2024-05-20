<?php
/*
	session_start();
	if (empty($_SESSION['user'])) 
	{
		return header('location: login.html');
	}
	*/
?>
	
<?php
	include "conexao.php";
	$mes = date('m');
	$ano = date('Y');
	
	$query = "SELECT * FROM fluxo, origem where fluxo.ORIGEM = origem.cod order by DATAPAG";	
	$querymontante = "SELECT ROUND(SUM(saldo),2) as montante from origem where ORIDESC <>'Cartão'";
	$queryprevisaorec = "SELECT ROUND(SUM(valor),2) as valor from fluxo where PAGO = 'N' and CONTA='R' and DATAPAG < last_day(date(concat_ws('-', '$ano', '$mes', 1)))";
	$queryprevisaodep = "SELECT ROUND(SUM(valor),2) as valor from fluxo where PAGO = 'N' and CONTA='D' and DATAPAG < last_day(date(concat_ws('-', '$ano', '$mes', 1)))";	
	//$queryprevisao = "SELECT ROUND(SUM(valor),2) as valor from fluxo where PAGO = 'N' and DATAPAG < LAST_DAY(now())";
	//$query1 = "SELECT * FROM clientes ORDER BY NOMEFANT ASC";
	//$query2 = "SELECT codiuser, nameuser FROM login";
	//$query = "SELECT jogos.jogador1,jogos.jog1pont,jogos.jogador2,jogos.jog2pont,jogos.datapart,login.codiuser, login.nameuser FROM jogos,login where jogos. ";	
?>

<html>
	<head>
		<title>Caixa</title>
		<link href="https://fonts.googleapis.com/css?family=Lobster|Pangolin|Sansita" rel="stylesheet">
		<meta charset="utf-8"/>
		<meta name="description" content="Página Inicial."/>
		<link href="css/style.css" rel="stylesheet" type="text/css"/>
		<meta name="viewport" content="width=device-width, initial-scale=1">				
	</head>
	<body>		
	<!-- MENU DROPDOWN -->
	<?php include "menu.html"; ?>
	<!-- MENU DROPDOWN -->
					
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js" ></script>	
	<script type="text/javascript">
		$(function() {
    if (localStorage.getItem("select[name='conta']")) {
        $("select[name='conta'] option").eq(localStorage.getItem("select[name='conta']")).prop('selected', true);
    }

    $("select[name='conta']").on('change', function() {
        localStorage.setItem("select[name='conta']", $('option:selected', this).index());
		});
	});
	
	$(document).ready(function(){
		$("select[name='conta']").change(function(){			
			$.ajax({
				url: 'filtrafluxo.php?mes=' + $("select[name='mes']").val() +'&ano='+ $("select[name='ano']").val()+'&conta='+ $(this).val(),
				type: 'GET',
				dataType: 'html',
				success: function (data) {
					$('div#tabela').html(data);
				}
			});
		});
		$("select[name='mes']").change(function(){			
			$.ajax({
				url: 'filtrafluxo.php?mes=' + $(this).val()+'&ano='+ $("select[name='ano']").val()+'&conta='+ $("select[name='conta']").val(),
				type: 'GET',
				dataType: 'html',
				success: function (data) {
					$('div#tabela').html(data);
				}
			});
		});
		$("select[name='ano']").change(function(){			
			$.ajax({
				url: 'filtrafluxo.php?mes=' + $("select[name='mes']").val()+'&ano='+$(this).val()+'&conta='+ $("select[name='conta']").val(),
				type: 'GET',
				dataType: 'html',
				success: function (data) {
					$('div#tabela').html(data);
				}
			});
		});
		
		
		$.ajax({
				url: 'filtrafluxo.php?mes=' + $("select[name='mes']").val() +'&ano='+ $("select[name='ano']").val()+'&conta='+ $("select[name='conta']").val(),
				type: 'GET',
				dataType: 'html',
				success: function (data) {
					$('div#tabela').html(data);
				}
			});
	});

	</script>
		
		<div class="conteudo">
		
		Conta: <select name="conta" id="conta" >
						<option value="D">Despesas </option>
						<option value="R">Receitas </option>						
						</select>	
		<!--Pago: <select name="pago" id="pago" >
						<option value="">Todos </option>						
						<option value="S">Sim </option>
						<option value="N">Não </option>						
						</select> -->
		</br>						
		</br>						
		Mês: <select name="mes" id="mes">
						<option value="<?php echo"$mes"?>"><?php echo ucfirst (strftime("%B"));?></option>
						<option value="01">Janeiro </option>
						<option value="02">Fevereiro </option>						
						<option value="03">Março </option>
						<option value="04">Abril </option>
						<option value="05">Maio </option>
						<option value="06">Junho </option>
						<option value="07">Julho </option>
						<option value="08">Agosto </option>
						<option value="09">Setembro </option>
						<option value="10">Outubro </option>
						<option value="11">Novembro </option>
						<option value="12">Dezembro </option>
						</select>		
		Ano: <select name="ano" id="ano">
						<option value="<?php echo"$ano"?>"><?php echo"$ano"?></option>
						<option value="2018">2018 </option>
						<option value="2019">2019 </option>
						<option value="2020">2020 </option>
						<option value="2021">2021 </option>
						<option value="2022">2022 </option>
						<option value="2023">2023 </option>
						<option value="2024">2024 </option>
						<option value="2025">2025 </option>
						</select>
		</br>
		</br>
		<div id='tabela'>
		<?php
			$result = mysqli_query($conexao,$querymontante);
				while($row = mysqli_fetch_array($result)) {
					setlocale(LC_MONETARY, 'pt_BR');
					$montante = $row['montante'];
					echo"Saldo Atual: ".$row['montante']."";
				};

			setlocale(LC_MONETARY, 'pt_BR');		
			
			$result1 = mysqli_query($conexao,$queryprevisaorec);
			$row1 = mysqli_fetch_assoc($result1);
			$receitas = $row1['valor'];		
			echo" <br> Receitas à receber:  $receitas";
			
			$result2 = mysqli_query($conexao,$queryprevisaodep);
			$row2 = mysqli_fetch_assoc($result2);
			$despesas = $row2['valor'];		
			echo" <br> Despesas à pagar:  $despesas";
			
			$previsto =  ($montante + $receitas - $despesas);
			echo" <br> Saldo Previsto:  $previsto";
		?>			
		
		<br>
		<br>	
		
		<table border="1" style="width:100%; text-align:center;">	
		<tr>		
		<th>Conta</th>
		<th>Descrição</th>
		<th>Origem</th>
		<th>Valor</th>
		<th>Data Trans.</th>
		<th>Pago</th>
		<th>Data Pag.</th>
		</tr>		
		<?php
			$result = mysqli_query($conexao,$query);
			while($row = mysqli_fetch_array($result)) {
					echo 
					"					
					<tr onclick=\"window.location='editlanc.php?id=".$row['FLUCOD']."';\">";
					echo
					"
					<td>
					".$row['CONTA']."
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
		?>			
		
		</table>				

		</div>
		</div>
		
		
	</body>
</html>