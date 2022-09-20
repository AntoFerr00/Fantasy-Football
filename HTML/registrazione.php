<?php 

	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
  
  
	if(isset($_POST['nomeUtente']))
    $user = $_POST['nomeUtente'];
  else
    $user = "";
  if(isset($_POST['email']))
    $email = $_POST['email'];
  else
    $email = "";
  if(isset($_POST['pwd']))
    $pass = $_POST['pwd'];
  else
    $pass = "";
  if(isset($_POST['confPwd']))
    $repassword = $_POST['confPwd'];
  else
    $repassword = "";
  if(isset($_POST['squadra']))
    $team = $_POST['squadra'];
  else
    $team = "";
  if(isset($_POST['logo']))
    $logo = $_POST['logo'];
  else
    $logo = "";

  //CHECK PASSWORD
  if (!empty($pass)){
    if($pass!=$repassword){
      echo "<p> Hai sbagliato a digitare la password. Riprova</p>";
      $pass = "";
    }
    else{
      //CONTROLLO SE L'UTENTE GIA' ESISTE
      if(username_exist($user)){
        echo "<p> Username $user già esistente. Riprova</p>";
      } 
      else{
        //ORA posso inserire il nuovo utente nel db
        if(insert_team($team,$logo) && insert_utente($user,$pass,$email)){
          echo "<p> Utente e relativa squadra registrati con successo. Effettua il <a href=\"login.php\">login</a></p>";
        }
        else{
          echo "<p> Errore durante la registrazione. Riprova</p>";
        }
      }
    }
  }
?>
<!DOCTYPE HTML>
<html>
  <head>
    <title>Registrazione</title>
    <script type="text/javascript">
      document.forms.myForm.addEventListener('submit', function(e){
      e.preventDefault();
      var pwd = myForm.pwd.value;
      var confPwd = myForm.confirm.value;
      var email = myForm.email.value;
      var confEmail = myForm.confEmail.value;
      var squadra = myForm.nomeSquadra.value;
      var nomeUtente = myForm.nomeUtente.value;
      
      if(email == ""){
        alert("Devi inserire l'email!");
        email.select();
        return false;
      }
      if(pwd == ""){
        alert("Devi inserire la password!");
        pwd.select();
        return false;
      }
      if(squadra == ""){
        alert("Devi inserire un nome per la tua squadra!");
        squadra.select();
        return false;
      }
      if(nomeUtente == ""){
        alert("Devi inserire un nome utente!");
        nomeUtente.select();
        return false;
      }
      if(email != confEmail){
        alert("Le due email non coincidono. Riprova!");
        email.focus();
        confEmail.select();
        return false;
      }
      if(pwd != confPwd){
        alert("Le due password non coincidono. Riprova");
        pwd.focus();
        confPwd.select();
        return false;
      }
      myForm.submit;
    });
    function verifica(nomeInput){
      utente = nomeInput.value;
      atPos = utente.indexOf("@", 0);
      if(atPos > -1){
        alert("Non puoi inserire la @!");
        var a = new Array();
        a = utente.split("@");
        utente = a[0];
        nomeInput.value = utente;
      }
    };
    function avvisa(){
      alert("Immagine caricata con successo!");
    };
    function inserimento(){
      alert("Utente e squadra caricati con successo!");
      window.location.href = "login.php";
    }
    </script>
  </head>
  <body>
    <form method="POST">
      <fieldset>
        <legend>Registrazione Account</legend>
        <p>
        <label for="squadra">
          Nome Squadra: <input type="text" id="squadra" name="squadra"/>
        </label>
      </p>
        <p>
          <label for="nomeUtente">
            Nome Utente: <input type="text" id="nomeUtente" name="nomeUtente" onchange="verifica(this)"/>
          </label>
        </p>
        <p>
          <label for="email">
            Email: <input type="text" id="email" name="email"/>                      
          </label>
        </p>
        <p>
          <label for="confEmail">
            Conferma Email: <input type="text" id="confEmail" name="confEmail"/>
          </label>
        </p>
        <p>
          <label for="pwd">
            Password: <input type="password" id="pwd" name="pwd"/>
          </label>
        </p>
        <p>
          <label for="confPwd">
            Conferma Password: <input type="password" id="confPwd" name="confPwd"/>
          </label>
        </p>
        <p><a href="https://protezionedatipersonali.it/informativa" target="_blank">Accetto il trattamento dei dati personali</a>
            <input type="checkbox" required/>
        </p>
        <p>
          <label for="logo" onload="avvisa()">
            Scegli un logo: <input type="file" id="logo" name="logo" accept="image/png, image/jpeg, image/jpg">
          </label>
        </p>
        <p>
          <label for="add">
          <input type="submit" name="add" value="Registrati" onclick="inserimento()"/>
          </label>
          <label>
            <button onclick="location.href='login.php'">Torna indietro</button>
          </label>
        </p>
      </fieldset>
    </form>
  </body>
</html>


<?php
function username_exist($user){
	require "../PHP/logindb.php";
	//CONNESSIONE AL DB
		//echo "Connessione al database riuscita<br/>"; 
	$sql = "SELECT nome FROM utente WHERE nome=$1";
	$prep = pg_prepare($db, "sqlUsername", $sql); 
	$ret = pg_execute($db, "sqlUsername", array($user));
	if(!$ret) {
		echo "ERRORE QUERY: " . pg_last_error($db);
		return false; 
	}
	else{
		if ($row = pg_fetch_assoc($ret)){ 
			return true;
		}
		else{
			return false;
		}
	}
}

function insert_utente($user,$pass,$email){
	require "../PHP/logindb.php";
	//CONNESSIONE AL DB
		//echo "Connessione al database riuscita<br/>"; 
	$hash = password_hash($pass, PASSWORD_DEFAULT);
	$sql = "INSERT INTO utente(nome, password, email) VALUES('$user', '$hash', '$email')";
	$prep = pg_prepare($db, "insertUser", $sql); 
	$ret = pg_execute($db, "insertUser", array());
	if(!$ret) {
		echo "ERRORE QUERY: " . pg_last_error($db);
		return false; 
	}
	else{
		return true;
	}
}

function insert_team($squadra, $logo){
	require "../PHP/logindb.php";
	//CONNESSIONE AL DB
		//echo "Connessione al database riuscita<br/>"; 
	$sql = "INSERT INTO squadra(nome,logo) VALUES($1, $2)";
	$prep = pg_prepare($db, "insertTeam", $sql); 
	$ret = pg_execute($db, "insertTeam", array($squadra, $logo));
	if(!$ret) {
		echo "ERRORE QUERY: " . pg_last_error($db);
		return false; 
	}
	else{
		return true;
	}
}
?>