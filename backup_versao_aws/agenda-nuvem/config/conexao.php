<?php

error_reporting(0);


$con = mysql_connect("localhost", "root", "");
$db = mysql_select_db("cna_backend", $con);



if(!$con){
	die("Não foi possível conectar ao banco de dados; " .mysql_error());
}

mysql_query("SET NAMES 'utf8'");
mysql_query('SET character_set_connection=utf8');
mysql_query('SET character_set_client=utf8');
mysql_query('SET character_set_results=utf8');


?>