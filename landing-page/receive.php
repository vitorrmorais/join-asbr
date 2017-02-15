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
	
	//Envia dados para o banco
	$query = mysqli_query($conecta, "INSERT INTO `dados` (nome, datanasc, email, telefone, regiao, unidade, score, token) VALUES('$nome', '$date', '$email', '$telefone', '$regiao', '$unidade', '$score', '$token')");
	
	//Obtem o id da ultilma tabela para poder enviar via post
	$ultimoid = mysqli_insert_id($conecta);
	echo $ultimoid;	

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
	foreach($campos as $name => $valor) {
    	$string_campos .= $name . '=' . $valor . '&';
	}
	$string_campos = rtrim($string_campos,'&');
	$ch = curl_init();
	curl_setopt($ch,CURLOPT_URL,$url);
	curl_setopt($ch,CURLOPT_RETURNTRANSFER, TRUE);
	curl_setopt($ch,CURLOPT_POST,count($campos));
	curl_setopt($ch,CURLOPT_POSTFIELDS,$string_campos);
	$resultado = curl_exec($ch);
	curl_close($ch);
	echo $resultado;

?>
