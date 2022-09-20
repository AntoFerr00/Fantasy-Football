<?php

	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);

  session.start();
  
  include_once "connection.php"
  $db = pg_connect($connection_string) or die("Impossibile connettersi al database:". pg_last_error());
  $username = $_POST['user'];
  $pwd = $_POST['pwd'];
  $sql = "SELECT username, password FROM utente WHERE username='$username';";
  $ret = pg_query($db, $sql);
  if(!$ret){
    echo "Username non trovato. Riprovare";
    exit;
  }
  $row = pg_fetch_assoc($ret);
  $us = $row['username'];
  $pw = $row['pwd'];
  if(!password_verify($password, $pw))
    echo "Attenzione: username o password errati. Riprovare";
  else{
  ?>
  <!-->Nel caso in cui l'utente si sia loggato correttamente con username e password qui ci saranno le cose che potrà vedere solo lui come tag HTML.  
<?php } ?>
