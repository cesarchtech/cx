<?php
	$hostName = 'localhost';
	$userName = 'root';
	$passWord = 'metalica';
	$nomeBanco = 'cxnv';
	
	$conexao = mysqli_connect($hostName,$userName,$passWord,$nomeBanco);
	
	//setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
?>