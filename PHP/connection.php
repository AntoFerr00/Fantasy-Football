<?php
	require_once "logindb.php";
  
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
	//CONNESSIONE AL DB
	$db = pg_connect($connection_string) or die('Impossibile connetersi al database: ' . pg_last_error());
	 
?>
<html>
	<head>
		<title>Connessione Database</title>
	</head>

	<body>
		<?php
			echo "<p>Connessione al database riuscita</p>";
			pg_close($db);
		?>
			
	</body>
</html>
