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
        <li><a href="#">Conto</a></li>
        |
        <li><a href="#">Riepilogo</a></li>
        |
        <li><a href="#">Proponi scommessa</a></li>
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
        <li><a href="#">Richieste accredito</a></li>
        |
        <li><a href="#">Approva scommesse</a></li>
        |
        <li><a href="#">Proponi scommessa</a></li>
        |
        <li><a href="#">Riepilogo</a></li>
        |
        <li><a href="#">Inserisci risultati</a></li>
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
        <li><a href="#">Richieste accredito</a></li>
        |
        <li><a href="#">Approva scommesse</a></li>
        |
        <li><a href="#">Riepilogo</a></li>
        |
        <li><a href="#">Inserisci risultati</a></li>
        |
        <li><a href="listaUtenti.php">Account</a></li>
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
