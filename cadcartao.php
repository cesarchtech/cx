<?php 
	include "conexao.php";
	
	$desc = $_POST["desc"];	
	$diafecha = $_POST["diafecha"];
	
	
	if (($desc == '') || ($diafecha == '')){		
		echo"<script language='javascript' type='text/javascript'>alert('Por favor, preencha todos os campos!');window.location.href='cadcart.php'</script>";				
	}else
	{
		$result = mysqli_query($conexao,"select caordesc from carori where caordesc='$desc' limit 1");
		$total = mysqli_num_rows($result); 
		if($total === 0)
		{
			$query = "INSERT INTO carori (caordesc,caordiafecha) VALUES ('$desc','$diafecha')"; 
			$insert = mysqli_query($conexao,$query);	
			if($insert)
			{
				echo"<script language='javascript' type='text/javascript'>alert('Salvo com sucesso!');window.location.href='cadcart.php'</script>";							
			}else
			{
				//echo"<script language='javascript' type='text/javascript'>alert('Não foi possível salvar');window.location.href='cadcart.php'</script>";								
				echo"$query";
			}
					
		}
		else
		{
			echo"<script language='javascript' type='text/javascript'>alert('Informações já cadastradas!');window.location.href='cadcart.php'</script>";			
		}				
	}			
?>