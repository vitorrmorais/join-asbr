<?php
	include "conexao.php"; //adiciona arquivo de conexao com banco.

	$nome     = $_POST["nome"];
	$date	  = $_POST["date"];
	$email	  = $_POST["email"];
	$telefone = $_POST["telefone"];
	$regiao	  = $_POST["regiao"];
	$unidade  = $_POST["unidade"];
	$score = 10;
	$token = "06bc8a9c285ef31334b63e60f7814d19";

	switch ($regiao) { //Verifica a regiao e calcula os pontos
    case "sul":
        $score = $score - 2;
	break;
	case "sudeste";
		if ($unidade != "São Paulo") { 
			$score = $score - 1;
		}
	break;
	case "centro-oeste";
		$score = $score - 3;
	break;
	case "nordeste";
		$score = $score - 4;
	break;
	case "norte";
		$score = $score - 5;
	break;
	}
		
	
	
?>