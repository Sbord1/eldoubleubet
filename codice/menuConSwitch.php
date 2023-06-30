<?php

// Controllo tipologia: se non e' settata allora il login non e' stato effettuato
if (!isset($_SESSION['tipologia'])) { //no login
    
    // escaping from interspersed.php
?>

    <!-- Se il login non e' stato effettuato (siamo un semplice visitatore) allora stampiamo il menu senza il carrello! -->
    <table border="1" cellpadding="5" style="border-color: black; margin-left: auto; margin-right: auto;">
        <tbody>
            <tr>
                <td style="background-color: lightgray;">
                    <a href="index.php">Home</a>
                </td>

                <td style="background-color: lightgray;">
                    <a href="infoGenerali.php">Info Generali</a>
                </td>

                <td style="background-color: lightgray;">
                    <a href="calcio.php">Calcio</a>
                </td>

                <td style="background-color: lightgray;">
                    <a href="basket.php">Basket</a>
                </td>

                <td style="background-color: lightgray;">
                    <a href="tennis.php">Tennis</a>
                </td>

                <td style="background-color: lightgray;">
                    <a href="ippica.php">Ippica</a>
                </td>
                  
            </tr>    
        </tbody>
</table>

<?php

}

// Il login e' stato effettuato
else {

    // Un utente puo' essere di 2 tipi: user (cliente) oppure admin (amministratore)

    switch($_SESSION['tipologia']) {

        // Utente cliente loggato --> mostriamo il carrello nel menu
        case "scommettitore":

?>
        <table border="1" cellpadding="5" style="border-color: black; margin-left: auto; margin-right: auto;">
            <tbody>
                <tr>
                    <td style="background-color: lightgray;">
                        <a href="index.php">Home</a>
                    </td>

                    <td style="background-color: lightgray;">
                        <a href="infoGenerali.php">Info generali</a>
                    </td>

                    <td style="background-color: lightgray;">
                        <a href="calcio.php">Calcio</a>
                    </td>

                    <td style="background-color: lightgray;">
                        <a href="basket.php">Basket</a>
                    </td>

                    <td style="background-color: lightgray;">
                        <a href="tennis.php">Tennis</a>
                    </td>

                    <td style="background-color: lightgray;">
                        <a href="ippica.php">Ippica</a>
                    </td>

                    <td style="background-color: lightgray;">
                        <a href="conto.php">Conto</a>
                    </td>
                    
                    <td style="background-color: lightgray;">
                        <a href="riepilogo.php">Riepilogo</a>
                    </td>
                    
                    <td style="background-color: lightgray;">
                        <a href="proposta.php">Proposta</a>
                    </td>
                    
                    <td style="background-color: lightgray;">
                        <a href="chat.php">Chat</a>
                    </td>
                    
                    <td style="background-color: lightgray;">
                        <a href="forum.php">Forum</a>
                    </td>
                    
                    <td style="background-color: white;">
                        <a href="zonaPagamenti.php">
                            <img src="loghi/cartLogo.png" alt="cart logo" height="20" />
                        </a>
                    </td>
                    

                </tr>    
            </tbody>
        </table>

<?php
        break;
    
        // Utente amministratore loggato
        // --> mostriamo nel menu il bottone per aggiungere film e quello per vedere la lista di utenti registrati al sito
        case "gestore":
?>
	
        <table border="1" cellpadding="5" style="border-color: black; margin-left: auto; margin-right: auto;">
            <tbody>
                <tr>
                    <td style="background-color: lightgray;">
                        <a href="index.php">Home</a>
                    </td>

                    <td style="background-color: lightgray;">
                    	<a href="calcio.php"> Calcio </a>

                    </td>

                    <td style="background-color: lightgray;">
                        <a href="basket.php">Basket</a>
                        
                    </td>

                    <td style="background-color: lightgray;">
                        <a href="tennis.php">Tennis</a>
                    </td>

                    <td style="background-color: lightgray;">
                        <a href="ippica.php">ippica</a>
                    </td>

                    <td style="background-color: lightgreen;">
                        <a href="index.php">Richieste accredito</a>
                    </td>

                    <td style="background-color: lightgreen;">
                        <a href="index.php">Approva scommesse</a>
                    </td>
                    
                    <td style="background-color: lightgreen;">
                        <a href="riepilogo.php">Riepilogo</a>
                    </td>
                    
                    <td style="background-color: lightgreen;">
                        <a href="index.php">Inserisci risultati</a>
                    </td>

                    <!--
                    <td style="background-color: white;">
                        <a href="zonaPagamenti.php">
                            <img src="loghi/cartLogo.png" alt="cart logo" height="20" />
                        </a>
                    </td>
                    -->

                </tr>    
            </tbody>
        </table>
</form>

<?php
        break;
    
        // Utente amministratore loggato
        // --> mostriamo nel menu il bottone per aggiungere film e quello per vedere la lista di utenti registrati al sito
        case "admin":
?>
	
        <table border="1" cellpadding="5" style="border-color: black; margin-left: auto; margin-right: auto;">
            <tbody>
                <tr>
                    <td style="background-color: lightgray;">
                        <a href="index.php">Home</a>
                    </td>

                    <td style="background-color: lightgray;">
                    	<a href="calcio.php"> Calcio </a>

                    </td>

                    <td style="background-color: lightgray;">
                        <a href="basket.php">Basket</a>
                        
                    </td>

                    <td style="background-color: lightgray;">
                        <a href="tennis.php">Tennis</a>
                    </td>

                    <td style="background-color: lightgray;">
                        <a href="ippica.php">ippica</a>
                    </td>

                    <td style="background-color: lightgreen;">
                        <a href="index.php">Richieste accredito</a>
                    </td>

                    <td style="background-color: lightgreen;">
                        <a href="index.php">Approva scommesse</a>
                    </td>
                    
                    <td style="background-color: lightgreen;">
                        <a href="riepilogo.php">Riepilogo</a>
                    </td>
                    
                    <td style="background-color: lightgreen;">
                        <a href="index.php">Inserisci risultati</a>
                    </td>
                    
                    <td style="background-color: lightgreen;">
                        <a href="index.php">Account</a>
                    </td>

                    <!--
                    <td style="background-color: white;">
                        <a href="zonaPagamenti.php">
                            <img src="loghi/cartLogo.png" alt="cart logo" height="20" />
                        </a>
                    </td>
                    -->

                </tr>    
            </tbody>
        </table>
</form>
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
