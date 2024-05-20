<?php
	include "conexao.php";
	
	//$query = "SELECT * FROM cartao";
	$mes = $_GET["mes"];
	$ano = $_GET["ano"];
	$tipo = $_GET["tipo"];
	
	$query = "select TOTAL, MES FROM (select format(sum(carflu.caflval),2,'pt_BR') as TOTAL, CAFLFECHA as MES, CAFLTIPO from carflu where cafltipo = $tipo and caflfecha <= '$ano-$mes' GROUP BY caflfecha) as tabela1";
	//$query = "select TOTAL, CATIDESC FROM (select format(sum(carflu.caflval),2,'pt_BR') as TOTAL, CARTIP.CATIDESC as CATIDESC from carflu,cartip where carflu.cafltipo = cartip.caticod and carflu.caflfecha = '$ano-$mes' GROUP BY carflu.cafltipo) as tabela1 order by CAST(TOTAL AS unsigned) DESC";
	//$query = "select format(sum(carflu.caflval),2,'pt_BR') as TOTAL, CARTIP.CATIDESC from carflu,cartip where carflu.cafltipo = cartip.caticod and carflu.caflfecha = '$ano-$mes' GROUP BY carflu.cafltipo";
	$queryfechamento = "select * from carfec where cafefecha = 	'$ano-$mes'";
	
	
	echo'
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
			<tbody> ';			
				
					$result = mysqli_query($conexao,$query);
					while($row = mysqli_fetch_array($result)) {
							echo
							"
							<tr>
							<td>
							".$row['MES']."
							</td>
							<td>
							".$row['TOTAL']."
							</td>
							";
					};	
				
				echo"				
				</tbody>  
		</table>
				";
		
					$resultfechamento = mysqli_query($conexao,$queryfechamento);
					$rowfecha = mysqli_fetch_assoc($resultfechamento);
					$total = $rowfecha['cafesaldo'];		
					echo"
					<h4><strong>Valor Total: $total</strong></h4>
					";
		
		echo'
		</div>
		
		var data = {
    labels: ["January", "February", "March", "April", "May", "June", "July"],
    datasets: [
        {
            label: "My First dataset",
            fillColor: "rgba(220,220,220,0.5)",
            strokeColor: "rgba(220,220,220,0.8)",
            highlightFill: "rgba(220,220,220,0.75)",
            highlightStroke: "rgba(220,220,220,1)",
            data: [65, 59, 80, 81, 56, 55, 40]
        },
        {
            label: "My Second dataset",
            fillColor: "rgba(151,187,205,0.5)",
            strokeColor: "rgba(151,187,205,0.8)",
            highlightFill: "rgba(151,187,205,0.75)",
            highlightStroke: "rgba(151,187,205,1)",
            data: [28, 48, 40, 19, 86, 27, 90]
        }
    ]
};

var ctx = document.getElementById("myChart").getContext("2d");
var myBarChart = new Chart(ctx).Bar(data);
</div>
';
?>