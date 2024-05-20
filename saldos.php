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
	
	$query = "SELECT * FROM origem";	
	$querymontante = "SELECT ROUND(SUM(saldo),2) as montante from origem where ORIDESC <>'Cartão'";
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
	
		<div class="conteudo">	
		<iframe name="tela" style="display:none;"></iframe>		
		<table border="1" style="width:100%; text-align:center;">	
		<tr>		
		<th>Descrição</th>
		<th>Saldo</th>
		</tr>		
		<?php
			$result = mysqli_query($conexao,$query);
			while($row = mysqli_fetch_array($result)) {
					echo
					"
					<tr>
					<td>
					".$row['ORIDESC']."
					</td>
					<td>
					<form target='tela' action='atuasaldo.php?id=".$row['COD']."' method='post' id='".$row['COD']."' name='".$row['COD']."'>
						<input type='hidden' name='cod' id='cod' value=".$row['COD'].">
						<input type='text' name='saldo' id='saldo' value='".$row['SALDO']."' onblur='javascript:document.getElementById(\"".$row['COD']."\").submit()'>
					</form>					
					</td>					
					</tr>
					";
			};			
		?>			
		
		</table>				
		<h3>
		<?php
			$result = mysqli_query($conexao,$querymontante);
			while($row = mysqli_fetch_array($result)) {
				setlocale(LC_MONETARY, 'pt_BR');
				$montante = $row['montante'];
				echo"Saldo Atual: ".$row['montante']."";
			};
		?>		
		</h3>
		</div>
		</div>
		
		
	</body>
</html>