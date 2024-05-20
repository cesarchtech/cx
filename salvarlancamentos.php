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
	
	
	$origemAnt = $_POST["origemAnt"];	
	$contaA = $_POST["contaA"];	
	$conta = $_POST["conta"];	
	$desc = $_POST["desc"];	
	$origem = $_POST["origem"];
	$tipo = $_POST["tipo"];
	$valor = $_POST["valor"];		
	$datatrans = $_POST["datatrans"];
	$pago = $_POST["pago"];
	$pagou = $_POST["pagou"];
	$datapag = $_POST["datapag"];
	
	$id = $_POST["id"];
	
	//echo"
	//$contaA - $conta - $pago 
	//";
	
	//QUANDO SÓ SE MUDA A ORIGEM DE PAGAMENTO
	
	if ($contaA == 'Despesas')
	{
		if ($pagou == 'Sim' && $pago == 'S')
		{
			if($origemAnt <> $origem)
			{
				$result = mysqli_query($conexao,"select saldo from origem where cod='$origemAnt' limit 1");
				$row = mysqli_fetch_assoc($result);
				$saldoAnt = $row['saldo'];
				$saldo = $saldoAnt + $valor;
				$query1 = "UPDATE origem SET saldo='$saldo' where cod='$origemAnt'";
				$insert1 = mysqli_query($conexao,$query1);	

				$result = mysqli_query($conexao,"select saldo from origem where cod='$origem' limit 1");
				$row = mysqli_fetch_assoc($result);
				$saldoAnt = $row['saldo'];
				$saldo = $saldoAnt - $valor;
				$query1 = "UPDATE origem SET saldo='$saldo' where cod='$origem'";
				$insert1 = mysqli_query($conexao,$query1);
			}
		}		
	}else if ($contaA == 'Receitas')
	{
		if ($pagou == 'Sim' && $pago == 'S')
		{
			if($origemAnt <> $origem)
			{
				$result = mysqli_query($conexao,"select saldo from origem where cod='$origemAnt' limit 1");
				$row = mysqli_fetch_assoc($result);
				$saldoAnt = $row['saldo'];
				$saldo = $saldoAnt - $valor;
				$query1 = "UPDATE origem SET saldo='$saldo' where cod='$origemAnt'";
				$insert1 = mysqli_query($conexao,$query1);	

				$result = mysqli_query($conexao,"select saldo from origem where cod='$origem' limit 1");
				$row = mysqli_fetch_assoc($result);
				$saldoAnt = $row['saldo'];
				$saldo = $saldoAnt + $valor;
				$query1 = "UPDATE origem SET saldo='$saldo' where cod='$origem'";
				$insert1 = mysqli_query($conexao,$query1);
			}
		}		
	}
	
	
	if ($contaA == 'Despesas')
	{
		if ($pagou == 'Sim' && $pago == 'N')
		{				  
			//ALTERA A QUANTIDADE NO SALDO
			$result = mysqli_query($conexao,"select saldo from origem where cod='$origemAnt' limit 1");
			$row = mysqli_fetch_assoc($result);
			$saldoAnt = $row['saldo'];
			//$saldo = 0;
			$saldo = $saldoAnt + $valor;
			$query1 = "UPDATE origem SET saldo='$saldo' where cod='$origemAnt'";
			$insert1 = mysqli_query($conexao,$query1);			
	
	
			if($insert1)
			{
				$query = "UPDATE fluxo SET conta='$conta',fludesc='$desc',origem='$origem',valor='$valor',datatrans='$datatrans',pago='$pago',datapag='$datapag',tipocod='$tipo' where FLUCOD='$id'";
				$insert = mysqli_query($conexao,$query);
				if($insert)
				{
					echo"<script language='javascript' type='text/javascript'>alert('Salvo com sucesso!');window.location.href='index.php'</script>";
				}else
				{
					echo"<script language='javascript' type='text/javascript'>alert('Não foi possível salvar');window.location.href='editlanc.php'</script>";				
				}			
			}else
			{
				echo"<script language='javascript' type='text/javascript'>alert('Não foi possível salvar');window.location.href='cadlanc.php'</script>";				
			}
		}else if($pagou == 'Não' && $pago == 'S')
		{
			echo"$pagou - $pago";
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
				$query = "UPDATE fluxo SET conta='$conta',fludesc='$desc',origem='$origem',valor='$valor',datatrans='$datatrans',pago='$pago',datapag='$datapag',tipocod='$tipo' where FLUCOD='$id'";
				$insert = mysqli_query($conexao,$query);
		
		
				if($insert)
				{
					echo"<script language='javascript' type='text/javascript'>alert('Salvo com sucesso!');window.location.href='index.php'</script>";
				}else
				{
					echo"<script language='javascript' type='text/javascript'>alert('Não foi possível salvar');window.location.href='editlanc.php'</script>";				
				}
			}
		}else
		{
			$query = "UPDATE fluxo SET conta='$conta',fludesc='$desc',origem='$origem',valor='$valor',datatrans='$datatrans',pago='$pago',datapag='$datapag',tipocod='$tipo' where FLUCOD='$id'";
				$insert = mysqli_query($conexao,$query);
		
		
				if($insert)
				{
					echo"<script language='javascript' type='text/javascript'>alert('Salvo com sucesso!');window.location.href='index.php'</script>";
				}else
				{
					echo"<script language='javascript' type='text/javascript'>alert('Não foi possível salvar');window.location.href='editlanc.php'</script>";				
				}
		}
	}else
	{
		if ($pagou == 'Sim' && $pago == 'N')
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
				$query = "UPDATE fluxo SET conta='$conta',fludesc='$desc',origem='$origem',valor='$valor',datatrans='$datatrans',pago='$pago',datapag='$datapag',tipocod='$tipo' where FLUCOD='$id'";
				$insert = mysqli_query($conexao,$query);
				if($insert)
				{
					echo"<script language='javascript' type='text/javascript'>alert('Salvo com sucesso!');window.location.href='index.php'</script>";
				}else
				{
					echo"<script language='javascript' type='text/javascript'>alert('Não foi possível salvar');window.location.href='editlanc.php'</script>";				
				}			
			}else
			{
				echo"<script language='javascript' type='text/javascript'>alert('Não foi possível salvar');window.location.href='cadlanc.php'</script>";				
			}
		}else if ($pagou == 'Não' && $pago == 'S')
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
				$query = "UPDATE fluxo SET conta='$conta',fludesc='$desc',origem='$origem',valor='$valor',datatrans='$datatrans',pago='$pago',datapag='$datapag',tipocod='$tipo' where FLUCOD='$id'";
				$insert = mysqli_query($conexao,$query);
		
		
				if($insert)
				{
					echo"<script language='javascript' type='text/javascript'>alert('Salvo com sucesso!');window.location.href='index.php'</script>";
				}else
				{
					echo"<script language='javascript' type='text/javascript'>alert('Não foi possível salvar');window.location.href='editlanc.php'</script>";				
				}
			}
		}else
		{
			$query = "UPDATE fluxo SET conta='$conta',fludesc='$desc',origem='$origem',valor='$valor',datatrans='$datatrans',pago='$pago',datapag='$datapag',tipocod='$tipo' where FLUCOD='$id'";
				$insert = mysqli_query($conexao,$query);
		
		
				if($insert)
				{
					echo"<script language='javascript' type='text/javascript'>alert('Salvo com sucesso!');window.location.href='index.php'</script>";
				}else
				{
					echo"<script language='javascript' type='text/javascript'>alert('Não foi possível salvar');window.location.href='editlanc.php'</script>";				
				}
		}
	}
?>