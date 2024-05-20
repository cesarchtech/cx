<?php 
		include "conexao.php";
	
	$desc = $_POST["desc"];	
	
	
	if ($desc == ''){		
		echo"<script language='javascript' type='text/javascript'>alert('Por favor, preencha todos os campos!');window.location.href='cadori.php'</script>";				
	}else
	{
		$result = mysqli_query($conexao,"select ORIDESC from origem where ORIDESC='$desc' limit 1");
		$total = mysqli_num_rows($result); 
		if($total === 0)
		{
			$query = "INSERT INTO origem (ORIDESC,SALDO) VALUES ('$desc','0')"; 
			$insert = mysqli_query($conexao,$query);	
			if($insert)
			{
				echo"<script language='javascript' type='text/javascript'>alert('Salvo com sucesso!');window.location.href='cadori.php'</script>";							
			}else
			{
				echo"<script language='javascript' type='text/javascript'>alert('Não foi possível salvar');window.location.href='cadori.php'</script>";								
			}
		}
		else
		{
			echo"<script language='javascript' type='text/javascript'>alert('Informações já cadastradas!');window.location.href='cadori.php'</script>";				
		}				
	}			
?>