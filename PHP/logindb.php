<?php

	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);

$host = 'localhost';
$port = '5432';
$db = 'fantacalcio';
$username = 'www';
$password = 'tsw2022';
$connection_string = "host=$host dbname=$db user=$username password=$password";
//CONNESSIONE AL DB
$db = pg_connect($connection_string) or die('Impossibile connetersi al database: ' . pg_last_error());

?>