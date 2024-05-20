<?php
	include "conexao.php";
	
	//$query = "SELECT * FROM cartao";
	$mes = $_GET["mes"];
	$ano = $_GET["ano"];
	$tipo = $_GET["tipo"];
	?>
	
<html>
  <head>
  
		<link href="css/style.css" rel="stylesheet" type="text/css"/>		
		<meta name="viewport" content="width=device-width, initial-scale=1">
		
<!--Load the AJAX API-->
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
	
//google.charts.load('current', {packages: ['corechart']});
google.charts.load('current', {packages: ['corechart', 'line']});
//google.charts.load('current', {'packages':['line']});
google.charts.setOnLoadCallback(drawChart);

function drawChart() {
    $.ajax({
		url: 'gerajsongraflindin.php?mes=' + $("select[name='mes']").val() +'&ano='+ $("select[name='ano']").val()+'&tipo='+ $("select[name='tipo']").val(),
        //url: "gerajson.php?mes=07&ano=2019&tipo=1",
        dataType: "JSON",
        success: function (jsonData) {
			//alert(jsonData);			
            var dataArray = [
                ['MES', 'TOTAL', 'MEDIA'],
				//['DESCRIÇÃO', 'TOTAL'],
            ];

            for (var i = 0; i < jsonData.length; i++) {
                //var row = [jsonData[i].MES, parseFloat(jsonData[i].TOTAL)];
				var row = [jsonData[i].MES, parseFloat(jsonData[i].TOTAL),parseFloat(jsonData[i].MEDIA)];
				//var row = [jsonData[i].CATIDESC, parseFloat(jsonData[i].TOTAL)];
                dataArray.push(row);
            }
            var options = {
                title: 'Gastos por Categoria',
                //curveType: 'function',
				width:'90%',
                height:'90% 	',
                //series: {0: {"color": '#57c8f2'}}
            };

            var data = google.visualization.arrayToDataTable(dataArray);

            var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
            chart.draw(data, options);
        }
    });
}	
    </script>						
      
  </head>

  <body>
    <!--Div that will hold the pie chart-->
	<select name="mes" id="mes" hidden>
						<option value="<?php echo"$mes"?>"><?php echo"$mes"?></option>
						</select>		
	<select name="ano" id="ano" hidden>
						<option value="<?php echo"$ano"?>"><?php echo"$ano"?></option>					
						</select>				
	<select name="tipo" id="tipo" hidden>
						<option value="<?php echo"$tipo"?>"><?php echo"$tipo"?></option>					
						</select>								
    <div class="conteudo" id="chart_div" style="width: 100%; height: 100%;"></div>
  </body>
</html>