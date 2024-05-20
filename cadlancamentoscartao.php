<?php 
	include "conexao.php";
	
	$desc = $_POST["desc"];	
	$origem = $_POST["origem"];
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
		$mes = date('m', strtotime($data));
		$ano = date('Y', strtotime($data));
		
		//ALTERA A QUANTIDADE NO FECHAMENTO
		$result = mysqli_query($conexao,"select cafesaldo from carfec where cafefecha='$data' and cafeori = '$origem'");
		$row = mysqli_fetch_assoc($result);		
		if (empty($row)) {
			$query1 = "INSERT INTO carfec (cafesaldo,cafefecha,cafeori) VALUES ('$valor','$data','$origem')";		
			$insert1 = mysqli_query($conexao,$query1);
			echo "Origem - '$origem'";
			echo "Origem - '$query1'";			
			$saldo = $valor;
		}else
		{
			$resultstatus = mysqli_query($conexao,"SELECT * FROM carfec where cafefecha='$data' and cafestatus='0' and cafeori = '$origem'");
			$fechastatus = mysqli_fetch_assoc($resultstatus);		
			if(empty($fechastatus)) {
				//$queryfechamento = "select sum(cafesaldo) as total from carfec,carori where cafeori = caorcod and cafefecha = '$data'";					
				//$resultfechamento = mysqli_query($conexao,$queryfechamento);
				//$rowfecha = mysqli_fetch_assoc($resultfechamento);
				
				$querySalAnt = "SELECT * FROM `carflu` WHERE caflori = '$origem' and caflfecha = '$ano-$mes' ORDER BY cafldata DESC";
				$SalAnt = mysqli_query($conexao,$querySalAnt);
						$valortotal = 0;
						while($row = mysqli_fetch_array($SalAnt)) {
							$valor1 = floatval($row['caflval']);							
							$valortotal = ($valor1 + $valortotal);
						}
				
				
		
				//$saldoAnt = $rowfecha['total'];
				$saldoAnt = $valortotal;
				//$saldoAnt = $row['cafesaldo'];
				//$saldo = 0;
				$saldo = $saldoAnt + $valor;
				$query1 = "UPDATE carfec SET cafesaldo='$saldo' where cafefecha='$data' and cafeori = '$origem'";
				$insert1 = mysqli_query($conexao,$query1);	
				echo "Atualização - '$query1'";			
				//echo "Fechamento - '$queryfechamento'";	
				echo "Saldo ANT - '$saldoAnt'";	
			}else
			{
				//echo "Fatura já fechada!";	
				echo"<script language='javascript' type='text/javascript'>alert('Fatura já fechada!');window.location.href='cadlanccartao.php'</script>";
			}
		}
		
		
		// ALTERA O VALOR DO FECHAMENTO NO FLUXO
		$resultdiafecha = mysqli_query($conexao,"select * from carori where caorcod = '$origem'");		
		$rowdiafecha = mysqli_fetch_assoc($resultdiafecha);
		$diafecha = $rowdiafecha['caordiafecha'];		
		$origem2 = $rowdiafecha['caordesc'];		
		
		$resulttipcart = mysqli_query($conexao,"select * from tipdes where tidedesc = 'Cartão'");		
		$rowtipcart = mysqli_fetch_assoc($resulttipcart);
		$tipcart = $rowtipcart['tidecod'];		
		
		//BUSCA NO FLUXO O LANÇAMENTO
		$resultflu = mysqli_query($conexao,"select * from fluxo where fludesc = 'Cartão - $origem2' and MONTH(datapag)='$mes' and year(datapag)='$ano' and conta='D'");
		//echo"select * from fluxo where fludesc = 'Cartão - $origem2' and MONTH(datapag)='$mes' and year(datapag)='$ano' and conta='D'";
		$rowflu = mysqli_fetch_assoc($resultflu);		
		if (empty($rowflu)) {
			echo "VAZIOOO FLUXO";
			$queryflu = "INSERT INTO fluxo (FLUDESC,VALOR,DATATRANS,ORIGEM,PAGO,DATAPAG,PARCELA,CONTA,TIPOCOD) VALUES ('Cartão - $origem2','$valor','$ano-$mes-$diafecha','4','N','$ano-$mes-$diafecha-','1','D','$tipcart')";		
			echo"$queryflu";
			$insertflu = mysqli_query($conexao,$queryflu);
		}else
		{
			$queryflu = "UPDATE fluxo SET VALOR='$saldo' where fludesc = 'Cartão - $origem2' and MONTH(datapag)='$mes' and year(datapag)='$ano' and conta='D'";
			$insertflu = mysqli_query($conexao,$queryflu);
			
			if($insertflu)
			{
			echo"SALDO FLUXO = '$saldo'";
			
			
			}
			else{
				echo"Algo deu errado! - $queryflu";	
			}
			
			
		}
		
		//FINALIZA A EDIÇÃO
		if(($insert1) && ($insertflu))
		{				
			$query = "INSERT INTO carflu (cafldesc,cafltipo,caflval,caflparc,cafldata,caflfecha,caflori) VALUES ('$desc','$tipo','$valor','$i','$datatrans','$data',$origem)"; 
			$insert = mysqli_query($conexao,$query);
			
			if($insert)
			{
				echo"<script language='javascript' type='text/javascript'>alert('Salvo com sucesso!');window.location.href='cadlanccartao.php'</script>";
				//echo'Sucesso!';
				//echo"$query";
			}else
			{
				echo"<script language='javascript' type='text/javascript'>alert('Não foi possível salvar');window.location.href='cadlanccartao.php'</script>";				
				//echo'Quase lá!';
			}			
		}else
		{
		//echo"<script language='javascript' type='text/javascript'>alert('Não foi possível salvar');window.location.href='cadlanccartao.php'</script>";				
		echo'Falhou!';
		}
	 }
?>