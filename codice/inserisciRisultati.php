<?php

    session_start();

    // Leggiamo i file xml contenenti le possibili scommesse e inseriamo i risultati

?>

<?xml version="1.0" encoding="ISO-8859-1"?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
 
	<head>
		<title>Inserisci Risultati</title>
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

        h3 {
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
			text-align:center;
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

		<?php

		// Inserisce il menu' relativo al visitatore oppure all'uetnte loggato (scommettitore, admin oppure gestore)
		require("./menuConSwitch.php");

		?>

		</header>

        <h4 style="text-align: center;">Inserisci il risultato per le partite disponibili</h4>

<?php
/////////////////////////////////////////////////////////////////////////
# Lettura file "calcio.xml"
$xmlString = "";
foreach ( file("fileXML/scommesseDisponibili/calcio.xml") as $node ) {
	$xmlString .= trim($node);
}

    $doc = new DOMdocument();
  	$doc->loadXML($xmlString);
    
    if (!$doc->loadXML($xmlString)) {
  		die ("Error mentre si andava parsando il documento\n");
}
/////////////////////////////////////////////////////////////////////////

    // Verifichiamo che i risultati per quella partita non siano gia' stati inseriti, altrimenti li inseriamo
    $calcio = $doc-> documentElement-> childNodes;
    $lunghezza = $calcio->length;

    // Costruiamo i titoli delle colonne della tabella che conterra' le partite di calcio senza i risultati
	$elenco = "<table class=\"tablecenter\">
                <tbody>
                <tr> 	
                    <td class=\"head\"> ID Partita </td>
                    <td class=\"head\"> Data </td>
                    <td class=\"head\"> Ora di inizio </td>
                    <td class=\"head\"> Ora di fine </td>
                    <td class=\"head\"> Partita </td>
                    <td class=\"head\"> Risultato </td>
                </tr>\n";

    for ($i=0; $i<$lunghezza; $i++) {
	
		$scommessa = $calcio->item($i); //e' uno dei record
        $risultato = $doc->getElementsByTagName('risultato')[$i];

        $puntiSquadraCasa = $risultato->firstChild;
        $puntiSquadraCasaValue = $puntiSquadraCasa->textContent;
        $puntiSquadraTrasferta = $risultato->lastChild;
        $puntiSquadraTrasfertaValue = $puntiSquadraTrasferta->textContent;

        // Se i risultati non sono stati inseriti
        if ($puntiSquadraCasaValue=="" && $puntiSquadraTrasfertaValue=="") {

            $idPartita = $scommessa->firstChild;
            $idPartitaValue = $idPartita->textContent;

            $nome = $idPartita->nextSibling;
            $squadraCasa = $nome->firstChild;
            $squadraTrasferta = $nome->lastChild;
            $squadraCasaValue = $squadraCasa->textContent;
            $squadraTrasfertaValue = $squadraTrasferta->textContent;

            $quotaCalcio = $nome->nextSibling;

            $ora = $quotaCalcio->nextSibling;
            $oraInizio = $ora->firstChild;
            $oraInizioValue = $oraInizio->textContent;
            $oraFine = $ora->lastChild;
            $oraFineValue = $oraFine->textContent;

            $data = $ora->nextSibling;
            $giorno = $data->firstChild;
            $giornoValue = $giorno->textContent;
            $mese = $giorno->nextSibling;
            $meseValue = $mese->textContent;
            $anno = $data->lastChild;
            $annoValue = $anno->textContent;

		    $anno_mese_giorno = trim($annoValue)."-".trim($meseValue)."-".trim($giornoValue);


            $elenco.="\n<tr>
						<td>$idPartitaValue</td>
						<td>$anno_mese_giorno</td>
						<td>$oraInizioValue</td>
						<td>$oraFineValue</td>
						<td>$squadraCasaValue - $squadraTrasfertaValue</td>
						<td>
                            <form method=\"post\" action=\"aggiuntaRisultato.php\"> 
                            <input type=\"text\" name=\"risultato\" value=\"1-2\" minlength=\"3\" maxlength=\"3\" size=\"10\">
                            <button type=\"submit\" name=\"submit\" value=\"submit\" class=\"link-button\">Inserisci</button>
                            <input type=\"hidden\" name=\"category\" value=\"calcio\">
                            <input type=\"hidden\" name=\"idPartita\" value=\"$idPartitaValue\">
                            </form> 
                        </td>
						</tr>\n
                        ";
        }

    }

    $elenco.="</tbody>\n</table>";
    echo "<h3>CALCIO</h3>";
    echo "$elenco";

    /////////////////////////////////////////////////////////////////////////
    # Lettura file "basket.xml"
    $xmlString = "";
    foreach ( file("fileXML/scommesseDisponibili/basket.xml") as $node ) {
        $xmlString .= trim($node);
    }

        $doc = new DOMdocument();
        $doc->loadXML($xmlString);
        
        if (!$doc->loadXML($xmlString)) {
            die ("Error mentre si andava parsando il documento\n");
    }
    /////////////////////////////////////////////////////////////////////////

    // Verifichiamo che i risultati per quella partita non siano gia' stati inseriti, altrimenti li inseriamo
    $basket = $doc-> documentElement-> childNodes;
    $lunghezza = $basket->length;

    // Costruiamo i titoli delle colonne della tabella che conterra' le partite di calcio senza i risultati
    $tab_basket = "<table class=\"tablecenter\">
                <tbody>
                <tr> 	
                    <td class=\"head\"> ID Partita </td>
                    <td class=\"head\"> Data </td>
                    <td class=\"head\"> Ora di inizio </td>
                    <td class=\"head\"> Ora di fine </td>
                    <td class=\"head\"> Partita </td>
                    <td class=\"head\"> Risultato </td>
                </tr>\n";

    for ($i=0; $i<$lunghezza; $i++) {

    $scommessa = $basket->item($i); //e' uno dei record
    $risultato = $doc->getElementsByTagName('risultato')[$i];

    $puntiSquadraCasa = $risultato->firstChild;
    $puntiSquadraCasaValue = $puntiSquadraCasa->textContent;
    $puntiSquadraTrasferta = $risultato->lastChild;
    $puntiSquadraTrasfertaValue = $puntiSquadraTrasferta->textContent;

    // Se i risultati non sono stati inseriti
    if ($puntiSquadraCasaValue=="" && $puntiSquadraTrasfertaValue=="") {

        $idPartita = $scommessa->firstChild;
        $idPartitaValue = $idPartita->textContent;

        $nome = $idPartita->nextSibling;
        $squadraCasa = $nome->firstChild;
        $squadraTrasferta = $nome->lastChild;
        $squadraCasaValue = $squadraCasa->textContent;
        $squadraTrasfertaValue = $squadraTrasferta->textContent;

        $quotaCalcio = $nome->nextSibling;

        $ora = $quotaCalcio->nextSibling;
        $oraInizio = $ora->firstChild;
        $oraInizioValue = $oraInizio->textContent;
        $oraFine = $ora->lastChild;
        $oraFineValue = $oraFine->textContent;

        $data = $ora->nextSibling;
        $giorno = $data->firstChild;
        $giornoValue = $giorno->textContent;
        $mese = $giorno->nextSibling;
        $meseValue = $mese->textContent;
        $anno = $data->lastChild;
        $annoValue = $anno->textContent;

        $anno_mese_giorno = trim($annoValue)."-".trim($meseValue)."-".trim($giornoValue);


        $tab_basket.="\n<tr>
                    <td>$idPartitaValue</td>
                    <td>$anno_mese_giorno</td>
                    <td>$oraInizioValue</td>
                    <td>$oraFineValue</td>
                    <td>$squadraCasaValue - $squadraTrasfertaValue</td>
                    <td>
                        <form method=\"post\" action=\"aggiuntaRisultato.php\"> 
                        <input type=\"text\" name=\"risultato\" value=\"1-2\" minlength=\"3\" maxlength=\"3\" size=\"10\">
                        <button type=\"submit\" name=\"submit\" value=\"submit\" class=\"link-button\">Inserisci</button>
                        <input type=\"hidden\" name=\"category\" value=\"basket\">
                        <input type=\"hidden\" name=\"idPartita\" value=\"$idPartitaValue\">
                        </form> 
                    </td>
                    </tr>\n
                    ";
        }

    }

    $tab_basket.="</tbody>\n</table>";
    echo "<h3>BASKET</h3>";
    echo "$tab_basket";

    /////////////////////////////////////////////////////////////////////////
    # Lettura file "tennis.xml"
    $xmlString = "";
    foreach ( file("fileXML/scommesseDisponibili/tennis.xml") as $node ) {
        $xmlString .= trim($node);
    }

        $doc = new DOMdocument();
        $doc->loadXML($xmlString);
        
        if (!$doc->loadXML($xmlString)) {
            die ("Error mentre si andava parsando il documento\n");
    }
    /////////////////////////////////////////////////////////////////////////

    // Verifichiamo che i risultati per quella partita non siano gia' stati inseriti, altrimenti li inseriamo
    $tennis = $doc-> documentElement-> childNodes;
    $lunghezza = $tennis->length;

    // Costruiamo i titoli delle colonne della tabella che conterra' le partite di calcio senza i risultati
    $tab_tennis = "<table class=\"tablecenter\">
                <tbody>
                <tr> 	
                    <td class=\"head\"> ID Partita </td>
                    <td class=\"head\"> Data </td>
                    <td class=\"head\"> Ora di inizio </td>
                    <td class=\"head\"> Ora di fine </td>
                    <td class=\"head\"> Partita </td>
                    <td class=\"head\"> Risultato </td>
                </tr>\n";

    for ($i=0; $i<$lunghezza; $i++) {

    $scommessa = $tennis->item($i); //e' uno dei record
    $risultato = $doc->getElementsByTagName('risultato')[$i];

    $puntiGiocatoreCasa = $risultato->firstChild;
    $puntiGiocatoreCasaValue = $puntiGiocatoreCasa->textContent;
    $puntiGiocatoreTrasferta = $risultato->lastChild;
    $puntiGiocatoreTrasfertaValue = $puntiGiocatoreTrasferta->textContent;

    // Se i risultati non sono stati inseriti
    if ($puntiGiocatoreCasaValue=="" && $puntiGiocatoreTrasfertaValue=="") {

        $idPartita = $scommessa->firstChild;
        $idPartitaValue = $idPartita->textContent;

        $nome = $idPartita->nextSibling;
        $giocatoreCasa = $nome->firstChild;
        $giocatoreTrasferta = $nome->lastChild;
        $giocatoreCasaValue = $giocatoreCasa->textContent;
        $giocatoreTrasfertaValue = $giocatoreTrasferta->textContent;

        $quotaCalcio = $nome->nextSibling;

        $ora = $quotaCalcio->nextSibling;
        $oraInizio = $ora->firstChild;
        $oraInizioValue = $oraInizio->textContent;
        $oraFine = $ora->lastChild;
        $oraFineValue = $oraFine->textContent;

        $data = $ora->nextSibling;
        $giorno = $data->firstChild;
        $giornoValue = $giorno->textContent;
        $mese = $giorno->nextSibling;
        $meseValue = $mese->textContent;
        $anno = $data->lastChild;
        $annoValue = $anno->textContent;

        $anno_mese_giorno = trim($annoValue)."-".trim($meseValue)."-".trim($giornoValue);


        $tab_tennis.="\n<tr>
                    <td>$idPartitaValue</td>
                    <td>$anno_mese_giorno</td>
                    <td>$oraInizioValue</td>
                    <td>$oraFineValue</td>
                    <td>$giocatoreCasaValue - $giocatoreTrasfertaValue</td>
                    <td>
                        <form method=\"post\" action=\"aggiuntaRisultato.php\"> 
                        <input type=\"text\" name=\"risultato\" value=\"1-2\" minlength=\"3\" maxlength=\"3\" size=\"10\">
                        <button type=\"submit\" name=\"submit\" value=\"submit\" class=\"link-button\">Inserisci</button>
                        <input type=\"hidden\" name=\"category\" value=\"tennis\">
                        <input type=\"hidden\" name=\"idPartita\" value=\"$idPartitaValue\">
                        </form> 
                    </td>
                    </tr>\n
                    ";
        }

    }

    $tab_tennis.="</tbody>\n</table>";
    echo "<h3>TENNIS</h3>";
    echo "$tab_tennis";

    /////////////////////////////////////////////////////////////////////////
    # Lettura file "ippica.xml"
    $xmlString = "";
    foreach ( file("fileXML/scommesseDisponibili/ippica.xml") as $node ) {
        $xmlString .= trim($node);
    }

        $doc = new DOMdocument();
        $doc->loadXML($xmlString);
        
        if (!$doc->loadXML($xmlString)) {
            die ("Error mentre si andava parsando il documento\n");
    }
    /////////////////////////////////////////////////////////////////////////

    // Verifichiamo che i risultati per quella partita non siano gia' stati inseriti, altrimenti li inseriamo
    $ippica = $doc-> documentElement-> childNodes;
    $lunghezza = $ippica->length;

    // Costruiamo i titoli delle colonne della tabella che conterra' le partite di calcio senza i risultati
    $tab_ippica = "<table class=\"tablecenter\">
                <tbody>
                <tr> 	
                    <td class=\"head\"> ID Corsa </td>
                    <td class=\"head\"> Distanza </td>
                    <td class=\"head\"> Data </td>
                    <td class=\"head\"> Ora di inizio </td>
                    <td class=\"head\"> Ora di fine </td>
                    <td class=\"head\"> Risultato </td>
                </tr>\n";

    for ($i=0; $i<$lunghezza; $i++) {

    $scommessa = $ippica->item($i); //e' uno dei record
    $risultato = $doc->getElementsByTagName('risultato')[$i];

    $primo = $risultato->firstChild;
    $secondo = $primo->nextSibling;
    $terzo = $risultato->lastChild;

    $primoValue = $primo->textContent;
    $secondoValue = $secondo->textContent;
    $terzoValue = $terzo->textContent;

    
    // Se i risultati non sono stati inseriti
    if ($primoValue=="" && $secondoValue=="" && $terzoValue=="") {

        $idCorsa = $scommessa->firstChild;
        $idCorsaValue = $idCorsa->textContent;

        $data = $idCorsa->nextSibling;
        $giorno = $data->firstChild;
        $giornoValue = $giorno->textContent;
        $mese = $giorno->nextSibling;
        $meseValue = $mese->textContent;
        $anno = $data->lastChild;
        $annoValue = $anno->textContent;

        $ora = $data->nextSibling;
        $oraInizio = $ora->firstChild;
        $oraInizioValue = $oraInizio->textContent;
        $oraFine = $ora->lastChild;
        $oraFineValue = $oraFine->textContent;

        $cavalli = $ora->nextSibling;

        $distanza = $cavalli->nextSibling;
        $distanzaValue = $distanza->textContent;

        $anno_mese_giorno = trim($annoValue)."-".trim($meseValue)."-".trim($giornoValue);


        $tab_ippica.="\n<tr>
                    <td>$idCorsaValue</td>
                    <td>$distanzaValue</td>
                    <td>$anno_mese_giorno</td>
                    <td>$oraInizioValue</td>
                    <td>$oraFineValue</td>
                    <td>
                        <form method=\"post\" action=\"aggiuntaRisultato.php\"> 
                        <input type=\"text\" name=\"risultato\" value=\"1-2-3\" minlength=\"5\" maxlength=\"5\" size=\"10\">
                        <button type=\"submit\" name=\"submit\" value=\"submit\" class=\"link-button\">Inserisci</button>
                        <input type=\"hidden\" name=\"category\" value=\"ippica\">
                        <input type=\"hidden\" name=\"idCorsa\" value=\"$idCorsaValue\">
                        </form> 
                    </td>
                    </tr>\n
                    ";
        }

    }

    $tab_ippica.="</tbody>\n</table>";
    echo "<h3>IPPICA</h3>";
    echo "$tab_ippica";

?>

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