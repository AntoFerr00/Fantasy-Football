<?php
	require_once "logindb.php";

	require_once "connection.php";
?>
<html>
	<head>
		<title>DELETE</title>
	</head>

	<body>
		<?php
  // per identificare erorri nello script
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);

			if(!empty($_POST) && $_POST['action']=="delete"){
				$nome_utente_del = $_POST['nomeUtente'];
		    $nome_squadra_del = $_POST["nomeSquadra"];
        
				$sql_del = "DELETE FROM utente Where Nome=$1";
				$prep = pg_prepare($db, "deleteUtente", $sql_del);
				if(!$prep){
					echo "ERRORE PREPARED STATEMENT " . pg_last_error();
				}
				else{
					$ret = pg_execute($db, "deleteUtente", array($nome_utente_del));
					if(!$ret){
						echo "ERRORE DELETE " . pg_last_error();
					}
					else{
						echo "UTENTE CON NOME = $nome_utente_del cancellato correttamente <br/>";
					}
				}

        $sql_del = "DELETE FROM Squadra Where Nome=$2";
				$prep = pg_prepare($db, "deleteSquadra", $sql_del);
				if(!$prep){
					echo "ERRORE PREPARED STATEMENT " . pg_last_error();
				}
				else{
					$ret = pg_execute($db, "deleteSquadra", array($nome_squadra_del));
					if(!$ret){
						echo "ERRORE DELETE " . pg_last_error();
					}
					else{
						echo "SQUADRA $nome_squadra_del cancellata correttamente <br/>";
					}
				}
			}
		?>
			
	</body>
</html>
