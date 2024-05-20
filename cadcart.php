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
		<title>Cadastro de Cartão</title>
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
			<form action="cadcartao.php" method="POST">		
				Descrição*: <input type="text" name="desc" id="desc" style="width:45%">
				</br>
				</br>
				Dia de Fechamento: 
				<?php 
					$dias = date("t");
					$select= '<select name="diafecha" id="diafecha" onchange="SelectHandler(this)">';
					$select.= '<option value="0">Selecione</option>';
					for ($i = 1 ; $i <= $dias; $i++)	
					 {						
						$select.='<option value="'.$i.'">'.$i.'</option>';
					}
					$select.='</select>';
					echo $select;
			
				?>
				</br>
				</br>
				<input type="submit" value="Salvar" id="buttonsalvar">
			</form>
		</div>
	</div>
	</body>	
</html>

