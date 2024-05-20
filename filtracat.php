<?php
	include "conexao.php";
	
	//$query = "SELECT * FROM cartao";
	$id = $_GET["id"];
	
	if ($id == 'D')
	{
		echo "Despesas";
		
		$sql=mysqli_query($conexao,"SELECT tidecod,tidedesc FROM tipdes ORDER BY tidedesc ASC");
		if(mysqli_num_rows($sql)){
			$select= '<select name="tipo" id="tipo" onchange="SelectHandler(this)">';
			$select.= '<option value="0">Todos </option>';
			while($rs=mysqli_fetch_array($sql)){
				$select.='<option value="'.$rs['tidecod'].'">'.$rs['tidedesc'].'</option>';
			}
	}
	$select.='</select>';
	echo $select;	
	}else if ($id == 'R')
	{
		echo "Receitas";
		$sql=mysqli_query($conexao,"SELECT tirecod,tiredesc FROM tiprec ORDER BY tiredesc ASC");
		if(mysqli_num_rows($sql)){
			$select= '<select name="tipo" id="tipo" onchange="SelectHandler(this)">';
			$select.= '<option value="0">Todos </option>';
			while($rs=mysqli_fetch_array($sql)){
				$select.='<option value="'.$rs['tirecod'].'">'.$rs['tiredesc'].'</option>';
			}
	}
	$select.='</select>';
	echo $select;			
	}else
	{
		echo "NDA";
	}	
?>