<?php
	include "conexao.php";
	
	//$query = "SELECT * FROM cartao";
	$mes = $_GET["mes"];
	$ano = $_GET["ano"];
	$tipo = $_GET["tipo"];
	
	//$query = "select TOTAL, MES FROM (select format(sum(carflu.caflval),2,'pt_BR') as TOTAL, CAFLFECHA as MES, CAFLTIPO from carflu where cafltipo = $tipo and caflfecha <= '$ano-$mes' GROUP BY caflfecha) as tabela1";
	
	$query = "select TOTAL, CATIDESC FROM (select format(sum(carflu.caflval),2,'pt_BR') as TOTAL, CARTIP.CATIDESC as CATIDESC from carflu,cartip where carflu.cafltipo = cartip.caticod and carflu.caflfecha = '$ano-$mes' GROUP BY carflu.cafltipo) as tabela1 order by CAST(TOTAL AS unsigned) DESC";
	//$query = "select format(sum(carflu.caflval),2,'pt_BR') as TOTAL, CARTIP.CATIDESC from carflu,cartip where carflu.cafltipo = cartip.caticod and carflu.caflfecha = '$ano-$mes' GROUP BY carflu.cafltipo";
	$queryfechamento = "select * from carfec where cafefecha = 	'$ano-$mes'";	
	
	$result = mysqli_query($conexao,$query);
	while($resultado = mysqli_fetch_array($result)) {
			
	$dados[] = array("CATIDESC" => $resultado['CATIDESC'], "TOTAL" => $resultado['TOTAL']); // assim por diante com todos os campos
	}	

	json_encode($dados, JSON_PRETTY_PRINT);
	?>

<html>
  <head>
<!--Load the AJAX API-->
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
	
google.charts.load('current', {packages: ['corechart']});
google.charts.setOnLoadCallback(drawChartTicketsByClient);

function drawChartTicketsByClient() {
    $.ajax({
		url: 'gerajson.php?mes=' + $("select[name='mes']").val() +'&ano='+ $("select[name='ano']").val()+'&tipo='+ $("select[name='tipo']").val(),
        //url: "gerajson.php?mes=07&ano=2019&tipo=1",
        dataType: "JSON",
        success: function (jsonData) {
			//alert(jsonData);			
            var dataArray = [
                //['MES', 'TOTAL'],
				['DESCRIÇÃO', 'TOTAL'],
            ];

            for (var i = 0; i < jsonData.length; i++) {
                //var row = [jsonData[i].MES, parseFloat(jsonData[i].TOTAL)];
				var row = [jsonData[i].CATIDESC, parseFloat(jsonData[i].TOTAL)];
                dataArray.push(row);
            }
            var options = {
                title: 'Gastos por Tipo',
                curveType: 'function',
				width:'100%',
                height:'100% 	',
                series: {0: {"color": '#57c8f2'}}
            };

            var data = google.visualization.arrayToDataTable(dataArray);

            var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
            chart.draw(data, options);
        }
    });
}	
    </script>						
      
  </head>

  <body>
	<div class='conteudo'>
    <!--Div that will hold the pie chart-->
	<select name="mes" id="mes">
						<option value="<?php echo"$mes"?>"><?php echo"$mes"?></option>
						</select>		
	<select name="ano" id="ano">>
						<option value="<?php echo"$ano"?>"><?php echo"$ano"?></option>					
						</select>
	<select name="tipo" id="tipo">>
						<option value="<?php echo"$tipo"?>"><?php echo"$tipo"?></option>					
						</select>						
	</div>
    <div id="chart_div" style="width: 900px; height: 500px;"></div>
  </body>
</html>