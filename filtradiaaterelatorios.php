<?php 
	include "conexao.php";	
	
	$mes = $_GET["mesate"];

	$ano = $_GET["anoate"];
			
	//$dias = date("t");
	$dias = date("t", mktime(0,0,0,$mes,'01',$ano));
	$dia = $dias;
	$select= '<select name="diaate" id="diaate">';
	$select.= '<option value="'.$dia.'">'.$dia.'</option>';
	for ($i = 1 ; $i <= $dias; $i++)	
	 {						
		$select.='<option value="'.$i.'">'.$i.'</option>';
	}
	$select.='</select>';
	echo $select;
	
		?>