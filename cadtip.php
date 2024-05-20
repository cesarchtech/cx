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
?>

<html>
	<head>
		<title>Cadastro de Tipos</title>
		<link href="https://fonts.googleapis.com/css?family=Lobster|Pangolin|Sansita" rel="stylesheet">
		<meta charset="utf-8"/>
		<link href="css/style.css" rel="stylesheet" type="text/css"/>		
		<meta name="viewport" content="width=device-width, initial-scale=1">
	</head>
	<body>		
	
	<!-- MENU DROPDOWN -->
	<?php include "menu.html"; ?>
	<!-- MENU DROPDOWN -->
		
		
	<div class="conteudo">
		<div id="formcadjogo">
			<form action="cadtipos.php" method="POST">		
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
				<input type="submit" value="Salvar" id="buttonsalvar">
			</form>
		</div>
	</div>
	</body>	
</html>

