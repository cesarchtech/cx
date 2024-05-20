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
	
	$busca = mysqli_query($conexao, "SELECT * FROM fluxo WHERE FLUCOD = $id");
	
?>

<html>
	<head>
		<title>Cadastro de Informações</title>
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
		
	<div class="conteudo">
		<div id="formcadjogo">
		</form>
		<form action='recibo.php' method='post' id='imprecibo' name='imprecibo' target="_blank">
		<input type='hidden' name='id' value='<?php echo $id;?>' />
		<!--<input type="submit" value="Imprimir Recibo" id="butimpsaldo"> -->
		<br>
		</form>
		<?php
			while($row = mysqli_fetch_array($busca)){
				
				$pagou = $row['PAGO'];
				
				if ($pagou == 'S')
				{
					$pagou = 'Sim';
				}else
				{
					$pagou = 'Não';
				}
				
				$contaA = $row['CONTA'];
				
				if ($contaA == 'R')
				{
					$contaA = 'Receitas';
				}else
				{
					$contaA = 'Despesas';
				}
				
				$origemAnt = $row['ORIGEM'];
				echo
				'
				<form action="salvarlancamentos.php" method="POST">
				Conta: <select name="conta" id="conta" >
						<option value="'.$row['CONTA'].'">'.$contaA.' </option>
						<option value="R">Receitas </option>
						<option value="D">Despesas </option>
						</select>
						
				</br>
				</br>
				Descrição*: <input type="text" name="desc" id="desc" style="width:45%" value="'.$row['FLUDESC'].'">
				</br>
				</br>
				Origem:
				';
				?>
				<?php
					$sql1=mysqli_query($conexao,'SELECT cod,oridesc FROM origem WHERE COD = '.$row['ORIGEM'].'');
					if(mysqli_num_rows($sql1)){
						$select= '<select name="origem" id="origem" onchange="SelectHandler(this)">';						
						while($rs1=mysqli_fetch_array($sql1)){
							$select.='<option value="'.$rs1['cod'].'">'.$rs1 ['oridesc'].'</option>';
						}
					
					
					$sql=mysqli_query($conexao,"SELECT cod,oridesc FROM origem ORDER BY oridesc ASC");
					if(mysqli_num_rows($sql)){
						while($rs=mysqli_fetch_array($sql)){
							$select.='<option value="'.$rs['cod'].'">'.$rs['oridesc'].'</option>';
						}
					}
					}
					$select.="</select>";
					echo $select;
					
				echo'
				
				Tipo:
				';
				?>
				<?php
				 if ($row['CONTA'] == 'D'){
					$select= '<select name="tipo" id="tipo" onchange="SelectHandler(this)">';						
										
					$sql2=mysqli_query($conexao,'SELECT tidecod,tidedesc FROM tipdes WHERE tidecod = '.$row['TIPOCOD'].'');					
					if(mysqli_num_rows($sql2)){
						while($rs2=mysqli_fetch_array($sql2)){
							$select.='<option value="'.$rs2['tidecod'].'">'.$rs2 ['tidedesc'].'</option>';
						}
					}					
					else // se vazio o tipo
					{
						$select.= '<option value="0">Selecione</option>';
					}
					
					$sql=mysqli_query($conexao,"SELECT tidecod,tidedesc FROM tipdes ORDER BY tidedesc ASC");
					if(mysqli_num_rows($sql)){
						while($rs=mysqli_fetch_array($sql)){
							$select.='<option value="'.$rs['tidecod'].'">'.$rs['tidedesc'].'</option>';
						}
					}
					$select.="</select>";
					echo $select;
				 }else
				 {
					 $select= '<select name="tipo" id="tipo" onchange="SelectHandler(this)">';						
					 
					 $sql2=mysqli_query($conexao,'SELECT tirecod,tiredesc FROM tiprec WHERE tirecod = '.$row['TIPOCOD'].'');
					if(mysqli_num_rows($sql2)){						
						while($rs2=mysqli_fetch_array($sql2)){
							$select.='<option value="'.$rs2['tirecod'].'">'.$rs2 ['tiredesc'].'</option>';
						}
					}					
					else // se vazio o tipo
					{
						$select.= '<option value="0">Selecione</option>';
					}
					
					 $sql=mysqli_query($conexao,"SELECT tirecod,tiredesc FROM tiprec ORDER BY tiredesc ASC");
					if(mysqli_num_rows($sql)){
						while($rs=mysqli_fetch_array($sql)){
							$select.='<option value="'.$rs['tirecod'].'">'.$rs['tiredesc'].'</option>';
						}
					}
				
					$select.="</select>";
					echo $select;
				 }
				 
				echo'
				
				</br>
				</br>
				
				
				Valor*: <input type="number" name="valor" id="valor" style="width:45%" step="0.01" value="'.$row['VALOR'].'">
				</br>
				</br>
				Data da Transação: <input class="dtpt" type="date" name="datatrans" value="'.$row['DATATRANS'].'"/>
				</br>
				</br>
				Pago: <select name="pago" id="pago" >
						<option value="'.$row['PAGO'].'">'.$pagou.' </option>
						<option value="N">Não </option>
						<option value="S">Sim </option>
						</select>
						
				</br>
				</br>
				Data do Pagamento: <input class="dtpt" type="date" name="datapag" value="'.$row['DATAPAG'].'"/>
				</br>
				</br>
				<input type="hidden" value="'.$origemAnt.'" name="origemAnt" />						
				<input type="hidden" value="'.$contaA.'" name="contaA" />						
				<input type="hidden" value="'.$pagou.'" name="pagou" />						
				<input type="hidden" value="'.$id.'" name="id" />						
				<input type="submit" value="Salvar" id="buttonsalvar">
				';
			}
			?>
			</form>
		</div>
	</div>
	</body>	
</html>

