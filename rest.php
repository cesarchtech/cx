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
	
	setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
	
	
	$mes = $_GET["mes"];
	$ano = $_GET["ano"];
	
	switch ($mes){
		case "Janeiro":
			$mes = 1;
			break;
		case "Fevereiro":
			$mes = 2;
			break;
		case "Março":
			$mes = 3;
			break;		
		case "Abril":
			$mes = 4;
			break;		
		case "Maio":
			$mes = 5;
			break;		
		case "Junho":
			$mes = 6;
			break;		
		case "Julho":
			$mes = 7;
			break;		
		case "Agosto":
			$mes = 8;
			break;		
		case "Setembro":
			$mes = 9;
			break;		
		case "Outubro":
			$mes = 10;
			break;		
		case "Novembro":
			$mes = 11;
			break;		
		case "Dezembro":
			$mes = 12;
			break;							
	}
	
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
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js" ></script>	
	<script type="text/javascript">
	$(document).ready(function(){
		//AO MUDAR O SELECT CONTA
		$("select[name='conta']").change(function(){			
/*			$.ajax({				
//				url: 'filtrarelatorios.php?diade='+ $("select[name='diade']").val()+'&diaate='+ $("select[name='diaate']").val()+'&mesde=' + $("select[name='mesde']").val() +'&mesate='+ $("select[name='mesate']").val()+'&anode='+ $("select[name='anode']").val()+'&anoate='+ $("select[name='anoate']").val()+'&conta='+ $(this).val()+'&tipo='+ $("select[name='tipo']").val(),
				url: 'filtrarelatorios.php?mes=' + $("select[name='mes']").val() +'&ano='+ $("select[name='ano']").val()+'&conta='+ $(this).val()+'&tipo='+ $("select[name='tipo']").val(),
				type: 'GET',
				dataType: 'html',
				success: function (data) {
					$('div#tabela').html(data);
				}
			});*/
			//FILTRA A CATEGORIA COM BASE NA CONTA SELECIONADA
			$.ajax({
				url: 'filtracat.php?id=' + $(this).val(),
				type: 'GET',
				dataType: 'html',
				success: function (data) {
					$('select#tipo').html(data);
				}
			});
		});
		// AO MUDAR O MESDE
		$("select[name='mesde']").change(function(){			
			$.ajax({ //MUDA O DIADE 
				url: 'filtradiaderelatorios.php?mesde='+$(this).val() +'&anode='+$("select[name='anode']").val(),
				type: 'GET',
				dataType: 'html',
				success: function (data) {
					$('select#diade').html(data);
				//}
			//});
				$.ajax({ //FILTRA OS RELATORIOS COM BASE NAS INFORMAÇOES SELECIONADAS.
				url: 'filtrarelatorios.php?diade='+ $('select#diade').html(data).val()+'&diaate='+ $("select[name='diaate']").val() +'&mesde=' + $("select[name='mesde']").val() +'&mesate='+ $("select[name='mesate']").val() +'&anode='+ $("select[name='anode']").val()+'&anoate='+ $("select[name='anoate']").val()+'&conta='+ $("select[name='conta']").val()+'&tipo='+ $("select[name='tipo']").val(),
				type: 'GET',
					dataType: 'html',
					success: function (data) {
						$('div#tabela').html(data);
					}
				});
			}
			});
		});
		//AO MUDAR O MESATE
		$("select[name='mesate']").change(function(){			
			$.ajax({ //MUDA O DIAATE 
				url: 'filtradiaaterelatorios.php?mesate='+$(this).val() +'&anoate='+$("select[name='anoate']").val(),
				type: 'GET',
				dataType: 'html',
				success: function (data) {
					$('select#diaate').html(data);
				//}
			//});
				$.ajax({ //FILTRA OS RELATORIOS COM BASE NAS INFORMAÇOES SELECIONADAS.
				url: 'filtrarelatorios.php?diade='+ $("select[name='diade']").val()+'&diaate='+ $('select#diaate').html(data).val()+'&mesde=' + $("select[name='mesde']").val() +'&mesate='+ $("select[name='mesate']").val() +'&anode='+ $("select[name='anode']").val()+'&anoate='+ $("select[name='anoate']").val()+'&conta='+ $("select[name='conta']").val()+'&tipo='+ $("select[name='tipo']").val(),
				type: 'GET',
					dataType: 'html',
					success: function (data) {
						$('div#tabela').html(data);
					}
				});
			}
			});
		});
		// AO MUDAR O ANODE
		$("select[name='anode']").change(function(){	
			$.ajax({ //MUDA O DIADE 
				url: 'filtradiaderelatorios.php?mesde=' + $("select[name='mesde']").val()+'&anode='+$(this).val(),
				type: 'GET',
				dataType: 'html',
				success: function (data) {
					$('select#diade').html(data);
				}
			}); //FILTRA OS RELATORIOS COM BASE NAS INFORMAÇOES SELECIONADAS.
			/*$.ajax({
				url: 'filtrarelatorios.php?mes=' + $("select[name='mesde']").val()+'&anode='+$(this).val()+'&conta='+ $("select[name='conta']").val()+'&tipo='+ $("select[name='tipo']").val(),
				type: 'GET',
				dataType: 'html',
				success: function (data) {
					$('div#tabela').html(data);
				}
			});*/
		});
		// AO MUDAR O ANOATE
		$("select[name='anoate']").change(function(){			
			$.ajax({ //MUDA O DIAATE
				url: 'filtradiaaterelatorios.php?mesate=' + $("select[name='mesate']").val()+'&anoate='+$(this).val(),
				type: 'GET',
				dataType: 'html',
				success: function (data) {
					$('select#diaate').html(data);
				}
			}); //FILTRA OS RELATORIOS COM BASE NAS INFORMAÇOES SELECIONADAS.
			/*$.ajax({
				//url: 'filtrarelatorios.php?mes=' + $("select[name='mesde']").val()+'&anode='+$(this).val()+'&conta='+ $("select[name='conta']").val()+'&tipo='+ $("select[name='tipo']").val(),
				type: 'GET',
				dataType: 'html',
				success: function (data) {
					$('div#tabela').html(data);
				}
			});*/
		});
		// AO MUDAR O TIPO
		$("select[name='tipo']").change(function(){			
			$.ajax({ //FILTRA OS RELATORIOS COM BASE NAS INFORMAÇOES SELECIONADAS.
				url: 'filtrarelatorios.php?diade='+ $("select[name='diade']").val()+'&diaate='+ $("select[name='diaate']").val()+'&mesde=' + $("select[name='mesde']").val() +'&mesate='+ $("select[name='mesate']").val()+'&anode='+ $("select[name='anode']").val()+'&anoate='+ $("select[name='anoate']").val()+'&conta='+ $("select[name='conta']").val()+'&tipo='+ $(this).val(),
				type: 'GET',
				dataType: 'html',
				success: function (data) {
					$('div#tabela').html(data);
				}
			});
		});		
		/*
		// AO CARREGAR A PÁGINA PELA PRIMEIRA VEZ
		$.ajax({
				url: 'filtrarelatorios.php?diade='+ $("select[name='diade']").val()+'&diaate='+ $("select[name='diaate']").val()+'&mesde=' + $("select[name='mesde']").val() +'&mesate='+ $("select[name='mesate']").val()+'&anode='+ $("select[name='anode']").val()+'&anoate='+ $("select[name='anoate']").val()+'&conta='+ $("select[name='conta']").val()+'&tipo='+ $("select[name='tipo']").val(),
	//			url: 'filtrarelatorios.php?mes=' + $("select[name='mes']").val() +'&ano='+ $("select[name='ano']").val()+'&conta='+ $("select[name='conta']").val()+'&tipo='+ $("select[name='tipo']").val(),
				type: 'GET',
				dataType: 'html',
				success: function (data) {
					$('div#tabela').html(data);
				}
			});*/
	});
	</script>
	
	
		
	<div class="conteudo">
		
		<div id='tabela'>
		<?php
			$result = mysqli_query($conexao,$querymontante);
				while($row = mysqli_fetch_array($result)) {
					setlocale(LC_MONETARY, 'pt_BR');
					$montante = $row['montante'];
					echo"Saldo Atual: ".$row['montante'].";";
				};

			setlocale(LC_MONETARY, 'pt_BR');		
			
			$result1 = mysqli_query($conexao,$queryprevisaorec);
			$row1 = mysqli_fetch_assoc($result1);
			$receitas = $row1['valor'];		
			echo" <br> Receitas à receber:  $receitas;";
			
			$result2 = mysqli_query($conexao,$queryprevisaodep);
			$row2 = mysqli_fetch_assoc($result2);
			$despesas = $row2['valor'];		
			echo" <br> Despesas à pagar:  $despesas;";
			
			$previsto =  ($montante + $receitas - $despesas);
			echo" <br> Saldo Previsto:  $previsto;";
		?>			

		</div>
	</div>
		
		
	</body>
</html>