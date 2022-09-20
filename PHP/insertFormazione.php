<?php
	require_once "connection.php";

	if(!empty($_POST) && $_POST['salvaFormazione']){
		$capitano = $_POST["capitano"];
		$schema = $_POST["schema"];
		$punteggioGiornata = $_POST["punteggioGiornata"]; //da vedere da dove prendere
		$giornata = $_POST["giornata"]; //da venerdì a lunedì
    $dataInserimento = date('Y-m-d H:i:s');
    $sql="INSERT INTO Formazione(Capitano, Schema, PunteggioGiornata, Giornata, dataInserimento) VALUES($1, $2, $3, $4,$5)";
    $ret = pg_prepare($db,"InsertFormazione", $sql); 
    if(!$ret) {
      echo pg_last_error($db); 
    } 
    else {
      $ret = pg_execute($db, "InsertFormazione", array($capitano, $schema, $punteggioGiornata, $giornata, $dataInserimento));
      if(!$ret){
        echo pg_last_error($db);
      }
      else{
        echo "<p>Formazione aggiunta</p>";
      }
    }
  }    
?>