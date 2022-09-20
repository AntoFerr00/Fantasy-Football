<?php   
include '../PHP/logindb.php';  
?>

<html>
<head>
	<title>Gestione Login</title>
</head>
<body>

<?php
if($_POST['submit']){
  $user =  $_POST['utente'];
  $pass =  $_POST['pwd'];
  //chiama la funzione get_pwd che controlla
  //se username esiste nel DB. Se esiste, restituisce la password (hash), altrimenti restituisce false.
  $hash = get_pwd($user,$db);
  if(!$hash){
    echo "<p> L'utente $user non esiste. <a href=\"login.php\">Riprova</a></p>";
  }
  else{
    if(password_verify($pass, $hash)){
      echo "<p>Login Eseguito con successo</p>";
      //Se il login è corretto, inizializziamo la sessione
      session_start();
      $_SESSION['username']=$user;
      $_SESSION['login_type']="REGISTRED";
      echo "<p><a href=\"Home_for_logged.php\">Accedi</a> al contenuto riservato solo agli utenti registrati<p>";
    }
    else{
      echo 'Username o password errati. <a href="login.php">Riprova</a>';
      exit();
    }
  }
}
else{
  echo "<p>ERRORE: username o password non inseriti <a href=\"login.php\">Riprova</a></p>";
  exit();
}
?>

</body>
</html>
<?php
  function get_pwd($user, $db){
		$sql = "SELECT password FROM utente WHERE nome=$1;";
		$prep = pg_prepare($db, "sqlPassword", $sql); 
		$ret = pg_execute($db, "sqlPassword", array($user));
		if(!$ret) {
			echo "ERRORE QUERY: " . pg_last_error($db);
			return false; 
		}
		else{
			if ($row = pg_fetch_assoc($ret)){ 
				$pass = $row['password'];
				return $pass;
			}
			else{
				return false;
			}
   	}
  }	
?>  