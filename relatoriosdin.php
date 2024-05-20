<?php
/*
	session_start();
	if (empty($_SESSION['user'])) 
	{
		return header('location: login.html');
	}*/
	
?>

<?php
	include "conexao.php";
	
	$mes = date('m');
	$ano = date('Y');
	
	/*date_default_timezone_set('Brazil/East'); 
		if (date('d')> 13){
			$mes =  date('m', strtotime('+1 month')); 
		} 
		else{ 
		$mes =  date('m'); 
		}
	
	if (date('m')==12){
				$ano = date('Y', strtotime('+1 year')); 
			}
			else{
				$ano = date('Y');
			}*/
	
	$conexao = mysqli_connect($hostName,$userName,$passWord,$nomeBanco);

	setlocale(LC_MONETARY, 'pt_BR');
	setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');	
	
    //$query = "select format(sum(carflu.caflval),2,'pt_BR') as TOTAL, tidedesc        from carflu,tipdes where carflu.cafltipo = tipd-es.tidecod and carflu.caflfecha = '$mes' GROUP BY carflu.cafltipo";
	
	//$query = "select format (sum(fluxo.valor),2,'pt_BR') as TOTAL, tidedesc from fluxo,tipdes where fluxo.tipocod = tipdes.tidecod GROUP BY fluxo.tipocod";
	$query = "select format (sum(fluxo.valor),2,'pt_BR') as TOTAL, tidedesc from fluxo,tipdes where fluxo.tipocod = tipdes.tidecod AND fluxo.DATAPAG like '%$ano-$mes%' AND fluxo.CONTA = 'D' GROUP BY fluxo.tipocod ORDER BY tipdes.tidedesc";
	
	
	
	
?>
<html>
	<head>
		<title>Relatórios - Gastos - Dinheiro</title>
		<link href="https://fonts.googleapis.com/css?family=Lobster|Pangolin|Sansita" rel="stylesheet">
		<meta charset="utf-8"/>
		<meta name="description" content="Página de notícias."/>
		<link href="css/style.css" rel="stylesheet" type="text/css"/>		
		<meta name="viewport" content="width=device-width, initial-scale=1">
	</head>
	<body>		
	<!-- MENU DROPDOWN -->
	<?php include "menu.html"; ?>
	<!-- MENU DROPDOWN -->					
		
	<div class="conteudo">
	<div class="opcoes">					
		Mês: <select name="mes" id="mes">
						<option value="<?php echo"$mes"?>"><?php echo"$mes";?></option>
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
	</div>
	<div id="dados">
		<div class="esquerdo">
		<link href="css/stylegrafico.css" rel="stylesheet" type="text/css"/>
		<canvas id="canvas" style="width:100%; display: block;" ></canvas>
		</div>
	   <div class="direito">
	   <link href="css/stylegrafico.css" rel="stylesheet" type="text/css"/>
		<table id=tabela border="1" style="width:80%; text-align:center;">	
			 <thead> 
			  <tr>
				<th>Descrição</th>
				<th>Valor</th> 
			  </tr>
			 </thead>
			<tbody>  	 
				<?php
					$result = mysqli_query($conexao,$query);
					while($row = mysqli_fetch_array($result)) {
							echo
							"
							<tr>
							<td>
							".$row['tidedesc']."
							</td>
							<td>
							".$row['TOTAL']."
							</td>
							";
					};	
				?>			
				</tbody>  
		</table>
		
		<?php
					$resultfechamento = mysqli_query($conexao,$queryfechamento);
					$rowfecha = mysqli_fetch_assoc($resultfechamento);
					$total = $rowfecha['cafesaldo'];		
					echo"
					<h4><strong>Valor Total: $total</strong></h4>
					";
		?>
		</div>		
	</div>
	
	<div id='tabela2' style="width:100%; float:left;">		
						

		</div>
	
	</div>


<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js" ></script>	
	<script type="text/javascript">	
		$("select[name='mes']").change(function(){			
			$.ajax({
				url: 'filtrarelatdin.php?mes=' + $(this).val()+'&ano='+ $("select[name='ano']").val(),
				//url: 'grafpizcart.php?mes=' + $(this).val()+'&ano='+ $("select[name='ano']").val(),
				type: 'GET',
				dataType: 'html',
				success: function (data) {
					$('div#dados').html(data);
					MontaGrafico();
				}
			});
		});
		$("select[name='ano']").change(function(){			
			$.ajax({
				url: 'filtrarelatdin.php?mes=' + $("select[name='mes']").val()+'&ano='+$(this).val(),
				type: 'GET',
				dataType: 'html',
				success: function (data) {
					$('div#dados').html(data);
					MontaGrafico();
				}
			});
		});		
		
		$.ajax({
				url: 'filtrarelatdin.php?mes=' + $("select[name='mes']").val() +'&ano='+ $("select[name='ano']").val(),
				type: 'GET',
				dataType: 'html',
				success: function (data) {
					$('div#dados').html(data);
					MontaGrafico();
				}
			});
			
		/*function chamaGraf()$.ajax({
				url: 'graflincart.php?mes=' + $("select[name='mes']").val() +'&ano='+ $("select[name='ano']").val()+'&tipo='+ $("select[name='ano']").val(),,
				type: 'GET',
				dataType: 'html',
				success: function (data) {
					$('div#dados').html(data);
					MontaGrafico();
				}
			});*/			
	</script>	
	
	<script type="text/javascript">	 
	
	function MontaGrafico(){
	 
	// a tabela e o elemento canvas na marcação HTML   
	var data_table = document.getElementById('tabela');  
	var canvas = document.getElementById('canvas');  
	var td_index = 1; // qual td comtém os dados
	  

	var tds, data = [], color, colors = [], value = 0, total = 0;  
	var trs = data_table.getElementsByTagName('tr'); // todas as tr's   
	for (var i = 0; i < trs.length; i++) {      
	tds = trs[i].getElementsByTagName('td'); // todas as td's
			 
	if (tds.length === 0) continue; //  não há td's, vá em frente
			 
	// extrair o valor da td e atualizar o total       
	value  = parseFloat(tds[td_index].innerHTML);      
	data[data.length] = value;      
	total += value;
			
	// cor randômica       
	color = getColor();      
	colors[colors.length] = color; // armazena       
	trs[i].style.backgroundColor = color; // colorir a tr   
	}

	 
	 
	// estabelecer contexto e definir raio e centro   
	var ctx = canvas.getContext('2d');  
	var canvas_size = [canvas.width, canvas.height];  
	var radius = Math.min(canvas_size[0], canvas_size[1]) / 2;  
	var center = [canvas_size[0]/2, canvas_size[1]/2];

	 
	 
	var sofar = 0; // monitora o andamento do script   
	// loop por data[]   
	for (var piece in data) {        
	var thisvalue = data[piece] / total;        
	ctx.beginPath();      
	ctx.moveTo(center[0], center[1]); 
	// centro do gráfico       
	ctx.arc(  // desenha próximo arco           
	center[0],          
	center[1],          
	radius,         
	 Math.PI * (- 0.5 + 2 * sofar), // -0.5 define o início no topo           
	Math.PI * (- 0.5 + 2 * (sofar + thisvalue)),          false      );        
	ctx.lineTo(center[0], center[1]); // linha de retorno ao centro      
	 ctx.closePath();      
	ctx.fillStyle = colors[piece];    // cor       
	ctx.fill();        
	sofar += thisvalue; // incrementa o andamento do script   
	}

	// gera uma cor randômica       
	function getColor() {          
	var rgb = [];          
	for (var i = 0; i < 3; i++) {              
	rgb[i] = Math.round(100 * Math.random() + 155) ; // [155-255] = lighter colors           
	}          
	return 'rgb(' + rgb.join(',') + ')';      
	}
	}
	</script>
	
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js" ></script>	
		<script type="text/javascript">	
		function mstTabela(tipo) {
			var tip = tipo;
			$.ajax({
					url: 'filtrarelatdintabela.php?mes=' + $("select[name='mes']").val()+'&ano='+ $("select[name='ano']").val()+'&tipo='+ tip,
					type: 'GET',
					dataType: 'html',
					success: function (data) {
						$('div#tabela2').html(data);
					}
				});
		}
	</script>
	
</body>
</html>