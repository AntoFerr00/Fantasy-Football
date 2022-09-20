<?php
	require_once "logindb.php";

	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);

	if(!empty($_POST) && $_POST['submit']){
		$nomeSquadra = $_POST["nomeSquadra"];
		$logo = $_POST["logo"];
		$nomeUtente = $_POST["nomeUtente"];
		$email = $_POST["email"];
		$password = $_POST["password"];
    
		$sql1 = "INSERT INTO Squadra(Nome, Punteggio, Posizione, Logo) VALUES($1, 0, 0, $2)";
		$ret = pg_prepare($db,"InsertSquadra", $sql1); 
		if(!$ret) {
			echo pg_last_error($db); 
		} 
		else {
			$ret = pg_execute($db, "InsertSquadra", array($nomeSquadra, 0, 0, $logo));
			if(!$ret){
				echo pg_last_error($db);
			}
			else{
				echo "<p>Squadra $nomeSquadra aggiunta.</p> <p><a href=\"index.php\">Torna alla home </a></p>";
			}
		}
    
		$sql2 = "INSERT INTO Utente(Nome,Password,Email) VALUES ($1,$3,$2)";
		$ret = pg_prepare($db,"InsertUtente", $sql2); 
		if(!$ret) {
			echo pg_last_error($db); 
		} 
		else {
			$ret = pg_execute($db, "InsertUtente", array($nomeUtente, $password, $email));
			if(!$ret){
				echo pg_last_error($db);
			}
			else{
				echo "<p>Utente $nomeUtente aggiunto.</p> <p><a href=\"index.php\">Torna alla home </a></p>";
			}
		}
	}
?>