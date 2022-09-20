<?php

session_start();

if(!isset($_SESSION['username']) || !isset($_SESSION['login_type']) )
{
    header("Location:Home.php");
    exit;
}
if ( $_SESSION['login_type'] != 'REGISTRED' ) {
    // This is an admin only page.
    header("Location: Home.php");
    exit;
}

$user = $_SESSION["username"];
echo "<p> Benvenuto $user!</p>";
echo "<input type='button' onclick='logout()' value='Logout'/>";

?>
<!DOCTYPE html>
<html>
<head>
<title>Fantacalcio</title>
<link rel="stylesheet"type="text/css"href="style.css"/>
</head>
  <body>
  <h1>
    Titolo
  </h1>
  <table>
<thead>
<tr>
      <td><a href="Home.php">Home</a></td>
      <td><a href="profilo.php">Profilo</a></td>
      <td><a href="formazione.php">Squadra</a></td>
      <td><a href="formazione.php">Formazione giornata</a></td>
</tr>
</thead>
<tbody>
<tr>
      <td><p> CLASSIFICHE</p>

      <td colspan=2 rowspan=2><iframe width="900" height="550" src="https://www.gazzetta.it/" ></iframe></td>

      <td rowspan=3><ul>
      <li><a href="https://www.acmilan.com/it/news/articoli/ultime" target="_blank">Milan</a></li>
      <li><a href="https://www.inter.it/it/news" target="_blank">Inter</a></li>
      <li><a href="https://www.sscnapoli.it/static/content/Notizie-338.aspx" target="_blank">Napoli</a></li>
      <li><a href="https://www.juventus.com/it/news/" target="_blank">Juventus</a></li>
      <li><a href="https://www.sslazio.it/it/news" target="_blank">Lazio</a></li>
      <li><a href="https://www.asroma.com/it/" target="_blank">Roma</a></li>
      <li><a href="https://www.atalanta.it/news/" target="_blank">Atalanta</a></li>
      <li><a href="https://www.fiorentina.it/category/news/" target="_blank">Fiorentina</a></li>
      <li><a href="https://www.hellasverona.it/it/news?cat=11" target="_blank">Verona</a></li>
      <li><a href="https://www.torinofc.it/news/all" target="_blank">Torino</a></li>
      <li><a href="https://www.sassuolocalcio.it/news/" target="_blank">Sassuolo</a></li>
      <li><a href="https://www.udinese.it/news" target="_blank">Udinese</a></li>
      <li><a href="https://www.bolognafc.it/news/" target="_blank">Bologna</a></li>
      <li><a href="https://empolifc.com/news/" target="_blank">Empoli</a></li>
      <li><a href="https://www.sampdoria.it/category/news/" target="_blank">Sampdoria</a></li>
      <li><a href="https://www.acspezia.com/it/news.html" target="_blank">Spezia</a></li>
      <li><a href="https://www.ussalernitana1919.it/news/" target="_blank">Salernitana</a></li>
      <li><a href="https://www.cagliaricalcio.com/news/ultimissime" target="_blank">Cagliari</a></li>
      <li><a href="https://genoacfc.it/it/news/archivio-notizie/#" target="_blank">Genoa</a></li>
      <li><a href="https://www.veneziafc.it/news/category/men" target="_blank">Venezia</a></li>
      </ul></td>
<tr>
      <td><iframe width="450" height="550" src="https://www.diretta.it/serie-a/classifiche/" seamless></iframe></td>
</tr>

<tr>
	<td></td>
      <td><iframe width="650" height="500"src="https://www.diretta.it/serie-a/calendario/" seamless></iframe></td>
</tr>
</tbody>
<tfoot>

<tr>
      <td colspan=4>contattaci<br>
      <ul>
      <li><a href="mailto: f.diperna6@studenti.unisa.it">f.diperna6@studenti.unisa.it</a></li>
      <li><a href="mailto: f.diperna6@studenti.unisa.it">f.diperna6@studenti.unisa.it</a></li>
      <li><a href="mailto: f.diperna6@studenti.unisa.it">f.diperna6@studenti.unisa.it</a></li>
      <li><a href="mailto: f.diperna6@studenti.unisa.it">f.diperna6@studenti.unisa.it</a></li>
      </ul></td>
</tr>
</tfoot>
  </table>
    </body>
</html>
<?php
    function logout(){
        $sname=session_name();
        session_destroy();
        /* ed elimina il cookie corrispondente */
        if (isset($_COOKIE['login'])) { 
            setcookie($sname,'', time()-3600,'/');
        }
        echo "<p> Logout effettuato. Ciao ".$_SESSION["username"]." </p>";
        echo "<p>Torna alla <a href=\"Home.php\">Home</a></p>";
    
    }
?>