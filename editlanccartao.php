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
	
	$id = $_GET['id'];
	
	$busca = mysqli_query($conexao, "SELECT * FROM carflu WHERE caflcod = $id");
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
	<?php		
	while($row = mysqli_fetch_array($busca)){
		$origemAnt = $row['caflori'];
		echo'
		
			<form action="salvarlanccartao.php" method="POST">			
				Descrição*: <input type="text" name="desc" id="desc" style="width:45%" autofocus value="'.$row['cafldesc'].'">
				</br>
				</br>
				Origem:';
				$sql=mysqli_query($conexao,'SELECT caorcod,caordesc FROM carori WHERE caorcod = '.$row['caflori'].'');
					if(mysqli_num_rows($sql)){					
						$select= '<select name="origem" id="origem" onchange="SelectHandler(this)">';
						while($rs=mysqli_fetch_array($sql)){
							$select.='<option value="'.$rs['caorcod'].'">'.$rs['caordesc'].'</option>';							
						}
					
						$sql=mysqli_query($conexao,'SELECT caorcod,caordesc FROM carori ORDER BY caordesc ASC');
						if(mysqli_num_rows($sql)){
							while($rs=mysqli_fetch_array($sql)){
								$select.='<option value="'.$rs['caorcod'].'">'.$rs['caordesc'].'</option>';
							}
						}						
						$select.='</select>';					
						echo $select;				
					}
	
				echo ' Tipo: ';

					$sql=mysqli_query($conexao,'SELECT tidecod,tidedesc FROM tipdes WHERE tidecod = '.$row['cafltipo'].'');
					if(mysqli_num_rows($sql)){
						$select= '<select name="tipos" id="tipos" onchange="SelectHandler(this)">';
						while($rs=mysqli_fetch_array($sql)){
							$select.='<option value="'.$rs['tidecod'].'">'.$rs['tidedesc'].'</option>';
						}
						$sql=mysqli_query($conexao,'SELECT tidecod,tidedesc FROM tipdes ORDER BY tidedesc ASC');
						if(mysqli_num_rows($sql)){
							while($rs=mysqli_fetch_array($sql)){
								$select.='<option value="'.$rs['tidecod'].'">'.$rs['tidedesc'].'</option>';
							}
						}					
					}
					$select.='</select>';
					echo $select;
				?>
				<?php
				echo'
				</br>
				</br>
				
				
				Valor*: <input type="number" name="valor" id="valor" style="width:45%" step="0.01" value="'.$row['caflval'].'">
				
				Parcela N°: <input type="number" name="parc" id="parc" style="width:10%" step="1" min="1" value="'.$row['caflparc'].'">
				</br>
				</br>
				Data da Transação: <input class="dtpt" type="date" name="datatrans" value="'.$row['cafldata'].'" />
				</br>
				</br>
				Fechamento: <input class="dtpt" type="month" name="fechamento" value="'.$row['caflfecha'].'"/>
				</br>
				</br>				
				<input type="hidden" value="'.$id.'" name="id" />
				<input type="hidden" value="'.$origemAnt.'" name="origemAnt" />	
				<input type="submit" value="Salvar" id="buttonsalvar">			
			</form>
			';
		}
		?>
		</div>
	</div>
	</body>	
</html>

