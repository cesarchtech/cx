<?php
/*
	session_start();
	if (empty($_SESSION['user'])) 
	{
		return header('location: login.html');
	}*/
	
?>

<?php
	$hostName = 'localhost';
	$userName = 'root';
	$passWord = 'metalica';
	$nomeBanco = 'caixa';
	
	$conexao = mysqli_connect($hostName,$userName,$passWord,$nomeBanco);
	
	$query = "SELECT * FROM caixa";
?>

<html>
	<head>
		<title>Cadastro de Informações - Cartão</title>
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
		
	
		
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js" ></script>
	<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/jquery-ui.min.js"></script>‌​
	<script type="text/javascript">
//		$('select#categoria').on("change", function(){
	$(document).ready(function(){
		$("select[name='origem']").change(function(){			
			$.ajax({
				url: 'filtracat.php?id=' + $(this).val(),
				type: 'GET',
				dataType: 'html',
				success: function (data) {
					$('select#tipo').html(data);
				}
			});
			});
	});
	</script>	
		
	<div class="conteudo">
		<div id="formcadjogo">
			<form action="cadlancamentoscartao.php" method="POST">			
				Descrição*: <input type="text" name="desc" id="desc" style="width:45%" autofocus>
				</br>
				</br>
				Tipo: 
				<?php
					$sql=mysqli_query($conexao,"SELECT tidecod,tidedesc FROM tipdes ORDER BY tidedesc ASC");
					if(mysqli_num_rows($sql)){
						$select= '<select name="tipos" id="tipos" onchange="SelectHandler(this)">';
						$select.= '<option value="0">Selecione</option>';
						while($rs=mysqli_fetch_array($sql)){
							$select.='<option value="'.$rs['tidecod'].'">'.$rs['tidedesc'].'</option>';
						}
					}
					$select.='</select>';
					echo $select;
				?>
				</br>
				</br>
				
				
				Valor*: <input type="number" name="valor" id="valor" style="width:45%" step="0.01">
				
				Parcelas: <input type="number" name="parc" id="parc" style="width:10%" step="1" min="1" value="1">
				</br>
				</br>
				Data da Transação: <input class="dtpt" type="date" name="datatrans" value="<?php  date_default_timezone_set('Brazil/East'); echo date('Y-m-d'); ?>" />
				</br>
				</br>
				Fechamento: <input class="dtpt" type="month" name="fechamento" value="<?php date_default_timezone_set('Brazil/East'); if (date('d')> 13){echo date('Y-m', strtotime('+1 month')); } else{ echo date('Y-m'); } ?>"/>
				</br>
				</br>
				<input type="submit" value="Salvar" id="buttonsalvar">
			</form>
		</div>
	</div>
	</body>	
</html>

