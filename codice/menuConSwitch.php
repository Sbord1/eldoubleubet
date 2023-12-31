<html>
	<head>
		<style>
			#circle {
				width: 10px;
  				height: 10px;
  				background:red;
  				border-radius:50%;
 			}		
		</style>
	</head>


<?php
					
  					
// Controllo tipologia: se non e' settata allora il login non e' stato effettuato
if (!isset($_SESSION['tipologia'])) { //no login
    
    // escaping from interspersed.php
?>

    <!-- Se il login non e' stato effettuato (siamo un semplice visitatore) allora stampiamo il menu' per l'utente visitatore -->
    <nav>
      <ul>
        <li><a href="inizio.php">Home</a></li>
        |
        <li><a href="infoGenerali.php">Info Generali</a></li>
        |
        <li><a href="calcio.php">Calcio</a></li>
        |
        <li><a href="basket.php">Basket</a></li>
        |
        <li><a href="tennis.php">Tennis</a></li>
        |
        <li><a href="ippica.php">Ippica</a></li>
        |
        <li><a href="esempiVincite.php">Vincite</a></li>
      </ul>
    </nav>

<?php

}

// Il login e' stato effettuato
else {

    // Un utente puo' essere di 3 tipi: scommettitore, admin oppure gestore

    switch($_SESSION['tipologia']) {

        // Utente scommettitore loggato --> mostriamo il menu' relativo all'utente scommettitore
        case "scommettitore":

?>

    <nav>
      <ul>
        <li><a href="inizio.php">Home</a></li>
        |
        <li><a href="infoGenerali.php">Info Generali</a></li>
        |
        <li><a href="calcio.php">Calcio</a></li>
        |
        <li><a href="basket.php">Basket</a></li>
        |
        <li><a href="tennis.php">Tennis</a></li>
        |
        <li><a href="ippica.php">Ippica</a></li>
        |
        <li><a href="conto.php">Conto</a></li>
        |
        <li><a href="riepilogoScommesseUtente.php">Riepilogo</a></li>
        |
        <li><a href="proposteScommessa.php">Proponi scommessa</a></li>
        |
        <li><a href="proposteInviate.php">Proposte inviate</a></li>
        |
        <li><a href="chat.php">Chat</a></li>
        |
        <li><a href="forum.php">Forum</a></li>
      </ul>
    </nav>

<?php
        break;
    
        // Utente gestore loggato
        case "gestore":
?>
	
    <nav>
      <ul>
        <li><a href="calcio.php">Calcio</a></li>
        |
        <li><a href="basket.php">Basket</a></li>
        |
        <li><a href="tennis.php">Tennis</a></li>
        |
        <li><a href="ippica.php">Ippica</a></li>
        |
        <li>
         <?php 
          	if (isset($_SESSION['richieste']) && $_SESSION['richieste']=="si"){
          		echo "<div id=\"circle\"></div>";
          		}
          ?>
        <a href="richiesteAccredito.php">Richieste accredito</a>
        </li>
        |
        <li><a href="approvaScommessa.php">Approva scommesse</a></li>
        |
        <li><a href="proposteScommessa.php">Inserimento scommessa</a></li>
        |
        <li><a href="riepilogoGestore.php">Riepilogo</a></li>
        |
        <li><a href="inserisciRisultati.php">Inserisci risultati</a></li>
        |
        <li><a href="chat.php">Chat</a></li>
      </ul>
    </nav>

<?php
        break;
    
        // Utente amministratore loggato
        case "admin":

?>

    <nav>
      <ul>
        <li><a href="calcio.php">Calcio</a></li>
        |
        <li><a href="basket.php">Basket</a></li>
        |
        <li><a href="tennis.php">Tennis</a></li>
        |
        <li><a href="ippica.php">Ippica</a></li>
        |
        <li>
        <?php 
          	if (isset($_SESSION['richieste']) && $_SESSION['richieste']=="si"){
          		echo "<div id=\"circle\"></div>";
          		}
          	?>
          <a href="richiesteAccredito.php">Richieste accredito</a>
          
        </li>
        |
        <li><a href="approvaScommessa.php">Approva scommesse</a></li>
        |
	<li><a href="proposteScommessa.php">Inserimento scommessa</a></li>
        |
        <li><a href="scommesseEliminate.php">Eliminazioni</a></li>
        |
        <li><a href="inserisciRisultati.php">Risultati</a></li>
        |
        <li><a href="listaUtenti.php">Account</a></li>
        |
        <li><a href="chat.php">Chat</a></li>
      </ul>
    </nav>

<?php
        break;

        // If no match is found
        default:
?>
        <p>Errore nel sistema!</p>

<?php
    } // chiude lo switch
} // chiude l'else
?>
</html>
