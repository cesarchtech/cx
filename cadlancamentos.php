<?php 	
	include "conexao.php";
	
	
	$conta = $_POST["conta"];
	$desc = $_POST["desc"];	
	$origem = $_POST["origem"];
	$tipo = $_POST["tipo"];
	$valor = $_POST["valor"];		
	$datatrans = $_POST["datatrans"];
	$pago = $_POST["pago"];
	$datapag = $_POST["datapag"];
	$parcelas = $_POST["parc"];
	
	
	if (($conta == '0') || ($desc == '') || ($origem == '') || ($tipo == '0') || ($valor == '')){		
		//echo"('$conta','$desc','$origem','$tipo','$valor')";
		echo"<script language='javascript' type='text/javascript'>alert('Por favor, preencha todos os campos!');window.location.href='cadlanc.php'</script>";				
	}else
	{	
		if ($conta == 'D')	
		{
			if ($pago == 'S')
			{		
				//ALTERA A QUANTIDADE NO SALDO
				$result = mysqli_query($conexao,"select saldo from origem where cod='$origem' limit 1");
				$row = mysqli_fetch_assoc($result);
				$saldoAnt = $row['saldo'];
				//$saldo = 0;
				$saldo = $saldoAnt - $valor;
				$query1 = "UPDATE origem SET saldo='$saldo' where cod='$origem'";
				$insert1 = mysqli_query($conexao,$query1);			
			
			
				if($insert1)
				{				
					//if ($parcelas > 1)
					//{
					 for ($i = 1 ; $i <= $parcelas; $i++)	
					 {
						 $j = ($i-1);
						$data = date('Y-m-d', strtotime("+$j months", strtotime($datapag)));
						$query = "INSERT INTO fluxo (conta,fludesc,origem,valor,parcela,datatrans,pago,datapag,tipocod) VALUES ('$conta','$desc','$origem','$valor','$i','$datatrans','$pago','$data','$tipo')"; 

						//$query = "INSERT INTO fluxo (conta,fludesc,origem,valor,datatrans,pago,datapag) VALUES ($conta,'$desc','$origem','$valor','$datatrans','$pago','$datapag')";
						$insert = mysqli_query($conexao,$query);
						if($insert)
						{
							echo"<script language='javascript' type='text/javascript'>alert('Salvo com sucesso!');window.location.href='cadlanc.php'</script>";							
						}else
						{
							echo"<script language='javascript' type='text/javascript'>alert('Não foi possível salvar');window.location.href='cadlanc.php'</script>";				
							//echo "$query";
						}			
					 }
					//}
				}else
				{
					//echo"$saldo";
				//	echo"$saldoAnt";
					//echo"$query1";
					echo"<script language='javascript' type='text/javascript'>alert('Não foi possível salvar');window.location.href='cadlanc.php'</script>";				
				}
			}else
			{
				//if ($parcelas > 1)
				//{
					 for ($i = 1 ; $i <= $parcelas; $i++)	
					 {
						 $j = ($i-1);
						$data = date('Y-m-d', strtotime("+$j months", strtotime($datapag)));
						$query = "INSERT INTO fluxo (conta,fludesc,origem,valor,parcela,datatrans,pago,datapag,tipocod) VALUES ('$conta','$desc','$origem','$valor','$i','$datatrans','$pago','$data','$tipo')"; 

						//$query = "INSERT INTO fluxo (conta,fludesc,origem,valor,datatrans,pago,datapag) VALUES ($conta,'$desc','$origem','$valor','$datatrans','$pago','$datapag')";
						$insert = mysqli_query($conexao,$query);
						if($insert)
						{
							echo"<script language='javascript' type='text/javascript'>alert('Salvo com sucesso!');window.location.href='cadlanc.php'</script>";
						}else
						{
							echo"<script language='javascript' type='text/javascript'>alert('Não foi possível salvar');window.location.href='cadlanc.php'</script>";				
						}			
					 }
				//}
			}
		}else
		{
			if ($pago == 'S')
			{		
				//ALTERA A QUANTIDADE NO SALDO
				$result = mysqli_query($conexao,"select saldo from origem where cod='$origem' limit 1");
				$row = mysqli_fetch_assoc($result);
				$saldoAnt = $row['saldo'];
				//$saldo = 0;
				$saldo = $saldoAnt + $valor;
				$query1 = "UPDATE origem SET saldo='$saldo' where cod='$origem'";
				$insert1 = mysqli_query($conexao,$query1);			
			
			
				if($insert1)
				{				
					//if ($parcelas > 1)
					//{
					 for ($i = 1 ; $i <= $parcelas; $i++)	
					 {
						 $j = ($i-1);
						$data = date('Y-m-d', strtotime("+$j months", strtotime($datapag)));
						$query = "INSERT INTO fluxo (conta,fludesc,origem,valor,parcela,datatrans,pago,datapag,tipocod) VALUES ('$conta','$desc','$origem','$valor','$i','$datatrans','$pago','$data','$tipo')"; 

						//$query = "INSERT INTO fluxo (conta,fludesc,origem,valor,datatrans,pago,datapag) VALUES ($conta,'$desc','$origem','$valor','$datatrans','$pago','$datapag')";
						$insert = mysqli_query($conexao,$query);
						if($insert)
						{
							echo"<script language='javascript' type='text/javascript'>alert('Salvo com sucesso!');window.location.href='cadlanc.php'</script>";
						}else
						{
							echo"<script language='javascript' type='text/javascript'>alert('Não foi possível salvar');window.location.href='cadlanc.php'</script>";				
						}			
					 }
					//}
				}else
				{
					echo"<script language='javascript' type='text/javascript'>alert('Não foi possível salvar');window.location.href='cadlanc.php'</script>";				
				}
			}else
			{
				//if ($parcelas > 1)
				//{
					 for ($i = 1 ; $i <= $parcelas; $i++)	
					 {
						 $j = ($i-1);
						$data = date('Y-m-d', strtotime("+$j months", strtotime($datapag)));
						$query = "INSERT INTO fluxo (conta,fludesc,origem,valor,parcela,datatrans,pago,datapag,tipocod) VALUES ('$conta','$desc','$origem','$valor','$i','$datatrans','$pago','$data','$tipo')"; 

						//$query = "INSERT INTO fluxo (conta,fludesc,origem,valor,datatrans,pago,datapag) VALUES ($conta,'$desc','$origem','$valor','$datatrans','$pago','$datapag')";
						$insert = mysqli_query($conexao,$query);
						if($insert)
						{
							echo"<script language='javascript' type='text/javascript'>alert('Salvo com sucesso!');window.location.href='cadlanc.php'</script>";
						}else
						{
							echo"$query";
							//echo"<script language='javascript' type='text/javascript'>alert('Não foi possível salvar');window.location.href='cadlanc.php'</script>";				
						}			
					 }
				//}
			}
		}
	}
?>