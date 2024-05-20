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
	
	$desc = $_POST["desc"];	
	$origem = $_POST["origem"];
	$tipo = $_POST["tipos"];
	$valor = $_POST["valor"];		
	$parcelas = $_POST["parc"];
	$datatrans = $_POST["datatrans"];
	$fechamento = $_POST["fechamento"];	
	
	$id = $_POST["id"];
	
	$data = date('Y-m', strtotime($fechamento));
	$mes = date('m', strtotime($data));
	$ano = date('Y', strtotime($data));
	
	$query = "UPDATE CARFLU SET cafldesc='$desc',caflori='$origem',cafltipo='$tipo',caflval='$valor',caflparc='$parcelas',cafldata='$datatrans',caflfecha='$fechamento' WHERE caflcod='$id'";
	$insert = mysqli_query($conexao,$query);	
	
	if(!$insert)
	//if($insert)			
	{		
		echo"<script language='javascript' type='text/javascript'>alert('Não foi possível salvar');window.location.href='editlanccartao.php'</script>";				
	}else
	{	//ALTERA O VALOR CASO A ORIGEM FOR ALTERADA.
		if($origemAnt <> $origem)
		{			
	
			$result = mysqli_query($conexao,"SELECT * FROM carfec WHERE cafefecha='$data' and cafeori = '$origemAnt' limit 1");
			$row = mysqli_fetch_assoc($result);
			$cafecod = $row['cafecod'];
			$saldoAnt = $row['cafesaldo'];
			$saldo = $saldoAnt - $valor;
			$query1 = "UPDATE carfec SET cafesaldo='$saldo' where cafecod='$cafecod'";
			$insert1 = mysqli_query($conexao,$query1);	
			
			if(!$insert1)
			{
				//echo"$query1";				
				echo"<script language='javascript' type='text/javascript'>alert('Não foi possível salvar');window.location.href='editlanccartao.php'</script>";				
			}
			
			$resultflu = mysqli_query($conexao,"select * from fluxo where fludesc = 'Cartão - $origemAnt' and MONTH(datapag)='$mes' and year(datapag)='$ano' and conta='D'");
			$rowflu = mysqli_fetch_assoc($resultflu);		
			if(!empty($rowflu)) {
				$saldoAnt = $row['VALOR'];
				$saldo = $saldoAnt - $valor;
				$queryflu = "UPDATE fluxo SET VALOR='$saldo' where fludesc = 'Cartão - $origemAnt' and MONTH(datapag)='$mes' and year(datapag)='$ano' and conta='D'";
				$insertflu = mysqli_query($conexao,$queryflu);
					
				if(!$insertflu)
				{
					//echo"$queryflu";
					echo"<script language='javascript' type='text/javascript'>alert('Não foi possível salvar');window.location.href='editlanccartao.php'</script>";				
				}
			}
		}

		$querySalAnt = "SELECT * FROM `carflu` WHERE caflori = '$origem' and caflfecha = '$ano-$mes' ORDER BY cafldata DESC";
		$SalAnt = mysqli_query($conexao,$querySalAnt);
		$valortotal = 0;
		while($row = mysqli_fetch_array($SalAnt)) {
			$valor1 = floatval($row['caflval']);							
			$valortotal = ($valor1 + $valortotal);
		}
		
		$saldo = $valortotal;
		$query1 = "UPDATE carfec SET cafesaldo='$saldo' where cafefecha='$data' and cafeori = '$origem'";
		$insert1 = mysqli_query($conexao,$query1);	
		if(!$insert1)
		{
			echo"<script language='javascript' type='text/javascript'>alert('Não foi possível salvar');window.location.href='editlanccartao.php'</script>";				
		}else
		{
		//echo "Atualização - '$query1'";			
		//echo "Fechamento - '$queryfechamento'";	
		//echo "Saldo ANT - '$saldoAnt'";	
	
			$resultdiafecha = mysqli_query($conexao,"select * from carori where caorcod = '$origem'");		
			$rowdiafecha = mysqli_fetch_assoc($resultdiafecha);
			$diafecha = $rowdiafecha['caordiafecha'];		
			$origem2 = $rowdiafecha['caordesc'];		
	
			$resulttipcart = mysqli_query($conexao,"select * from tipdes where tidedesc = 'Cartão'");		
			$rowtipcart = mysqli_fetch_assoc($resulttipcart);
			$tipcart = $rowtipcart['tidecod'];	
			
			$resultflu = mysqli_query($conexao,"select * from fluxo where fludesc = 'Cartão - $origem2' and MONTH(datapag)='$mes' and year(datapag)='$ano' and conta='D'");
			$rowflu = mysqli_fetch_assoc($resultflu);		
			if(!empty($rowflu)) {
				$queryflu = "UPDATE fluxo SET VALOR='$saldo' where fludesc = 'Cartão - $origem2' and MONTH(datapag)='$mes' and year(datapag)='$ano' and conta='D'";
				$insertflu = mysqli_query($conexao,$queryflu);
					
				if(!$insertflu)
				{
					echo"<script language='javascript' type='text/javascript'>alert('Não foi possível salvar');window.location.href='editlanccartao.php'</script>";				
				}
			}
		}
		echo"<script language='javascript' type='text/javascript'>alert('Alterado com sucesso!');window.location.href='cadlanccartao.php'</script>";
	}
?>