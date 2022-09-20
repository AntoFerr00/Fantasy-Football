<!DOCTYPE html>
<html>
<head>
	<title> Login</title>
</head>
	<body>
    <!-- // da inserire quando non ci sono più dubbi
    action="../HTML/Home.php"
  -->
<form method="post" action="login-management.php">
  <fieldset><legend>Account</legend>
    <p><label for="utente"> Username <input type="text"  id="utente"name ="utente"/></label></p>
    <p><label for="pwd"> Password <input type="password"  id="pwd"name ="pwd"/></label></p>
  </fieldset>
  <br/>
  <input type="submit" name="submit" value="Login" target="_self"/>
</form>
<p><a href="https://protezionedatipersonali.it/informativa" target="_blank">Privacy Policy</a></p>
<p>
  Non sei registrato?
  <button onclick="location.href='registrazione.php'">Registrati</button>
</p>

  <script>
    document.form.myForm.addEventListener('submit', function(e){
    e.preventDefault();
    var utente = document.getElementById("utente");
    var pwd = document.getElementById("pwd");
    if(utente == ""){
      alert("Devi inserire il nome utente!");
      utente.select();
      return false;
    }
    if(pwd == ""){
      alert("Devi inserire la password!");
      pwd.select();
      return false;
    }
    });
  </script>
	</body>
</html>