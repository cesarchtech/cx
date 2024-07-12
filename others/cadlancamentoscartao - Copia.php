<?php 
	$hostName = 'localhost';
	$userName = 'root';
	$passWord = 'metalica';
	$nomeBanco = 'caixa';
	
	$conexao = mysqli_connect($hostName,$userName,$passWord,$nomeBanco);
	
	$desc = $_POST["desc"];	
	$tipo = $_POST["tipos"];
	$valor = $_POST["valor"];		
	$parcelas = $_POST["parc"];
	$datatrans = $_POST["datatrans"];
	$fechamento = $_POST["fechamento"];
	
	 for ($i = 1 ; $i <= $parcelas; $i++)	
	 {	
		//CALCULO DAS PARCELAS
		$j = ($i-1);
		$data = date('Y-m', strtotime("+$j months", strtotime($fechamento)));
		
		//ALTERA A QUANTIDADE NO SALDO
		$result = mysqli_query($conexao,"select cafesaldo from carfec where cafefecha='$data'");
		$row = mysqli_fetch_assoc($result);
		
		if (empty($row)) {
			$query1 = "INSERT INTO carfec (cafesaldo,cafefecha) VALUES ('$valor','$data')";		
			$insert1 = mysqli_query($conexao,$query1);
		}else
		{
			$saldoAnt = $row['cafesaldo'];
			//$saldo = 0;
			$saldo = $saldoAnt + $valor;
			$query1 = "UPDATE carfec SET cafesaldo='$saldo' where cafefecha='$data'";
			$insert1 = mysqli_query($conexao,$query1);
		}
		
		if($insert1)
		{				
			$query = "INSERT INTO carflu (cafldesc,cafltipo,caflval,caflparc,cafldata,caflfecha) VALUES ('$desc','$tipo','$valor','$i','$datatrans','$data')"; 
			$insert = mysqli_query($conexao,$query);
			
			if($insert)
			{
				echo"<script language='javascript' type='text/javascript'>alert('Salvo com sucesso!');window.location.href='cadlanccartao.php'</script>";
				//echo'Sucesso!';
			}else
			{
				echo"<script language='javascript' type='text/javascript'>alert('Não foi possível salvar');window.location.href='cadlanccartao.php'</script>";				
				//echo'Quase lá!';
			}			
		}else
		{
		echo"<script language='javascript' type='text/javascript'>alert('Não foi possível salvar');window.location.href='cadlanccartao.php'</script>";				
		//echo'Falhou!';
		}
	 }
?>