<?php
	require_once "connection.php";
	
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
?>
<html>
	<head>
		<title>Classifica</title>
	</head>

	<body>
		<h1>Squadre</h1>
		<?php
		//$selezione = $_GET['selection'];
			$sql = "SELECT Nome, Punteggio, Posizione FROM Squadra;";
			$ret = pg_query($db, $sql); 
			if(!$ret) {
				echo "ERRORE QUERY: " . pg_last_error($db);
				exit; 
			}
		?>
		<table border="true">
			<tr>
				<th>Nome</th> 
        <th>Punteggio</th>
        <th>Posizione</th>
			</tr>
		<?php
			//row[0] contiene l'id.
			while($row = pg_fetch_array($ret)){ 
				$nome = $row["nome"];
				$punteggio = $row["punteggio"];
				$posizione = $row["posizione"];
				echo "<tr>";
				echo "<td>$nome</td>";
				echo "<td>$punteggio</td>";
				echo "<td>$posizione</td>";
				echo "</tr>";
			}
			echo "</table>";
			pg_close($db);
			?>
	</body>
</html>
