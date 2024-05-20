<?php 
	include "conexao.php";
	
	$dia = '01';
	
	$mes = $_GET["mesde"];

	$ano = $_GET["anode"];
			
	//$dias = date("t");
	$dias = date("t", mktime(0,0,0,$mes,'01',$ano));
	$select= '<select name="diade" id="diade">';
	$select.= '<option value="'.$dia.'">'.$dia.'</option>';
	for ($i = 1 ; $i <= $dias; $i++)	
	 {						
		$select.='<option value="'.$i.'">'.$i.'</option>';
	}
	$select.='</select>';
	echo $select;
	
		?>