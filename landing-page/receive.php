<?php
	include "conexao.php"; //Adiciona arquivo de conexao com banco.

	$nome     = $_POST["nome"];
	$date	  = $_POST["data_nascimento"];
	$email	  = $_POST["email"];
	$telefone = $_POST["telefone"];
	$regiao	  = $_POST["regiao4"];
	$unidade  = $_POST["unidade4"];
	$score    = 10;
	$token    = "06bc8a9c285ef31334b63e60f7814d19";

	//Verifica a regiao e calcula o score
	switch ($regiao) { 
    case "Sul":
        $score = $score - 2;
	break;
	case "Sudeste";
		if ($unidade != "São Paulo") { 
			$score = $score - 1;
		}
	break;
	case "Centro-Oeste";
		$score = $score - 3;
	break;
	case "Nordeste";
		$score = $score - 4;
	break;
	case "Norte";
		$score = $score - 5;
	break;
	}

	//Calcula idade do cliente
	$tdate = new DateTime( $date );
	$fixdate = new DateTime( '2016-11-01' );
	$idade = $tdate->diff( $fixdate );
	$idade = $idade->y;

	//Calcula o score de acordo com a idade do cliente
	if ($idade >= 100 || $idade < 18){
		$score = $score - 5;
	} elseif ($idade >= 40 && $idade <= 99) {
		$score = $score - 3;
	}
	
	if(strcasecmp('formulario-ajax', $_POST['metodo']) == 0){

		//Envia dados para o banco
		$query = mysqli_query($conecta, "INSERT INTO `dados` (nome, datanasc, email, telefone, regiao, unidade, score, token) VALUES('$nome', '$date', '$email', '$telefone', '$regiao', '$unidade', '$score', '$token')");
		
		//Envia leads para o endpoint
		$url = 'http://api.actualsales.com.br/join-asbr/ti/lead';
		$campos = array(
    		'nome'=>urlencode($nome),
			'email'=>urlencode($email),
			'telefone'=>urlencode($telefone),
			'regiao'=>urlencode($regiao),
			'unidade'=>urlencode($unidade),
    		'data_nascimento'=>urlencode($date),
			'score'=>urlencode($score),
			'token'=>urlencode($token)
		);
		$ch = curl_init();
		curl_setopt($ch,CURLOPT_URL,$url);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch,CURLOPT_POST, TRUE);
		curl_setopt($ch,CURLOPT_POSTFIELDS,$campos);
		$resultado = curl_exec($ch);
		curl_close($ch);
		echo $resultado;
	}
	
?>
