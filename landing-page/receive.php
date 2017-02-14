<?php
	include "conexao.php"; //adiciona arquivo de conexao com banco.

	$nome     = $_POST["nome"];
	$date	  = $_POST["date"]
	$email	  = $_POST["email"]
	$telefone = $_POST["telefone"]
	$regiao	  = $_POST["regiao"]
	$unidade  = $_POST["unidade"]	
	
	mysql_query("INSERT INTO dados(nome) VALUES('$nome')"); //envia os dados acima para o banco de dados.
	

	
?>