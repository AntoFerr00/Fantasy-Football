<?php

	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);

	require_once "connection.php";
  // da rivedere meglio
	if(!empty($_POST) && $_POST['modifyTeam']){
		$nomeSquadra = $_POST["nomeSquadra"];
		$nomeGiocatore = $_POST["nomeGiocatore"];
    
		$sql = "INSERT INTO SELECT id FROM Giocatore WHERE Nome=$2";
		$ret = pg_prepare($db,"InsertGiocatore", $sql); 
		if(!$ret) {
			echo pg_last_error($db); 
		} 
		else {
			$ret = pg_execute($db, "InsertGiocatore", array($nomeSquadra,));
			if(!$ret){
				echo pg_last_error($db);
			}
			else{
				echo "<p> Giocatore $nomeGiocatore aggiunto alla squadra $nomeSquadra .</p> <p><a href=\"index.php\">Torna alla home </a></p>";
			}
		}
    
	}
?>