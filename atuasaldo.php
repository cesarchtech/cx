<?php 
	include "conexao.php";
	$vari = $_GET["id"];

	$saldo = $_POST["saldo"];
	
	
	$query = "UPDATE ORIGEM SET SALDO='$saldo' where COD='$vari'";
	$insert = mysqli_query($conexao,$query);
	
	if($insert)
	{
		echo"<script language='javascript' type='text/javascript'>window.location.href='saldos.php'</script>";
	}else
	{
		//echo"<script language='javascript' type='text/javascript'>alert('Não foi possível salvar');window.location.href='saldos.php'</script>";				
	}
?>