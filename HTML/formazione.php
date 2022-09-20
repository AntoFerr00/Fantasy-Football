<!DOCTYPE HTML>
<html>
  <head>
    <title>Squadra e Formazione</title>
  	<style>
      nav
      {
      height: 200px; 
      width: 100%; 
      overflow: hidden; 
      overflow-y: scroll;
      }
  
      nav ul 
      {
      list-style: none;
      margin:0;
      padding:0;
      display: table;
      width: 100%;
      }
          
      #menuLi
      {
      margin: 5px;
      z-index:10;
      text-align: center;
      border: medium solid green;
      background-color: green;
      }
      
      #btt 
      {
      font: bold 12px Arial, Helvetica, sans-serif;
      color: #fff;
      padding: 10px 20px;
      border: solid 1px green;
      background: green;
      }
      
      #btt:hover 
      {
      width: 100%;
      }
      
      #btt:active
      {
      position: relative;
      top: 1px;
      }
      
      #schema, #seleziona
      {
      background: lightgrey;
      text-align: center;
      }
      </style>
      
      <SCRIPT>
        /* Quando l'utente clicca su "Inserisci Squadra", appaiono tutti i giocatori delle squadre con l'header "Seleziona giocatore"
           e i nomi delle squadre a cui appartengono i giocatori, nascondendo il pulsante cliccato */
      	function inserisci(){          
        	document.getElementById("bottoneInserisci").style.visibility = "hidden"; // Nascondo il pulsante "Inserisci Squadra"
			    document.getElementById("SelSquadra").style.visibility = "visible"; // Rendo visibile l'header "Seleziona giocatore"
          document.getElementById("squadre").style.visibility = "visible";  // Rendo visibile i giocatori con le varie squadre
        }

        /* Quando l'utente vuole aggiungere un giocatore, clicca sul pulsante "Aggiungi" accanto al ruolo del giocatore e,
           il giocatore scelto sarà spostato nella squadra dell'utente, sostituendo il pulsante "Aggiungi" con il pulsante "Rimuovi" */
        function addPlayer($id){
          document.getElementById("squadraTxt").style.display = "none"; // Nascondo e rimuovo dal flow della pagina il testo di "Inserisci una squadra(max 20 giocatori)"
          
          /*var phpadd= <?php //echo partecipazioneSquadraUtente();?> */

          //document.getElementById("tabella_sx").getElementById("2").style.display = "none"; // Nascondo e rimuovo dal flow della pagina il giocatore nella colonna di sinistra
          var giocatore = document.getElementById($id).cloneNode(true);
          //giocatore.removeChild(giocatore.getElementByClass("button"));

          var tdOld = document.getElementById("squadraTxt"); // Mi salvo in una variabile l'elemento che poi dovrò sostituire sulla colonna di destra
          var table = document.createElement("table"); // Creo un elemento td
          var tdNew = document.createElement("td"); // Creo un elemento td
          var btn = document.createElement("button"); // Creo un elemento button       
          var td3 = document.createElement("td"); // Creo un elemento td
          /* Da sostituire poi con i dati del db */
          btn.innerHTML = "Rimuovi"; // Scrivo nel bottone "Rimuovi"
          btn.setAttribute("onclick", "removePlayer()"); // Assegno la funzione removePlayer() al click del bottone
          td3.appendChild(btn); // Aggiungo al td3 il bottone creato con tutti i vari attributi

          giocatore.appendChild(td3); // Aggiungo td3 al tr

          tdNew.setAttribute("id", "tdNew"); // Assegno un id al nuovo td creato che mi servirà nella funzione removePlayer()

          table.appendChild(giocatore); // Aggiungo il giocatore alla tabella
          tdNew.appendChild(table); // Aggiungo la tabella al td 
          document.getElementById("InsertTeam").replaceChild(tdNew, tdOld); // Sostituisco la tdOld con quella appena creata         
        }

        function removePlayer(){
          document.getElementById("tdNew").remove(); // Rimuovo il giocatore creato a destra
          // Ricreo ciò scritto alla riga 121
          var td = document.createElement("td");
          td.innerHTML = "Inserisci una squadra (max 20 giocatori)";
          td.setAttribute("colspan", "4");
          td.setAttribute("rowspan", "4");
          td.setAttribute("text-align", "center");
          td.setAttribute("id", "squadraTxt");
          document.getElementById("InsertTeam").appendChild(td); // Aggiungo la scritta creata     
          // Rimetto a sinistra il giocatore rimosso
          var gioc = document.getElementById("giocatore1");
          gioc.style.display = "table-row";          
        }
    </SCRIPT>    
  </head>
  <body>
    <table border="1">
      <tr id="InsertTeam">
        <td id="schema">Schema</td>
        <td id="squadraTxt" rowspan="4" colspan="4" style="text-align: center;">Inserisci una squadra (max 20 giocatori)</td>
      </tr>
      <tr>
        <td>
          <div id="menuSchema">
            <nav>
              <ul>
                <li id="menuLi"><button id="btt">4-4-2</button></li>
                <li id="menuLi"><button id="btt">3-4-3</button></li>
                <li id="menuLi"><button id="btt">3-4-1-2</button></li>
                <li id="menuLi"><button id="btt">3-4-2-1</button></li>
                <li id="menuLi"><button id="btt">3-5-2</button></li>
                <li id="menuLi"><button id="btt">4-3-3</button></li>
                <li id="menuLi"><button id="btt">4-3-1-2</button></li>
                <li id="menuLi"><button id="btt">4-3-2-1</button></li>
                <li id="menuLi"><button id="btt">4-2-3-1</button></li>
                <li id="menuLi"><button id="btt">4-4-1-1</button></li>
                <li id="menuLi"><button id="btt">4-2-2-2</button></li>
              </ul>
            </nav>
          </div>
        </td>
      </tr>
      
      <tr id="SelSquadra" style="visibility: hidden;">
      	<!-- Ricordiamoci di vedere come funziona con inserimento dati in db -->
      	<td id="seleziona">
        	Seleziona giocatore
        </td>
      </tr>
      <tr id="squadre" style="visibility: hidden;">
        <td>
          <nav>
            <ul id="lista">
              <?php
                require_once "../PHP/logindb.php";

                $sql = "SELECT idgiocatore,nome, cognome, numeromaglia, squadrareale, ruolo FROM giocatore";
                $ret = pg_query($db, $sql); 
                if(!$ret) {
                  echo "ERRORE QUERY: " . pg_last_error($db);
                  exit; 
                }
              ?>

                  <table border="true" id="tabella_sx">
                    <tr>
                      <th>Id Giocatore</th> 
                      <th>Nome</th> 
                      <th>Cognome</th>
                      <th>Numero maglia</th>
                      <th>Squadra reale</th>
                      <th>Ruolo</th>
                    </tr>
                  <?php
                    //row[0] contiene l'id.
                    while($row = pg_fetch_array($ret)){ 
                      $id=$row["idgiocatore"];
                      $nome = $row["nome"];
                      $cognome = $row["cognome"];
                      $numero = $row["numeromaglia"];
                      $squadra = $row["squadrareale"];
                      $ruolo = $row["ruolo"];
                      echo "<tr id='$id'>";
                      echo "<td>$id</td>";
                      echo "<td>$nome</td>";
                      echo "<td>$cognome</td>";
                      echo "<td>$numero</td>";
                      echo "<td>$squadra</td>";
                      echo "<td>$ruolo</td>";
                      echo "<td><button onclick='addPlayer($id)'>Aggiungi</button></td>";
                      echo "</tr>";
                    }
                    echo "</table>";
                    //pg_close($db);
                    ?>
              </ul>
          </nav>
        </td>
      </tr>
      
      <tr>
      	<td id="bottoneInserisci" rowspan="3"><button onclick="inserisci()">Inserisci nuova squadra</button></td>
        <td><button id="salvaSquadra" disabled>Salva Squadra</button></td>
        <td><button id="eliminaSquadra" disabled>Elimina Squadra</button></td>
      </tr>
    </table>


  </body>
</html>
