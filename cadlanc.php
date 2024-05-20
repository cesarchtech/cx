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
	$query = "SELECT * FROM caixa";
	
?>

<html>
	<head>
		<title>Cadastro de Informações</title>
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
	$(document).ready(function(){
		$("select[name='conta']").change(function(){			
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
			<form action="cadlancamentos.php" method="POST">
				Conta: <select name="conta" id="conta">
						<option value="0">Selecione </option>
						<option value="R">Receitas </option>
						<option value="D">Despesas </option>
						</select>
						
				</br>
				</br>			
				Descrição*: <input type="text" name="desc" id="desc" style="width:45%">
				</br>
				</br>
				Origem: 
				<?php
					$sql=mysqli_query($conexao,"SELECT cod,oridesc FROM origem ORDER BY oridesc ASC");
					if(mysqli_num_rows($sql)){
						$select= '<select name="origem" id="origem" onchange="SelectHandler(this)">';
						$select.= '<option value="0">Selecione</option>';
						while($rs=mysqli_fetch_array($sql)){
							$select.='<option value="'.$rs['cod'].'">'.$rs['oridesc'].'</option>';
						}
					}
					$select.='</select>';
					echo $select;
			
				?>
				Tipo*: <select name="tipo" id="tipo">
						<option value="0">Selecione </option>
						</select>
				</br>
				</br>
				
				
				Valor*: <input type="number" name="valor" id="valor" style="width:45%" step="0.01">
				
				Parcelas: <input type="number" name="parc" id="parc" style="width:10%" step="1" min="1" value="1">
				</br>
				</br>
				Data da Transação: <input class="dtpt" type="date" name="datatrans" value="<?php  date_default_timezone_set('Brazil/East'); echo date('Y-m-d'); ?>" />
				</br>
				</br>
				Pago: <select name="pago" id="pago">
						<option value="N">Não </option>
						<option value="S">Sim </option>
						</select>
						
				</br>
				</br>
				Data do Pagamento: <input class="dtpt" type="date" name="datapag" value="<?php  date_default_timezone_set('Brazil/East'); echo date('Y-m-d'); ?>" />
				</br>
				</br>
				<input type="submit" value="Salvar" id="buttonsalvar">
			</form>
		</div>
	</div>
	</body>	
</html>

