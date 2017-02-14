<?php
$host = "localhost";
$user = "root";
$pass = "";
$banco = "landing";
mysql_connect($host, $user, $pass) or die (mysql_error()); //conecta usando os dados acima ou mostra erro.
mysql_select_db($banco) or die (mysql_error()); //seleciona o banco de dados. 
?>