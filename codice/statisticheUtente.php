<?php

    session_start();

    require_once("./connection.php");

    $scommettitore_selezionato = $_POST['scommettitore'];

    //////////////////////////////////////////////////////////////////////
					
	// Query per ottenere il credito dell'utente selezionato
	$sqlQuery = "SELECT credito from $DBuser_table
	where username = \"$scommettitore_selezionato\"";
	
	$resultQ = mysqli_query($mysqliConnection, $sqlQuery);
	
	if (!$resultQ) {
		printf("Oops! La query inviata non ha avuto successo!\n");
		exit();
	}

	$row=mysqli_fetch_array($resultQ);

    $saldoDisponibile = $row[0];

?>

<?xml version="1.0" encoding="ISO-8859-1"?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
 
	<head>
		<title>Statistiche utente</title>
	<style>
		body {
		font-family: Arial, sans-serif;
		background-color: #f2f2f2;
		margin: 0;
		padding: 0;
		}
		
		header {
		background-color: #333333;
		padding: 10px;
		}
		
		.container {
		max-width: 800px;
		margin: 0 auto;
		padding: 20px;
		}
		
		h1 {
		text-align: center;
		color: #333333;
		}

		h2 {
		text-align: center;
		color: #333333;
		}
		
		p {
		text-align: center;
		color: #666666;
		}
		
		.btn {
		display: block;
		width: 200px;
		margin: 20px auto;
		padding: 10px;
		text-align: center;
		color: #ffffff;
		background-color: #007bff;
		text-decoration: none;
		border-radius: 4px;
		}
		
		.btn:hover {
		background-color: #0056b3;
		}
		
		nav ul {
		list-style-type: none;
		margin: 0;
		padding: 0;
		text-align: center;
		}
		
		nav ul li {
		display: inline-block;
		margin-left: 10px;
		margin-right: 10px;
		}
		
		nav ul li a {
		color: #ffffff;
		text-decoration: none;
		padding: 5px 10px;
		}
		
		nav ul li a:hover {
		background-color: #666666;
		}
		
		.login-btn {
		display: inline-block;
		margin-left: 1px;
		padding: 5px 10px;
		background-color: #ffffff;
		color: #333333;
		border-radius: 4px;
		}
		
		.login-btn:hover {
		background-color: #cccccc;
		}

		.register-btn {
		display: inline-block;
		margin-left: 5px;
		padding: 5px 10px;
		background-color: #007bff;
		color: #ffffff;
		border-radius: 4px;
		}

		.register-btn:hover {
		background-color: #0056b3;
		}

		footer {
		background-color: #333;
		color: #fff;
		padding: 10px;
		text-align: center;
		}

		tr {
			background-color: rgb(228, 240, 245);
			height: 30px;
			text-align: center;
		}

  		td.head{
  		 	background-color: #FDEBD0;
			text-align: center;
  		}

		.tablecenter{
			padding: 10px;
			margin-right: auto;
			margin-left: auto;
			width: 75%;
			padding-bottom: 15px;	
		}

		.link-button {
			background: none;
			border: none;
			color: black;
			cursor: pointer;
			text-decoration: underline;
			font-size: 1em;
			font-family: serif;
		}

  	</style>
		
	</head>

	<body>

		<header>

		<?php 
		// Se non e' stato fatto il login compare il bottone per farlo e anche il bottone per registrarsi
		if(!isset($_SESSION['userName'])){
		
		echo "<div style=\"float: right;\">";
		echo "<a href=\"loginPage.html\" class=\"login-btn\">Login</a>";
		echo "<a href=\"registrazione.php\" class=\"register-btn\">Registrati</a>";
		echo "</div>";
				
		}
		// Se e' stato fatto il login compare il bottone per fare il logout
		else{
		echo "<div style=\"float: right;\">";
		echo "<a href=\"logout.php\" class=\"register-btn\">Logout</a>";
		echo "</div>";
		}
		?>

		<div>
		<table style="margin-left: auto; margin-right: auto;">
			<tbody>
				<tr style="background-color: transparent;">
					<td>
						<a href="inizio.php">
						<img src="loghi/logo.png" alt="Logo del sito" width="128px" height="auto" />
						</a>
					</td>
					<td><h1 style="color: white;">ELDOUBLEUBET</h1></td>
				</tr>
			</tbody>
		</table>
		</div>

        </header>

<?php

    //////////////////////////////////////////////////////////////////////

    // (1) Lettura file fileXML/scommesseUtenti/scommesseCalcio.xml

    $xmlString = "";
        foreach ( file("fileXML/scommesseUtenti/scommesseCalcio.xml") as $node ) {
            $xmlString .= trim($node);
        }

        $doc = new DOMdocument();
        $doc->loadXML($xmlString);
            
        if (!$doc->loadXML($xmlString)) {
            die ("Error mentre si andava parsando il documento\n");
        }

        $scommesseCalcio = $doc->documentElement->childNodes;
        $lunghezza = $scommesseCalcio->length;

        $elenco = "<table class=\"tablecenter\">
    	            <tbody>
                        <tr> 	
                            <td class=\"head\">ID Scommessa</td>
                            <td class=\"head\">ID Partita</td>
                            <td class=\"head\">Risultato giocato</td>
                            <td class=\"head\">Puntata</td>
                            <td class=\"head\">Quota</td>
                            <td class=\"head\">Potenziale Vincita</td>
                            <td class=\"head\">Esito</td>
                            <td class=\"head\">Eliminata</td>
					    </tr>\n";

		$tot_puntate_calcio = 0;
		$tot_vinto_calcio = 0;

        for ($i=0; $i<$lunghezza; $i++) {

			$scommessa = $scommesseCalcio->item($i);

            $e = $scommessa->getAttribute("eliminato");

            if($e=="0") {
                $eliminata = "No";
            }
            elseif($e=="1"){
                $eliminata = "Si";
            }

            // Se una scommessa e' stata pagata allora significa che e' stata vinta
            // --> utilizziamo l'attributo "pagata" per determinare se un utente ha vinto una scommessa oppure no
            $pagata = $scommessa->getAttribute("pagata");
			if($pagata=="1"){
				$esito = "Vinta";
			}
			else {
				$esito = "Persa/Non riscossa";
			}

            // id della partita cui la scommessa fa riferimento
			$idPartita = $scommessa->firstChild;
            $idPartitaValue = $idPartita->textContent;

			$idScommessa = $idPartita->nextSibling;
			$idScommessaValue = $idScommessa->textContent;

			$scommettitore = $idScommessa->nextSibling;
			$scommettitoreValue = $scommettitore->textContent;

			// Verifichiamo che la scommessa sia stata effettuata dall'utente scommettitore selezionato
            if ($scommettitoreValue==$scommettitore_selezionato) {

                // Dati della scommessa piazzata dall'utente
                $risultatoScommesso = $scommettitore->nextSibling;
                $risultatoScommessoValue = $risultatoScommesso->textContent;

                $puntata = $risultatoScommesso->nextSibling;
                $puntataValue = $puntata->textContent;

				$quota = $puntata->nextSibling;
				$quotaValue = $quota->textContent;

				$vincita = $quota->nextSibling;
				$vincitaValue = $vincita->textContent;

                // Utilie per il bilancio finale
                $tot_puntate_calcio = $tot_puntate_calcio + $puntataValue;

                if ($esito == "Vinta") {
                    $tot_vinto_calcio = $tot_vinto_calcio + $vincitaValue;
                }

                // Aggiungiamo la scommessa alla tabella da mostrare
                $elenco.=
                "\n<tr>
                    <td>$idScommessaValue</td>
                    <td>$idPartitaValue</td>
                    <td>$risultatoScommessoValue</td>
                    <td>$puntataValue &euro;</td>
                    <td>$quotaValue</td>
                    <td>$vincitaValue &euro;</td>
                    <td>$esito</td>
                    <td>$eliminata</td>
                </tr>\n
                ";

            }

        }

        $elenco.="</tbody>\n</table>\n";

		$bilancio_calcio = $tot_vinto_calcio - $tot_puntate_calcio;

        $stat_calcio_table = "
        <table class=\"tablecenter\">
    	            <tbody>
                        <tr style=\"color: red;\"> 	
                            <td class=\"head\">Totale speso</td>
                            <td class=\"head\">Totale vinto</td>
                            <td class=\"head\">Bilancio</td>
					    </tr>
                        <tr>
                            <td>$tot_puntate_calcio &euro;</td>
                            <td>$tot_vinto_calcio &euro;</td>
                            <td>$bilancio_calcio &euro;</td>
                        </tr>
                    </tbody>
        </table>\n
        ";

				echo "<h3 style=\"text-align: center;\"><a href=\"riepilogoGestore.php\">Go back</a></h3>";
                echo "<h2>Lista scommesse effettuate dall'utente $scommettitore_selezionato</h2>";
                echo "<hr />";
                echo "<h3 style=\"text-align: center\">Scommesse CALCIO</h3>";
                echo "$elenco";
                echo "$stat_calcio_table";
                echo "<hr />";


    //////////////////////////////////////////////////////////////////////

    // (2) Lettura file fileXML/scommesseUtenti/scommesseBasket.xml

	$xmlString = "";
        foreach ( file("fileXML/scommesseUtenti/scommesseBasket.xml") as $node ) {
            $xmlString .= trim($node);
        }

        $doc = new DOMdocument();
        $doc->loadXML($xmlString);
            
        if (!$doc->loadXML($xmlString)) {
            die ("Error mentre si andava parsando il documento\n");
        }

        $scommesseBasket = $doc->documentElement->childNodes;
        $lunghezza = $scommesseBasket->length;

        $elenco = "<table class=\"tablecenter\">
    	            <tbody>
                        <tr> 	
                            <td class=\"head\">ID Scommessa</td>
                            <td class=\"head\">ID Partita</td>
                            <td class=\"head\">Risultato giocato</td>
                            <td class=\"head\">Puntata</td>
                            <td class=\"head\">Quota</td>
                            <td class=\"head\">Potenziale Vincita</td>
                            <td class=\"head\">Esito</td>
                            <td class=\"head\">Eliminata</td>
					    </tr>\n";

		$tot_puntate_basket = 0;
		$tot_vinto_basket = 0;

        for ($i=0; $i<$lunghezza; $i++) {

			$scommessa = $scommesseBasket->item($i);

            $e = $scommessa->getAttribute("eliminato");

            if($e=="0") {
                $eliminata = "No";
            }
            elseif($e=="1"){
                $eliminata = "Si";
            }

            // Se una scommessa e' stata pagata allora significa che e' stata vinta
            // --> utilizziamo l'attributo "pagata" per determinare se un utente ha vinto una scommessa oppure no
            $pagata = $scommessa->getAttribute("pagata");
			if($pagata=="1"){
				$esito = "Vinta";
			}
			else {
				$esito = "Persa/Non riscossa";
			}

            // id della partita cui la scommessa fa riferimento
			$idPartita = $scommessa->firstChild;
            $idPartitaValue = $idPartita->textContent;

			$idScommessa = $idPartita->nextSibling;
			$idScommessaValue = $idScommessa->textContent;

			$scommettitore = $idScommessa->nextSibling;
			$scommettitoreValue = $scommettitore->textContent;

			// Verifichiamo che la scommessa sia stata effettuata dall'utente scommettitore selezionato
            if ($scommettitoreValue==$scommettitore_selezionato) {

                // Dati della scommessa piazzata dall'utente
                $risultatoScommesso = $scommettitore->nextSibling;
                $risultatoScommessoValue = $risultatoScommesso->textContent;

                $puntata = $risultatoScommesso->nextSibling;
                $puntataValue = $puntata->textContent;

				$quota = $puntata->nextSibling;
				$quotaValue = $quota->textContent;

				$vincita = $quota->nextSibling;
				$vincitaValue = $vincita->textContent;

                // Utilie per il bilancio finale
                $tot_puntate_basket = $tot_puntate_basket + $puntataValue;

                if ($esito == "Vinta") {
                    $tot_vinto_basket = $tot_vinto_basket + $vincitaValue;
                }

                // Aggiungiamo la scommessa alla tabella da mostrare
                $elenco.=
                "\n<tr>
                    <td>$idScommessaValue</td>
                    <td>$idPartitaValue</td>
                    <td>$risultatoScommessoValue</td>
                    <td>$puntataValue &euro;</td>
                    <td>$quotaValue</td>
                    <td>$vincitaValue &euro;</td>
                    <td>$esito</td>
                    <td>$eliminata</td>
                </tr>\n
                ";

            }

        }

        $elenco.="</tbody>\n</table>\n";

		$bilancio_basket = $tot_vinto_basket - $tot_puntate_basket;

        $stat_basket_table = "
        <table class=\"tablecenter\">
    	            <tbody>
                        <tr style=\"color: red;\"> 	
                            <td class=\"head\">Totale speso</td>
                            <td class=\"head\">Totale vinto</td>
                            <td class=\"head\">Bilancio</td>
					    </tr>
                        <tr>
                            <td>$tot_puntate_basket &euro;</td>
                            <td>$tot_vinto_basket &euro;</td>
                            <td>$bilancio_basket &euro;</td>
                        </tr>
                    </tbody>
        </table>\n
        ";

                echo "<h3 style=\"text-align: center\">Scommesse BASKET</h3>";
                echo "$elenco";
                echo "$stat_basket_table";
                echo "<hr />";


    //////////////////////////////////////////////////////////////////////

    // (3) Lettura file fileXML/scommesseUtenti/scommesseTennis.xml

	$xmlString = "";
        foreach ( file("fileXML/scommesseUtenti/scommesseTennis.xml") as $node ) {
            $xmlString .= trim($node);
        }

        $doc = new DOMdocument();
        $doc->loadXML($xmlString);
            
        if (!$doc->loadXML($xmlString)) {
            die ("Error mentre si andava parsando il documento\n");
        }

        $scommesseTennis = $doc->documentElement->childNodes;
        $lunghezza = $scommesseTennis->length;

        $elenco = "<table class=\"tablecenter\">
    	            <tbody>
                        <tr> 	
                            <td class=\"head\">ID Scommessa</td>
                            <td class=\"head\">ID Partita</td>
                            <td class=\"head\">Risultato giocato</td>
                            <td class=\"head\">Puntata</td>
                            <td class=\"head\">Quota</td>
                            <td class=\"head\">Potenziale Vincita</td>
                            <td class=\"head\">Esito</td>
                            <td class=\"head\">Eliminata</td>
					    </tr>\n";

		$tot_puntate_tennis = 0;
		$tot_vinto_tennis = 0;

        for ($i=0; $i<$lunghezza; $i++) {

			$scommessa = $scommesseTennis->item($i);

            $e = $scommessa->getAttribute("eliminato");

            if($e=="0") {
                $eliminata = "No";
            }
            elseif($e=="1"){
                $eliminata = "Si";
            }

            // Se una scommessa e' stata pagata allora significa che e' stata vinta
            // --> utilizziamo l'attributo "pagata" per determinare se un utente ha vinto una scommessa oppure no
            $pagata = $scommessa->getAttribute("pagata");
			if($pagata=="1"){
				$esito = "Vinta";
			}
			else {
				$esito = "Persa/Non riscossa";
			}

            // id della partita cui la scommessa fa riferimento
			$idPartita = $scommessa->firstChild;
            $idPartitaValue = $idPartita->textContent;

			$idScommessa = $idPartita->nextSibling;
			$idScommessaValue = $idScommessa->textContent;

			$scommettitore = $idScommessa->nextSibling;
			$scommettitoreValue = $scommettitore->textContent;

			// Verifichiamo che la scommessa sia stata effettuata dall'utente scommettitore selezionato
            if ($scommettitoreValue==$scommettitore_selezionato) {

                // Dati della scommessa piazzata dall'utente
                $risultatoScommesso = $scommettitore->nextSibling;
                $risultatoScommessoValue = $risultatoScommesso->textContent;

                $puntata = $risultatoScommesso->nextSibling;
                $puntataValue = $puntata->textContent;

				$quota = $puntata->nextSibling;
				$quotaValue = $quota->textContent;

				$vincita = $quota->nextSibling;
				$vincitaValue = $vincita->textContent;

                // Utilie per il bilancio finale
                $tot_puntate_tennis = $tot_puntate_tennis + $puntataValue;

                if ($esito == "Vinta") {
                    $tot_vinto_tennis = $tot_vinto_tennis + $vincitaValue;
                }

                // Aggiungiamo la scommessa alla tabella da mostrare
                $elenco.=
                "\n<tr>
                    <td>$idScommessaValue</td>
                    <td>$idPartitaValue</td>
                    <td>$risultatoScommessoValue</td>
                    <td>$puntataValue &euro;</td>
                    <td>$quotaValue</td>
                    <td>$vincitaValue &euro;</td>
                    <td>$esito</td>
                    <td>$eliminata</td>
                </tr>\n
                ";

            }

        }

        $elenco.="</tbody>\n</table>\n";

		$bilancio_tennis = $tot_vinto_tennis - $tot_puntate_tennis;

        $stat_tennis_table = "
        <table class=\"tablecenter\">
    	            <tbody>
                        <tr style=\"color: red;\"> 	
                            <td class=\"head\">Totale speso</td>
                            <td class=\"head\">Totale vinto</td>
                            <td class=\"head\">Bilancio</td>
					    </tr>
                        <tr>
                            <td>$tot_puntate_tennis &euro;</td>
                            <td>$tot_vinto_tennis &euro;</td>
                            <td>$bilancio_tennis &euro;</td>
                        </tr>
                    </tbody>
        </table>\n
        ";

                echo "<h3 style=\"text-align: center\">Scommesse TENNIS</h3>";
                echo "$elenco";
                echo "$stat_tennis_table";
                echo "<hr />";

    //////////////////////////////////////////////////////////////////////

    // (4) Lettura file fileXML/scommesseUtenti/scommesseIppica.xml

	$xmlString = "";
        foreach ( file("fileXML/scommesseUtenti/scommesseIppica.xml") as $node ) {
            $xmlString .= trim($node);
        }

        $doc = new DOMdocument();
        $doc->loadXML($xmlString);
            
        if (!$doc->loadXML($xmlString)) {
            die ("Error mentre si andava parsando il documento\n");
        }

        $scommesseIppica = $doc->documentElement->childNodes;
        $lunghezza = $scommesseIppica->length;

        $elenco = "<table class=\"tablecenter\">
    	            <tbody>
                        <tr> 	
                            <td class=\"head\">ID Scommessa</td>
                            <td class=\"head\">ID Partita</td>
                            <td class=\"head\">Risultato giocato</td>
                            <td class=\"head\">Puntata</td>
                            <td class=\"head\">Quota</td>
                            <td class=\"head\">Potenziale Vincita</td>
                            <td class=\"head\">Esito</td>
                            <td class=\"head\">Eliminata</td>
					    </tr>\n";

		$tot_puntate_ippica = 0;
		$tot_vinto_ippica = 0;

        for ($i=0; $i<$lunghezza; $i++) {

			$scommessa = $scommesseIppica->item($i);

            $e = $scommessa->getAttribute("eliminato");

            if($e=="0") {
                $eliminata = "No";
            }
            elseif($e=="1"){
                $eliminata = "Si";
            }

            // Se una scommessa e' stata pagata allora significa che e' stata vinta
            // --> utilizziamo l'attributo "pagata" per determinare se un utente ha vinto una scommessa oppure no
            $pagata = $scommessa->getAttribute("pagata");
			if($pagata=="1"){
				$esito = "Vinta";
			}
			else {
				$esito = "Persa/Non riscossa";
			}

            // id della partita cui la scommessa fa riferimento
			$idPartita = $scommessa->firstChild;
            $idPartitaValue = $idPartita->textContent;

			$idScommessa = $idPartita->nextSibling;
			$idScommessaValue = $idScommessa->textContent;

			$scommettitore = $idScommessa->nextSibling;
			$scommettitoreValue = $scommettitore->textContent;

			// Verifichiamo che la scommessa sia stata effettuata dall'utente scommettitore selezionato
            if ($scommettitoreValue==$scommettitore_selezionato) {

                // Dati della scommessa piazzata dall'utente
                $risultatoScommesso = $scommettitore->nextSibling;
				$primo = $risultatoScommesso->firstChild;
				$primoValue = $primo->textContent;
				$secondo = $primo->nextSibling;
				$secondoValue = $secondo->textContent;
				$terzo = $risultatoScommesso->lastChild;
				$terzoValue = $terzo->textContent;
                
				if($primoValue != " ") {
					$risultatoValue = "Cavallo #".$primoValue." arriva 1&deg;";
				}
				elseif ($secondoValue != " ") {
					$risultatoValue = "Cavallo #".$secondoValue." arriva 2&deg;";
				}
				else {
					$risultatoValue = "Cavallo #".$terzoValue." arriva 3&deg;";
				}

                $puntata = $risultatoScommesso->nextSibling;
                $puntataValue = $puntata->textContent;

				$quota = $puntata->nextSibling;
				$quotaValue = $quota->textContent;

				$vincita = $quota->nextSibling;
				$vincitaValue = $vincita->textContent;

                // Utilie per il bilancio finale
                $tot_puntate_ippica = $tot_puntate_ippica + $puntataValue;

                if ($esito == "Vinta") {
                    $tot_vinto_ippica = $tot_vinto_ippica + $vincitaValue;
                }

                // Aggiungiamo la scommessa alla tabella da mostrare
                $elenco.=
                "\n<tr>
                    <td>$idScommessaValue</td>
                    <td>$idPartitaValue</td>
                    <td>$risultatoValue</td>
                    <td>$puntataValue &euro;</td>
                    <td>$quotaValue</td>
                    <td>$vincitaValue &euro;</td>
                    <td>$esito</td>
                    <td>$eliminata</td>
                </tr>\n
                ";

            }

        }

        $elenco.="</tbody>\n</table>\n";

		$bilancio_ippica = $tot_vinto_ippica-$tot_puntate_ippica;

        $stat_ippica_table = "
        <table class=\"tablecenter\">
    	            <tbody>
                        <tr style=\"color: red;\"> 	
                            <td class=\"head\">Totale speso</td>
                            <td class=\"head\">Totale vinto</td>
                            <td class=\"head\">Bilancio</td>
					    </tr>
                        <tr>
                            <td>$tot_puntate_ippica &euro;</td>
                            <td>$tot_vinto_ippica &euro;</td>
                            <td>$bilancio_ippica &euro;</td>
                        </tr>
                    </tbody>
        </table>\n
        ";

                echo "<h3 style=\"text-align: center\">Scommesse IPPICA</h3>";
                echo "$elenco";
                echo "$stat_ippica_table";
                echo "<hr />";

    //////////////////////////////////////////////////////////////////////

	// Statistiche complessive

	$tot_puntate_finale = $tot_puntate_calcio + $tot_puntate_basket + $tot_puntate_tennis + $tot_puntate_ippica;
	$tot_vinto_finale = $tot_vinto_calcio + $tot_vinto_basket + $tot_vinto_tennis + $tot_vinto_ippica;
	$bilancio_finale = $tot_vinto_finale - $tot_puntate_finale;

	$stat_tabella_finale = "
        <table class=\"tablecenter\">
    	            <tbody>
                        <tr> 	
                            <td class=\"head\">Totale speso finale</td>
                            <td class=\"head\">Totale vinto finale</td>
                            <td class=\"head\">Bilancio finale</td>
					    </tr>
                        <tr>
                            <td>$tot_puntate_finale &euro;</td>
                            <td>$tot_vinto_finale &euro;</td>
                            <td>$bilancio_finale &euro;</td>
                        </tr>
                    </tbody>
        </table>\n
        ";
	
	echo "<h3 style=\"text-align: center; color: red\">STATISTICHE</h3>";
	echo "$stat_tabella_finale";
	echo "<hr />";

?>

    <h3 style="text-align: center;"><a href="#top">Back to top</a></h3>

    <footer style="background-color: lightgrey; text-align: center; height: 60px; padding: 20px;">
        <p style="color: black">
            Authors: Francesco Sbordone, Riccardo Tuzzolino
            <br />
            <em><a href="">webmaster@example.com</a></em>
        </p>
    </footer>

    <footer>
        <p style="color: white;">&copy; 2023 Eldoubleubet. Tutti i diritti riservati.</p>
    </footer>

    </body>
    </html>

<?php

    $mysqliConnection->close();

?>
