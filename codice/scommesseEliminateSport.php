<?php

session_start();

if(isset($_POST['category'])) {


$sport_selezionato = $_POST['category'];

?>

<?xml version="1.0" encoding="ISO-8859-1"?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
 
	<head>
		<title>Lista scommesse di Calcio</title>
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
	
	    <h2>Scommesse eliminate <?php echo $sport_selezionato; ?> </h2>
	



<?php

    switch($sport_selezionato) {
    
        case 'calcio':

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

            $calcio = $doc-> documentElement-> childNodes;
            $lunghezza_partite_calcio = $calcio->length;

            //ciclo per ottenere info su tutte le scommesse di calcio
            for ($i=0; $i<$lunghezza_partite_calcio; $i++) {
                
                $partita = $calcio->item($i); 

                // L'attributo eliminato ci dice se la scommessa e' stata eliminata oppure no
                $eliminato = $partita->getAttribute("eliminato");

                // Verifichiamo che la partita sia stata eliminata
                if ($eliminato == "1") {
                    // Dati della partita

                    // id rappresenta l'id della partita
                    $id = $partita->firstChild;
                    $idValue = $id->textContent;

                    $nome = $id->nextSibling;  
                    $squadraCasa = $nome->firstChild;
                    $squadraCasaValue = $squadraCasa ->textContent;
                    $squadraTrasferta = $nome->lastChild;
                    $squadraTrasfertaValue = $squadraTrasferta->textContent;
                
                    $quotaCalcio = $nome->nextSibling; 
                    $quota1 = $quotaCalcio->firstChild;
                    $quota1Value = $quota1->textContent;
                    $quotax = $quota1->nextSibling;
                    $quotaxValue = $quotax->textContent;
                    $quota2 = $quotax->nextSibling;
                    $quota2Value = $quota2->textContent;
                    $quotaUnder = $quota2->nextSibling;
                    $quotaUnderValue = $quotaUnder->textContent;
                    $quotaOver = $quotaUnder->nextSibling;
                    $quotaOverValue = $quotaOver->textContent;
                    $quotaGG = $quotaOver->nextSibling;
                    $quotaGGValue = $quotaGG->textContent;
                    $quotaNG = $quotaCalcio->lastChild;
                    $quotaNGValue = $quotaNG->textContent;
                
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

                    #$risultato = $scommessa->lastChild;
                    #$puntiSquadraCasa = $risultato->firstChild;
                    #$puntiSquadraCasaValue = $puntiSquadraCasa->textContent;
                    #$puntiSquadraTrasferta = $risultato->lastChild;
                    #$puntiSquadraTrasfertaValue = $puntiSquadraTrasferta->textContent;

                    $anno_mese_giorno_partita = trim($annoValue)."-".trim($meseValue)."-".trim($giornoValue);

                    // Creazione tabella partita eliminata
                    $tabella_partita_eliminata = "
                    <table class=\"tablecenter\">
                    <tbody>
                    <tr> 	
					<td class=\"head\"> ID Partita</td>
					<td class=\"head\"> Data </td>
					<td class=\"head\"> Ora di inizio </td>
					<td class=\"head\"> Ora di fine </td>
					<td class=\"head\"> Partita </td>
					<td class=\"head\"> 1 </td>
					<td class=\"head\"> X </td>
					<td class=\"head\"> 2 </td>
					<td class=\"head\"> Under 2.5 </td>
					<td class=\"head\"> Over 2.5 </td>
					<td class=\"head\"> GG </td>
					<td class=\"head\"> NG </td>
					</tr>\n";

                    // Aggiunta dati della partita eliminata alla tabella di sopra
                    $tabella_partita_eliminata .= "
                    <tr>
						<td>$idValue</td>
						<td>$anno_mese_giorno_partita</td>
						<td>$oraInizioValue</td>
						<td>$oraFineValue</td>
						<td>$squadraCasaValue - $squadraTrasfertaValue</td>
						<td>$quota1Value</td>
						<td>$quotaxValue</td>
						<td>$quota2Value</td>
						<td>$quotaUnderValue</td>
						<td>$quotaOverValue</td>
						<td>$quotaGGValue</td>
						<td>$quotaNGValue</td>
                    </tr>
                    </tbody>
                    </table>
                    
                    ";

                    // Apriamo il file xml contenente le scommesse di calcio alla ricerca delle scommmesse che fanno riferimento alla partita eliminata
                    ///////////////////////////////////////////////////////////////////////////////
                    $xmlString = "";
                    foreach ( file("fileXML/scommesseUtenti/scommesseCalcio.xml") as $node ) {
                        $xmlString .= trim($node);
                    }

                    $doc = new DOMdocument();
                    $doc->loadXML($xmlString);
                        
                    if (!$doc->loadXML($xmlString)) {
                        die ("Errore mentre si andava parsando il documento\n");
                    }
                    ///////////////////////////////////////////////////////////////////////////////

                    $scommesseCalcio = $doc->documentElement->childNodes;
                    $lunghezza_scommesse_calcio = $scommesseCalcio->length;

                    // Creazione tabella scommesse eliminate
                    $tabella_scommesse_eliminate = "
                    <table class=\"tablecenter\">
                    <tbody>
                    <tr> 	
					<td class=\"head\">ID Partita</td>
					<td class=\"head\">ID Scommessa</td>
					<td class=\"head\">Scommettitore</td>
					<td class=\"head\">Risultato giocato</td>
					<td class=\"head\">Puntata</td>
					<td class=\"head\">Quota</td>
					<td class=\"head\">Potenziale vincita</td>
					</tr>\n";


                    // Cicliamo su tutte le scommesse di calcio selezionando solo quelle che si riferiscono alla partita eliminata di sopra
                    for ($j=0; $j<$lunghezza_scommesse_calcio; $j++) {

                        $scommessa = $scommesseCalcio->item($j);
                        $idPartita = $scommessa->firstChild;
                        $idPartitaValue = $idPartita->textContent;

                        // La scommessa in questione fa riferimento alla partita eliminata
                        if ($idPartitaValue == $idValue) {
                            // Estrazione dati della scommessa eliminata

                            $id_scommessa = $idPartita->nextSibling;
                            $id_scommessa_value = $id_scommessa->textContent;

                            $scommettitore = $id_scommessa->nextSibling;
                            $scommettitoreValue = $scommettitore->textContent;

                            $risultato = $scommettitore->nextSibling;
                            $risultatoValue = $risultato->textContent;

                            $puntata = $risultato->nextSibling;
                            $puntataValue = $puntata->textContent;

                            $quota = $puntata->nextSibling;
                            $quotaValue = $quota->textContent;

                            $vincita = $quota->nextSibling;
                            $vincitaValue = $vincita->textContent;


                            // Aggiunta dati alla tabella delle scommesse eliminate
                            $tabella_scommesse_eliminate .= "
                            <tr>
                                <td>$idPartitaValue</td>
                                <td>$id_scommessa_value</td>
                                <td>$scommettitoreValue</td>
                                <td>$risultatoValue</td>
                                <td>$puntataValue &euro;</td>
                                <td>$quotaValue</td>
                                <td>$vincitaValue &euro;</td>
                            </tr>
                            ";

                        }
                    }

                    // Chiusura tabella scommesse eliminate
                    $tabella_scommesse_eliminate .= "</tbody></table>";

                    // Stampa delle tabelle
                    echo $tabella_partita_eliminata;
                    echo $tabella_scommesse_eliminate;
                    echo "<hr />";

                } // if eliminato == 0

            } // fine for iniziale

            break;

        case 'basket':

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

            $basket = $doc-> documentElement-> childNodes;
            $lunghezza_partite_basket = $basket->length;

            //ciclo per ottenere info su tutte le scommesse di calcio
            for ($i=0; $i<$lunghezza_partite_basket; $i++) {
                
                $partita = $basket->item($i); 

                // L'attributo eliminato ci dice se la scommessa e' stata eliminata oppure no
                $eliminato = $partita->getAttribute("eliminato");

                // Verifichiamo che la partita sia stata eliminata
                if ($eliminato == "1") {
                    // Dati della partita

                    // id rappresenta l'id della partita
                    $id = $partita->firstChild;
                    $idValue = $id->textContent;

                    $nome = $id->nextSibling;  
                    $squadraCasa = $nome->firstChild;
                    $squadraCasaValue = $squadraCasa ->textContent;
                    $squadraTrasferta = $nome->lastChild;
                    $squadraTrasfertaValue = $squadraTrasferta->textContent;
                
                    $quotaBasket = $nome->nextSibling; 
                    $quota1 = $quotaBasket->firstChild;
                    $quota1Value = $quota1->textContent;
                    $quota2 = $quotaBasket->lastChild;
                    $quota2Value = $quota2->textContent;
                
                    $ora = $quotaBasket->nextSibling; 
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

                    #$risultato = $scommessa->lastChild;
                    #$puntiSquadraCasa = $risultato->firstChild;
                    #$puntiSquadraCasaValue = $puntiSquadraCasa->textContent;
                    #$puntiSquadraTrasferta = $risultato->lastChild;
                    #$puntiSquadraTrasfertaValue = $puntiSquadraTrasferta->textContent;

                    $anno_mese_giorno_partita = trim($annoValue)."-".trim($meseValue)."-".trim($giornoValue);

                    // Creazione tabella partita eliminata
                    $tabella_partita_eliminata = "
                    <table class=\"tablecenter\">
                    <tbody>
                    <tr> 	
					<td class=\"head\"> ID Partita</td>
					<td class=\"head\"> Data </td>
					<td class=\"head\"> Ora di inizio </td>
					<td class=\"head\"> Ora di fine </td>
					<td class=\"head\"> Partita </td>
					<td class=\"head\"> 1 </td>
					<td class=\"head\"> 2 </td>
					</tr>\n";

                    // Aggiunta dati della partita eliminata alla tabella di sopra
                    $tabella_partita_eliminata .= "
                    <tr>
						<td>$idValue</td>
						<td>$anno_mese_giorno_partita</td>
						<td>$oraInizioValue</td>
						<td>$oraFineValue</td>
						<td>$squadraCasaValue - $squadraTrasfertaValue</td>
						<td>$quota1Value</td>
						<td>$quota2Value</td>
                    </tr>
                    </tbody>
                    </table>
                    
                    ";

                    // Apriamo il file xml contenente le scommesse di basket alla ricerca delle scommmesse che fanno riferimento alla partita eliminata
                    ///////////////////////////////////////////////////////////////////////////////
                    $xmlString = "";
                    foreach ( file("fileXML/scommesseUtenti/scommesseBasket.xml") as $node ) {
                        $xmlString .= trim($node);
                    }

                    $doc = new DOMdocument();
                    $doc->loadXML($xmlString);
                        
                    if (!$doc->loadXML($xmlString)) {
                        die ("Errore mentre si andava parsando il documento\n");
                    }
                    ///////////////////////////////////////////////////////////////////////////////

                    $scommesseBasket = $doc->documentElement->childNodes;
                    $lunghezza_scommesse_basket = $scommesseBasket->length;

                    // Creazione tabella scommesse eliminate
                    $tabella_scommesse_eliminate = "
                    <table class=\"tablecenter\">
                    <tbody>
                    <tr> 	
					<td class=\"head\">ID Partita</td>
					<td class=\"head\">ID Scommessa</td>
					<td class=\"head\">Scommettitore</td>
					<td class=\"head\">Risultato giocato</td>
					<td class=\"head\">Puntata</td>
					<td class=\"head\">Quota</td>
					<td class=\"head\">Potenziale vincita</td>
					</tr>\n";


                    // Cicliamo su tutte le scommesse di calcio selezionando solo quelle che si riferiscono alla partita eliminata di sopra
                    for ($j=0; $j<$lunghezza_scommesse_basket; $j++) {

                        $scommessa = $scommesseBasket->item($j);
                        $idPartita = $scommessa->firstChild;
                        $idPartitaValue = $idPartita->textContent;

                        // La scommessa in questione fa riferimento alla partita eliminata
                        if ($idPartitaValue == $idValue) {
                            // Estrazione dati della scommessa eliminata

                            $id_scommessa = $idPartita->nextSibling;
                            $id_scommessa_value = $id_scommessa->textContent;

                            $scommettitore = $id_scommessa->nextSibling;
                            $scommettitoreValue = $scommettitore->textContent;

                            $risultato = $scommettitore->nextSibling;
                            $risultatoValue = $risultato->textContent;

                            $puntata = $risultato->nextSibling;
                            $puntataValue = $puntata->textContent;

                            $quota = $puntata->nextSibling;
                            $quotaValue = $quota->textContent;

                            $vincita = $quota->nextSibling;
                            $vincitaValue = $vincita->textContent;


                            // Aggiunta dati alla tabella delle scommesse eliminate
                            $tabella_scommesse_eliminate .= "
                            <tr>
                                <td>$idPartitaValue</td>
                                <td>$id_scommessa_value</td>
                                <td>$scommettitoreValue</td>
                                <td>$risultatoValue</td>
                                <td>$puntataValue &euro;</td>
                                <td>$quotaValue</td>
                                <td>$vincitaValue &euro;</td>
                            </tr>
                            ";

                        }
                    }

                    // Chiusura tabella scommesse eliminate
                    $tabella_scommesse_eliminate .= "</tbody></table>";

                    // Stampa delle tabelle
                    echo $tabella_partita_eliminata;
                    echo $tabella_scommesse_eliminate;
                    echo "<hr />";

                } // if eliminato == 0

            } // fine for iniziale

            break;


        case 'tennis':

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

            $tennis = $doc-> documentElement-> childNodes;
            $lunghezza_partite_tennis = $tennis->length;

            //ciclo per ottenere info su tutte le scommesse di calcio
            for ($i=0; $i<$lunghezza_partite_tennis; $i++) {
                
                $partita = $tennis->item($i); 

                // L'attributo eliminato ci dice se la scommessa e' stata eliminata oppure no
                $eliminato = $partita->getAttribute("eliminato");

                // Verifichiamo che la partita sia stata eliminata
                if ($eliminato == "1") {
                    // Dati della partita

                    // id rappresenta l'id della partita
                    $id = $partita->firstChild;
                    $idValue = $id->textContent;

                    $nome = $id->nextSibling;  
                    $squadraCasa = $nome->firstChild;
                    $squadraCasaValue = $squadraCasa ->textContent;
                    $squadraTrasferta = $nome->lastChild;
                    $squadraTrasfertaValue = $squadraTrasferta->textContent;
                
                    $quotaTennis = $nome->nextSibling; 
                    $quota1 = $quotaTennis->firstChild;
                    $quota1Value = $quota1->textContent;
                    $quota2 = $quotaTennis->lastChild;
                    $quota2Value = $quota2->textContent;
                
                    $ora = $quotaTennis->nextSibling; 
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

                    #$risultato = $scommessa->lastChild;
                    #$puntiSquadraCasa = $risultato->firstChild;
                    #$puntiSquadraCasaValue = $puntiSquadraCasa->textContent;
                    #$puntiSquadraTrasferta = $risultato->lastChild;
                    #$puntiSquadraTrasfertaValue = $puntiSquadraTrasferta->textContent;

                    $anno_mese_giorno_partita = trim($annoValue)."-".trim($meseValue)."-".trim($giornoValue);

                    // Creazione tabella partita eliminata
                    $tabella_partita_eliminata = "
                    <table class=\"tablecenter\">
                    <tbody>
                    <tr> 	
					<td class=\"head\"> ID Partita</td>
					<td class=\"head\"> Data </td>
					<td class=\"head\"> Ora di inizio </td>
					<td class=\"head\"> Ora di fine </td>
					<td class=\"head\"> Partita </td>
					<td class=\"head\"> 1 </td>
					<td class=\"head\"> 2 </td>
					</tr>\n";

                    // Aggiunta dati della partita eliminata alla tabella di sopra
                    $tabella_partita_eliminata .= "
                    <tr>
						<td>$idValue</td>
						<td>$anno_mese_giorno_partita</td>
						<td>$oraInizioValue</td>
						<td>$oraFineValue</td>
						<td>$squadraCasaValue - $squadraTrasfertaValue</td>
						<td>$quota1Value</td>
						<td>$quota2Value</td>
                    </tr>
                    </tbody>
                    </table>
                    
                    ";

                    // Apriamo il file xml contenente le scommesse di tennis alla ricerca delle scommmesse che fanno riferimento alla partita eliminata
                    ///////////////////////////////////////////////////////////////////////////////
                    $xmlString = "";
                    foreach ( file("fileXML/scommesseUtenti/scommesseTennis.xml") as $node ) {
                        $xmlString .= trim($node);
                    }

                    $doc = new DOMdocument();
                    $doc->loadXML($xmlString);
                        
                    if (!$doc->loadXML($xmlString)) {
                        die ("Errore mentre si andava parsando il documento\n");
                    }
                    ///////////////////////////////////////////////////////////////////////////////

                    $scommesseTennis = $doc->documentElement->childNodes;
                    $lunghezza_scommesse_tennis = $scommesseTennis->length;

                    // Creazione tabella scommesse eliminate
                    $tabella_scommesse_eliminate = "
                    <table class=\"tablecenter\">
                    <tbody>
                    <tr> 	
					<td class=\"head\">ID Partita</td>
					<td class=\"head\">ID Scommessa</td>
					<td class=\"head\">Scommettitore</td>
					<td class=\"head\">Risultato giocato</td>
					<td class=\"head\">Puntata</td>
					<td class=\"head\">Quota</td>
					<td class=\"head\">Potenziale vincita</td>
					</tr>\n";


                    // Cicliamo su tutte le scommesse di calcio selezionando solo quelle che si riferiscono alla partita eliminata di sopra
                    for ($j=0; $j<$lunghezza_scommesse_tennis; $j++) {

                        $scommessa = $scommesseTennis->item($j);
                        $idPartita = $scommessa->firstChild;
                        $idPartitaValue = $idPartita->textContent;

                        // La scommessa in questione fa riferimento alla partita eliminata
                        if ($idPartitaValue == $idValue) {
                            // Estrazione dati della scommessa eliminata

                            $id_scommessa = $idPartita->nextSibling;
                            $id_scommessa_value = $id_scommessa->textContent;

                            $scommettitore = $id_scommessa->nextSibling;
                            $scommettitoreValue = $scommettitore->textContent;

                            $risultato = $scommettitore->nextSibling;
                            $risultatoValue = $risultato->textContent;

                            $puntata = $risultato->nextSibling;
                            $puntataValue = $puntata->textContent;

                            $quota = $puntata->nextSibling;
                            $quotaValue = $quota->textContent;

                            $vincita = $quota->nextSibling;
                            $vincitaValue = $vincita->textContent;


                            // Aggiunta dati alla tabella delle scommesse eliminate
                            $tabella_scommesse_eliminate .= "
                            <tr>
                                <td>$idPartitaValue</td>
                                <td>$id_scommessa_value</td>
                                <td>$scommettitoreValue</td>
                                <td>$risultatoValue</td>
                                <td>$puntataValue &euro;</td>
                                <td>$quotaValue</td>
                                <td>$vincitaValue &euro;</td>
                            </tr>
                            ";

                        }
                    }

                    // Chiusura tabella scommesse eliminate
                    $tabella_scommesse_eliminate .= "</tbody></table>";

                    // Stampa delle tabelle
                    echo $tabella_partita_eliminata;
                    echo $tabella_scommesse_eliminate;
                    echo "<hr />";

                } // if eliminato == 0

            } // fine for iniziale
            
            break;

        case 'ippica':
            
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

            $ippica = $doc-> documentElement-> childNodes;
            $lunghezza_partite_ippica = $ippica->length;

            //ciclo per ottenere info su tutte le scommesse ippiche
            for ($i=0; $i<$lunghezza_partite_ippica; $i++) {
                
                $partita = $ippica->item($i); 

                // L'attributo eliminato ci dice se la scommessa e' stata eliminata oppure no
                $eliminato = $partita->getAttribute("eliminato");

                // Verifichiamo che la partita sia stata eliminata
                if ($eliminato == "1") {
                    // Dati della partita

                    // id rappresenta l'id della partita
                    $id = $partita->firstChild;
                    $idValue = $id->textContent;

                    $data = $id->nextSibling;
                    $giorno = $data->firstChild;
                    $giornoValue = $giorno->textContent;
                    $mese = $giorno->nextSibling;
                    $meseValue = $mese->textContent;
                    $anno = $data->lastChild;
                    $annoValue = $anno->textContent;

                    $anno_mese_giorno_partita = trim($annoValue)."-".trim($meseValue)."-".trim($giornoValue);

                    $ora = $data->nextSibling; 
                    $oraInizio = $ora->firstChild;
                    $oraInizioValue = $oraInizio->textContent;
                    $oraFine = $ora->lastChild;
                    $oraFineValue = $oraFine->textContent;

                    $cavalli = $ora->nextSibling;

                    $cavallo1 = $cavalli->firstChild;
                    $nomeCavallo1 = $cavallo1->firstChild;
                    $nomeCavallo1Value = $nomeCavallo1->textContent;
                    $numeroCavallo1 = $nomeCavallo1->nextSibling;
                    $numeroCavallo1Value = $numeroCavallo1->textContent;
                    $quoteCavallo1 = $numeroCavallo1->nextSibling;
                    $quoteCavallo1_quota1 = $quoteCavallo1->firstChild;
                    $quoteCavallo1_quota1Value = $quoteCavallo1_quota1->textContent;
                    $quoteCavallo1_quota2 = $quoteCavallo1_quota1->nextSibling;
                    $quoteCavallo1_quota2Value = $quoteCavallo1_quota2->textContent;
                    $quoteCavallo1_quota3 = $quoteCavallo1->lastChild;
                    $quoteCavallo1_quota3Value = $quoteCavallo1_quota3->textContent;


                    $cavallo2 = $cavallo1->nextSibling;
                    $nomeCavallo2 = $cavallo2->firstChild;
                    $nomeCavallo2Value = $nomeCavallo2->textContent;
                    $numeroCavallo2 = $nomeCavallo2->nextSibling;
                    $numeroCavallo2Value = $numeroCavallo2->textContent;
                    $quoteCavallo2 = $numeroCavallo2->nextSibling;
                    $quoteCavallo2_quota1 = $quoteCavallo2->firstChild;
                    $quoteCavallo2_quota1Value = $quoteCavallo2_quota1->textContent;
                    $quoteCavallo2_quota2 = $quoteCavallo2_quota1->nextSibling;
                    $quoteCavallo2_quota2Value = $quoteCavallo2_quota2->textContent;
                    $quoteCavallo2_quota3 = $quoteCavallo2->lastChild;
                    $quoteCavallo2_quota3Value = $quoteCavallo2_quota3->textContent;

                    $cavallo3 = $cavallo2->nextSibling;
                    $nomeCavallo3 = $cavallo3->firstChild;
                    $nomeCavallo3Value = $nomeCavallo3->textContent;
                    $numeroCavallo3 = $nomeCavallo3->nextSibling;
                    $numeroCavallo3Value = $numeroCavallo3->textContent;
                    $quoteCavallo3 = $numeroCavallo3->nextSibling;
                    $quoteCavallo3_quota1 = $quoteCavallo3->firstChild;
                    $quoteCavallo3_quota1Value = $quoteCavallo3_quota1->textContent;
                    $quoteCavallo3_quota2 = $quoteCavallo3_quota1->nextSibling;
                    $quoteCavallo3_quota2Value = $quoteCavallo3_quota2->textContent;
                    $quoteCavallo3_quota3 = $quoteCavallo3->lastChild;
                    $quoteCavallo3_quota3Value = $quoteCavallo3_quota3->textContent;
                    

                    $cavallo4 = $cavallo3->nextSibling;
                    $nomeCavallo4 = $cavallo4->firstChild;
                    $nomeCavallo4Value = $nomeCavallo4->textContent;
                    $numeroCavallo4 = $nomeCavallo4->nextSibling;
                    $numeroCavallo4Value = $numeroCavallo4->textContent;
                    $quoteCavallo4 = $numeroCavallo4->nextSibling;
                    $quoteCavallo4_quota1 = $quoteCavallo4->firstChild;
                    $quoteCavallo4_quota1Value = $quoteCavallo4_quota1->textContent;
                    $quoteCavallo4_quota2 = $quoteCavallo4_quota1->nextSibling;
                    $quoteCavallo4_quota2Value = $quoteCavallo4_quota2->textContent;
                    $quoteCavallo4_quota3 = $quoteCavallo4->lastChild;
                    $quoteCavallo4_quota3Value = $quoteCavallo4_quota3->textContent;
                    

                    $cavallo5 = $cavallo4->nextSibling;
                    $nomeCavallo5 = $cavallo5->firstChild;
                    $nomeCavallo5Value = $nomeCavallo5->textContent;
                    $numeroCavallo5 = $nomeCavallo5->nextSibling;
                    $numeroCavallo5Value = $numeroCavallo5->textContent;
                    $quoteCavallo5 = $numeroCavallo5->nextSibling;
                    $quoteCavallo5_quota1 = $quoteCavallo5->firstChild;
                    $quoteCavallo5_quota1Value = $quoteCavallo5_quota1->textContent;
                    $quoteCavallo5_quota2 = $quoteCavallo5_quota1->nextSibling;
                    $quoteCavallo5_quota2Value = $quoteCavallo5_quota2->textContent;
                    $quoteCavallo5_quota3 = $quoteCavallo5->lastChild;
                    $quoteCavallo5_quota3Value = $quoteCavallo5_quota3->textContent;
                    

                    $cavallo6 = $cavallo5->nextSibling;
                    $nomeCavallo6 = $cavallo6->firstChild;
                    $nomeCavallo6Value = $nomeCavallo6->textContent;
                    $numeroCavallo6 = $nomeCavallo6->nextSibling;
                    $numeroCavallo6Value = $numeroCavallo6->textContent;
                    $quoteCavallo6 = $numeroCavallo6->nextSibling;
                    $quoteCavallo6_quota1 = $quoteCavallo6->firstChild;
                    $quoteCavallo6_quota1Value = $quoteCavallo6_quota1->textContent;
                    $quoteCavallo6_quota2 = $quoteCavallo6_quota1->nextSibling;
                    $quoteCavallo6_quota2Value = $quoteCavallo6_quota2->textContent;
                    $quoteCavallo6_quota3 = $quoteCavallo6->lastChild;
                    $quoteCavallo6_quota3Value = $quoteCavallo6_quota3->textContent;
                    

                    $cavallo7 = $cavallo6->nextSibling;
                    $nomeCavallo7 = $cavallo7->firstChild;
                    $nomeCavallo7Value = $nomeCavallo7->textContent;
                    $numeroCavallo7 = $nomeCavallo7->nextSibling;
                    $numeroCavallo7Value = $numeroCavallo7->textContent;
                    $quoteCavallo7 = $numeroCavallo7->nextSibling;
                    $quoteCavallo7_quota1 = $quoteCavallo7->firstChild;
                    $quoteCavallo7_quota1Value = $quoteCavallo7_quota1->textContent;
                    $quoteCavallo7_quota2 = $quoteCavallo7_quota1->nextSibling;
                    $quoteCavallo7_quota2Value = $quoteCavallo7_quota2->textContent;
                    $quoteCavallo7_quota3 = $quoteCavallo7->lastChild;
                    $quoteCavallo7_quota3Value = $quoteCavallo7_quota3->textContent;
                

                    $cavallo8 = $cavalli->lastChild;
                    $nomeCavallo8 = $cavallo8->firstChild;
                    $nomeCavallo8Value = $nomeCavallo8->textContent;
                    $numeroCavallo8 = $nomeCavallo8->nextSibling;
                    $numeroCavallo8Value = $numeroCavallo8->textContent;
                    $quoteCavallo8 = $numeroCavallo8->nextSibling;
                    $quoteCavallo8_quota1 = $quoteCavallo8->firstChild;
                    $quoteCavallo8_quota1Value = $quoteCavallo8_quota1->textContent;
                    $quoteCavallo8_quota2 = $quoteCavallo8_quota1->nextSibling;
                    $quoteCavallo8_quota2Value = $quoteCavallo8_quota2->textContent;
                    $quoteCavallo8_quota3 = $quoteCavallo8->lastChild;
                    $quoteCavallo8_quota3Value = $quoteCavallo8_quota3->textContent;

                    $distanza = $cavalli->nextSibling;
                    $distanzaValue = $distanza->textContent;

                    // Creazione tabella partita eliminata
                    $tabella_partita_eliminata = "
                    <table class=\"tablecenter\">
                    <tbody>
                    <tr> 	
					<td class=\"head\"> ID Partita</td>
					<td class=\"head\"> Data </td>
					<td class=\"head\"> Ora di inizio </td>
					<td class=\"head\"> Ora di fine </td>
                    <td class=\"head\"> Cavalli </td>
                    <td class=\"head\"> Numero </td>
					<td class=\"head\"> 1&deg; posto</td>
                    <td class=\"head\"> 2&deg; posto </td>
                    <td class=\"head\"> 3&deg; posto </td>
                    <td class=\"head\"> Distanza </td>
					</tr>\n";

                    // Aggiunta dati della partita eliminata alla tabella di sopra
                    $tabella_partita_eliminata .= "
                    <tr>
						<td>$idValue</td>
						<td>$anno_mese_giorno_partita</td>
						<td>$oraInizioValue</td>
						<td>$oraFineValue</td>
                        <td>$nomeCavallo1Value</td>
                        <td>$numeroCavallo1Value</td>
                        <td>$quoteCavallo1_quota1Value</td>
                        <td>$quoteCavallo1_quota2Value</td>
                        <td>$quoteCavallo1_quota3Value</td>
						<td rowspan=\"8\">$distanzaValue"."m</td>
                    </tr>

                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>$nomeCavallo2Value</td>
                        <td>$numeroCavallo2Value</td>
                        <td>$quoteCavallo2_quota1Value</td>
                        <td>$quoteCavallo2_quota2Value</td>
                        <td>$quoteCavallo2_quota3Value</td>
                    </tr>

                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>$nomeCavallo3Value</td>
                        <td>$numeroCavallo3Value</td>
                        <td>$quoteCavallo3_quota1Value</td>
                        <td>$quoteCavallo3_quota2Value</td>
                        <td>$quoteCavallo3_quota3Value</td>
                    </tr>

                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>$nomeCavallo4Value</td>
                        <td>$numeroCavallo4Value</td>
                        <td>$quoteCavallo4_quota1Value</td>
                        <td>$quoteCavallo4_quota2Value</td>
                        <td>$quoteCavallo4_quota3Value</td>
                    </tr>

                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>$nomeCavallo5Value</td>
                        <td>$numeroCavallo5Value</td>
                        <td>$quoteCavallo5_quota1Value</td>
                        <td>$quoteCavallo5_quota2Value</td>
                        <td>$quoteCavallo5_quota3Value</td>
                    </tr>

                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>$nomeCavallo6Value</td>
                        <td>$numeroCavallo6Value</td>
                        <td>$quoteCavallo6_quota1Value</td>
                        <td>$quoteCavallo6_quota2Value</td>
                        <td>$quoteCavallo6_quota3Value</td>
                    </tr>

                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>$nomeCavallo7Value</td>
                        <td>$numeroCavallo7Value</td>
                        <td>$quoteCavallo7_quota1Value</td>
                        <td>$quoteCavallo7_quota2Value</td>
                        <td>$quoteCavallo7_quota3Value</td>
                    </tr>

                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>$nomeCavallo8Value</td>
                        <td>$numeroCavallo8Value</td>
                        <td>$quoteCavallo8_quota1Value</td>
                        <td>$quoteCavallo8_quota2Value</td>
                        <td>$quoteCavallo8_quota3Value</td>
                    </tr>

                    </tbody>
                    </table>
                    
                    ";

                    // Apriamo il file xml contenente le scommesse ippiche alla ricerca delle scommmesse che fanno riferimento alla partita eliminata
                    ///////////////////////////////////////////////////////////////////////////////
                    $xmlString = "";
                    foreach ( file("fileXML/scommesseUtenti/scommesseIppica.xml") as $node ) {
                        $xmlString .= trim($node);
                    }

                    $doc = new DOMdocument();
                    $doc->loadXML($xmlString);
                        
                    if (!$doc->loadXML($xmlString)) {
                        die ("Errore mentre si andava parsando il documento\n");
                    }
                    ///////////////////////////////////////////////////////////////////////////////

                    $scommesseIppica = $doc->documentElement->childNodes;
                    $lunghezza_scommesse_ippica = $scommesseIppica->length;

                    // Creazione tabella scommesse eliminate
                    $tabella_scommesse_eliminate = "
                    <table class=\"tablecenter\">
                    <tbody>
                    <tr> 	
					<td class=\"head\">ID Partita</td>
					<td class=\"head\">ID Scommessa</td>
					<td class=\"head\">Scommettitore</td>
					<td class=\"head\">Risultato giocato</td>
					<td class=\"head\">Puntata</td>
					<td class=\"head\">Quota</td>
					<td class=\"head\">Potenziale vincita</td>
					</tr>\n";


                    // Cicliamo su tutte le scommesse di calcio selezionando solo quelle che si riferiscono alla partita eliminata di sopra
                    for ($j=0; $j<$lunghezza_scommesse_ippica; $j++) {

                        $scommessa = $scommesseIppica->item($j);
                        $idPartita = $scommessa->firstChild;
                        $idPartitaValue = $idPartita->textContent;

                        // La scommessa in questione fa riferimento alla partita eliminata
                        if ($idPartitaValue == $idValue) {
                            // Estrazione dati della scommessa eliminata

                            $id_scommessa = $idPartita->nextSibling;
                            $id_scommessa_value = $id_scommessa->textContent;

                            $scommettitore = $id_scommessa->nextSibling;
                            $scommettitoreValue = $scommettitore->textContent;

                            $risultato = $scommettitore->nextSibling;
                            $primo = $risultato->firstChild;
                            // Contiene il numero del cavallo che arriva per primo secondo la scommessa
                            $primoValue = $primo->textContent;
                            $secondo = $primo->nextSibling;
                            $secondoValue = $secondo->textContent;
                            $terzo = $risultato->lastChild;
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

                            $puntata = $risultato->nextSibling;
                            $puntataValue = $puntata->textContent;

                            $quota = $puntata->nextSibling;
                            $quotaValue = $quota->textContent;

                            $vincita = $quota->nextSibling;
                            $vincitaValue = $vincita->textContent;


                            // Aggiunta dati alla tabella delle scommesse eliminate
                            $tabella_scommesse_eliminate .= "
                            <tr>
                                <td>$idPartitaValue</td>
                                <td>$id_scommessa_value</td>
                                <td>$scommettitoreValue</td>
                                <td>$risultatoValue</td>
                                <td>$puntataValue &euro;</td>
                                <td>$quotaValue</td>
                                <td>$vincitaValue &euro;</td>
                            </tr>
                            ";

                        }
                    }

                    // Chiusura tabella scommesse eliminate
                    $tabella_scommesse_eliminate .= "</tbody></table>";

                    // Stampa delle tabelle
                    echo $tabella_partita_eliminata;
                    echo $tabella_scommesse_eliminate;
                    echo "<hr />";

                } // if eliminato == 0

            } // fine for iniziale

            break;
    }


} // chiude if(isset()) all'inizio

?>

    <h3 style="text-align: center;">
        <a href="scommesseEliminate.php" alt="back">Go back</a>
    </h3>

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
