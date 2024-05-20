<?php 
		include "conexao.php";
	
	$desc = $_POST["desc"];	
	
	
	if (($desc == '')){		
		echo"<script language='javascript' type='text/javascript'>alert('Por favor, preencha todos os campos!');window.location.href='cadsubtip.php'</script>";				
	}else
	{
		$result = mysqli_query($conexao,"select tiredesc from tiprec where tiredesc='$desc' limit 1");	
		$total = mysqli_num_rows($result); 
		
		if($total === 0)
		{
			if ($conta == 'R')
			{
				$query = "INSERT INTO tiprec (tiredesc) VALUES ('$desc')"; 
				$insert = mysqli_query($conexao,$query);	
				if($insert)
				{
					echo"<script language='javascript' type='text/javascript'>alert('Salvo com sucesso!');window.location.href='cadtip.php'</script>";							
				}else
				{
					echo"<script language='javascript' type='text/javascript'>alert('Não foi possível salvar');window.location.href='cadtip.php'</script>";								
				}
			}else if ($conta == 'D')
			{
				$query = "INSERT INTO tipdes (tidedesc) VALUES ('$desc')"; 
				$insert = mysqli_query($conexao,$query);	
				if($insert)
				{
					echo"<script language='javascript' type='text/javascript'>alert('Salvo com sucesso!');window.location.href='cadtip.php'</script>";							
				}else
				{
					echo"<script language='javascript' type='text/javascript'>alert('Não foi possível salvar');window.location.href='cadtip.php'</script>";								
				}
			}
		}
		else
		{
			echo"<script language='javascript' type='text/javascript'>alert('Informações já cadastradas!');window.location.href='cadtip.php'</script>";															
		}				
	}			
?>