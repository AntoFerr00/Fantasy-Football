<?php

session_start();
if(empty($_SESSION["username"])){
  echo "<p>Pagina riservata agli utenti registrati. <br/> Effettua il <a href=\"login.php\">Login</a> oppure <a href=\"registrazione.php\">Registrati</a> per continuare</p>";
} else{
  
require "../PHP/logindb.php";

if (!isset($_SESSION["id"])) {
    header("location: login.php");
    exit;
}

$nomeUtente=$_SESSION["username"];

if(isset($_POST['modNome'])&&!empty($_POST['modNome']&&$_POST['salva'])&&!empty($_POST['salva'])){
  // Aggiorna nome utente
  if(count($_POST)>0) {
    $nomeUtenteNuovo=$_POST['modNome'];
    $nomeUtentePrecedente=$_SESSION["username"];
    $_SESSION["username"]=$nomeUtenteNuovo;

    $sql1 = "update utente set nome='$nomeUtenteNuovo' where nome='$nomeUtentePrecedente'";
		$ret2 = pg_prepare($db,"UpdateUserName", $sql1); 
		if(!$ret2) {
			echo pg_last_error($db); 
		} 
		else {
			$ret2 = pg_execute($db, "UpdateUserName", array());
			if(!$ret2){
				echo pg_last_error($db);
			}
			else{
				echo "<p>Username aggiornato</p>";
			}
		}
  }
}

if(isset($_POST['modEmail'])&&!empty($_POST['modEmail']&&$_POST['salva'])&&!empty($_POST['salva'])){
  // Aggiorna email utente 
  if(count($_POST)>0) {
    $email=$_POST['modEmail'];

    $sql1 = "update utente set email='$email' where nome='$nomeUtente'";
		$ret2 = pg_prepare($db,"UpdateEmail", $sql1); 
		if(!$ret2) {
			echo pg_last_error($db); 
		} 
		else {
			$ret2 = pg_execute($db, "UpdateEmail", array());
			if(!$ret2){
				echo pg_last_error($db);
			}
			else{
				echo "<p>Email aggiornata</p>";
			}
		}
  }
}

if(isset($_POST['modPwd'])&&!empty($_POST['modPwd']&&$_POST['salva'])&&!empty($_POST['salva'])){
  // Aggiorna password utente 
  if(count($_POST)>0) {
    $nomeUtente=$_SESSION["username"];
    $pwd=$_POST['modPwd'];
	  $hash = password_hash($pass, PASSWORD_DEFAULT);
    $sql1 = "update utente set password='$hash' where nome='$nomeUtente'";
		$ret2 = pg_prepare($db,"UpdatePass", $sql1); 
		if(!$ret2) {
			echo pg_last_error($db); 
		} 
		else {
			$ret2 = pg_execute($db, "UpdatePass", array());
			if(!$ret2){
				echo pg_last_error($db);
			}
			else{
				echo "<p>Password aggiornata</p>";
			}
		}
  }
}

if(isset($_POST['modSquadra'])&&!empty($_POST['modSquadra']&&$_POST['salva'])&&!empty($_POST['salva'])){
  // Aggiorna nome squadra 
  if(count($_POST)>0) {
    $nomeUtente=$_SESSION["username"];
    $nomeSquadra=$_POST['modSquadra'];

    $sql1 = "update squadra set nome='$nomeSquadra' from utente where nome='$nomeUtente'";
		$ret2 = pg_prepare($db,"UpdateTeamName", $sql1); 
		if(!$ret2) {
			echo pg_last_error($db); 
		} 
		else {
			$ret2 = pg_execute($db, "UpdateTeamName", array());
			if(!$ret2){
				echo pg_last_error($db);
			}
			else{
				echo "<p>Nome della squadra aggiornato</p>";
			}
		}
  }
}

if(isset($_POST['logo'])&&!empty($_POST['logo']&&$_POST['salva'])&&!empty($_POST['salva'])){
  // Aggiorna logo squadra (capire meglio come deve andare)
  if(count($_POST)>0) {
    $nomeUtente=$_SESSION["username"];
    $logoSquadra=$_POST['logo'];

    $sql1 = "update squadra set logo=(pg_read_binary_file('$logoSquadra')::bytea) from utente where nome='$nomeUtente'";
		$ret2 = pg_prepare($db,"UpdateTeamLogo", $sql1); 
		if(!$ret2) {
			echo pg_last_error($db); 
		} 
		else {
			$ret2 = pg_execute($db, "UpdateTeamLogo", array());
			if(!$ret2){
				echo pg_last_error($db);
			}
			else{
				echo "<p>Logo della squadra aggiornato</p>";
			}
		}
  }
}

if(isset($_POST['elimina'])&&!empty($_POST['elimina'])){
  if(count($_POST)>0) {

    // Rimuovi utente
    $sql2 = "delete from squadra 
    using utente 
    where squadra.idSquadra=utente.idSquadra and  utente.nome='$nomeUtente';";
		$ret2 = pg_prepare($db,"deleteTeamAndUser", $sql2); 
		if(!$ret2) {
			echo pg_last_error($db); 
		} 
		else {
			$ret2 = pg_execute($db, "deleteTeamAndUser", array());
			if(!$ret2){
				echo pg_last_error($db);
			}
			else{
				echo "<p>Utente eliminato</p>";
        session_destroy();
        exit();
			}
		}
    
   }
}
?>
<!DOCTYPE HTML>
<html>
  <head>
    <title>Profilo</title>
  </head>
  <body>
    <form method="POST" target="profilo.php" action="<?php echo $_SERVER['PHP_SELF'] ?>" >
      <fieldset>
        <legend>Modifica profilo</legend>
        <p>
          <label >
            <input type="text" class="modNome" name="modNome" onkeyup="stoppedTyping()" placeholder="Modifica nome utente"/>
          </label>
        </p>
        <p>
          <label >
            <input type="text" class="modEmail" name="modEmail" placeholder="Modifica email"/>
          </label>
        </p>
        <p>
          <label >
            <input type="password" class="modPwd" name="modPwd" placeholder="Modifica Password"/>
          </label>
        </p>
        <p>
          <label >
            <input type="text" class="modSquadra" name="modSquadra" placeholder="Modifica nome Squadra:"/>
          </label>
        </p>
        <p>
          <label >
            Cambia logo: <input type="file" class="logo" name="logo" accept="image/png, image/jpeg, image/jpg">
          </label>
        </p>
      </fieldset>
      <p>
        <input type="submit" id="salva" name="salva" value="Salva modifiche" name="submit"/>
        <script>
          // Da rivedere per disabilitare bottone quando non ci sono modifiche
          var bottoneSalva = document.getElementsById("salva")[0];
          var name = document.getElementsById("modNome")[0];
          var psw = document.getElementsById("modPwd").value;
          var email = document.getElementsById("modEmail").value;
          var team = document.getElementsById("modSquadra").value;
          var logo = document.getElementsById("logo").value;
          function stoppedTyping(){
            if(this.value.length > 0) { 
              document.getElementsById('salva').disabled = false; 
            } else { 
              document.getElementsById('salva').disabled = true;
            }
          }
          function success(){
            alert("Modifiche apportate con successo");
          }
        </script>
      </p>
      <p>
      <input type="submit" class="elimina" name="elimina" value="Elimina account" target="_self"/>
        <script>
          var pressedButton = document.getElementsByClassName("elimina")[0];
          pressedButton.addEventListener("click", function (event) {
              if(confirm("Sei sicuro di voler eliminare definitivamente l'account?"))
                alert("Account eliminato con successo");
          });
        </script>
      </p>
    </form>
  </body>
</html>
<?php

}
?>