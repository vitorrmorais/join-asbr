<?php
	include "conexao.php"; //adiciona arquivo de conexao com banco.

	$nome     = $_POST["nome"];
	$date	  = $_POST["data_nascimento"];
	$email	  = $_POST["email"];
	$telefone = $_POST["telefone"];
	$regiao	  = $_POST["regiao"];
	$unidade  = $_POST["unidade"];
	$score = 10;
	$token = "06bc8a9c285ef31334b63e60f7814d19";

	//Verifica a regiao e calcula o score
	switch ($regiao) { 
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

	//Calcula idade do cliente
	$date = new DateTime( $date );
	$fixdate = new DateTime( '2016-11-01' );
	$idade = $date->diff( $fixdate );
	$idade = $idade->y;
	echo $idade;

	//Calcula o score de acordo com a idade do cliente
	if ($idade >= 100 || $idade < 18){
		$score = $score - 5;
		echo $score;
	} elseif ($idade >= 40 && $idade <= 99) {
		$score = $score - 3;
		echo $score;
	}
	
	
?>