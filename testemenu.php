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
	
	$query = "SELECT * FROM caixa";
	
	
?>
<html>
	<head>
		<title>Cadastro de Informações - Cartão</title>
		<link href="https://fonts.googleapis.com/css?family=Lobster|Pangolin|Sansita" rel="stylesheet">
		<meta charset="utf-8"/>
		<meta name="description" content="Página de notícias."/>
		<link href="estilo.css" rel="stylesheet" type="text/css"/>		
		<meta name="viewport" content="width=device-width, initial-scale=1">
	</head>
	<body>	
<div class="topnav" id="myTopnav">
  <a href="javascript:void(0);" class="icon" onclick="myFunction()">&#9776;</a>
  <a href="#home">Home</a>
  <a href="#news">News</a>
  <a href="#contact">Contact</a>
  <div class="dropdown">
    <button class="dropbtn">Dropdown 
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
      <a href="#">Link 1</a>
      <a href="#">Link 2</a>
      <a href="#">Link 3</a>
    </div>
  </div> 
  <a href="#about">About</a>
  
</div>	
	
	<script type="text/javascript">
	/* Toggle between adding and removing the "responsive" class to topnav when the user clicks on the icon */
	function myFunction() {
	  var x = document.getElementById("myTopnav");
	  if (x.className === "topnav") {
		x.className += " responsive";
	  } else {
		x.className = "topnav";
	  }
	}
	</script>
		
	<div class="conteudo">	
	</div>
</body>
</html>