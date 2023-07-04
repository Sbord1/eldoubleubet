<?php

    session_start();
?>

<?xml version="1.0" encoding="ISO-8859-1"?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
 
	<head>
		<title>Esempi vincite</title>
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

        <h2>Lista scommesse giocate suddivise per sport</h2>

		<h3 style="text-align: center; color: red">Esempi vincite</h3>

        <?php


        ////////////////////////////////////////////////////////////////////////////

        // Lettura file fileXML/scommesseUtenti/scommesseCalcio.xml
		
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
                            <td class=\"head\">ID Partita</td>
                            <td class=\"head\">Data Partita</td>
                            <td class=\"head\">Ora Inizio - Ora Fine</td>
                            <td class=\"head\">Scommettitore</td>
                            <td class=\"head\">Risultato giocato</td>
                            <td class=\"head\">Puntata</td>
                            <td class=\"head\">Quota</td>
                            <td class=\"head\">Potenziale Vincita</td>
                            <td class=\"head\">Stato</td>
                            <td class=\"head\">Esito</td>
					    </tr>\n";

		$tot_puntate = 0;

        for ($i=0; $i<$lunghezza; $i++) {

			$scommessa = $scommesseCalcio->item($i);


			// id della partita cui la scommessa fa riferimento
			$id = $scommessa->firstChild;
            $idValue = $id->textContent;

			$id_scommessa = $id->nextSibling;
			$id_scommessa_value = $id_scommessa->textContent;

			$scommettitore = $id_scommessa->nextSibling;
			$scommettitoreValue = $scommettitore->textContent;

			
           


				// Leggiamo il file xml contenente le partite di calcio per recuperare i dati relativi alla data e all'ora della partita su cui si e' scommesso
				/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
				# Lettura file "calcio.xml"
				$xmlString = "";
				foreach ( file("fileXML/scommesseDisponibili/calcio.xml") as $node ) {
					$xmlString .= trim($node);
				}

				$doc = new DOMdocument();
				$doc->formatOutput = true;
				$doc->loadXML($xmlString);
				
				if (!$doc->loadXML($xmlString)) {
					die ("Error mentre si andava parsando il documento\n");
				}
				/////////////////////////////////////////////////////////////////////////

				$scommesse = $doc->getElementsByTagName('scommessa');

				foreach ($scommesse as $scommessa) {
					$idPartita = $scommessa->firstChild;
					$idPartitaValue = $idPartita->textContent;

					// Controlliamo che l'id della scommessa sia uguale all'id della partita
					// Se sono uguali significa che la scommessa fa riferimento a quella partita
					if($idPartitaValue==$idValue) {
						$nome = $idPartita->nextSibling;
						$quotaCalcio = $nome->nextSibling;

						// Estraggo i dati relativi all'ora della partita
						$ora = $quotaCalcio->nextSibling;
						$oraInizio = $ora->firstChild;
						$oraInizioValue = $oraInizio->textContent;
						$oraFine = $ora->lastChild;
						$oraFineValue = $oraFine->textContent;

						// Estraggo i dati relativi alla data in cui si gioca la partita
						$data = $ora->nextSibling;
						$giorno = $data->firstChild;
						$giornoValue = $giorno->textContent;
						$mese = $giorno->nextSibling;
						$meseValue = $mese->textContent;
						$anno = $data->lastChild;
						$annoValue = $anno->textContent;

						$anno_mese_giorno_partita = trim($annoValue)."-".trim($meseValue)."-".trim($giornoValue);

						////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
						// Verifichiamo se la partita e' terminata confrontando la data e l'ora di fine della partita con la data e l'ora attuali
						$current_date = date("Y-m-d");
						$current_time = date("H:i:s");
						
						if (($current_date >= $anno_mese_giorno_partita) && ($current_time > $oraFineValue)) {
							$stato = "Terminata";
						}
						else {
							$stato = "-";
						}
						////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
						// Se la partita e' terminata, estraiamo il risultato
						if ($stato == "Terminata") {
							$puntata = $data->nextSibling;
							$risultato = $puntata->nextSibling;
							$puntiSquadraCasa = $risultato->firstChild;
							$puntiSquadraCasaValue = $puntiSquadraCasa->textContent;
							$puntiSquadraTrasferta = $risultato->lastChild;
							$puntiSquadraTrasfertaValue = $puntiSquadraTrasferta->textContent;

							// Dati estratti dalla scommessa piazzata dall'utente
							$risultatoScommesso = $scommettitore->nextSibling;
							$risultatoScommessoValue = $risultatoScommesso->textContent;
							

							// Confrontiamo il risultato giocato col risultato effettivo della partita
							$esito = "Persa";
						
							if ($puntiSquadraCasaValue > $puntiSquadraTrasfertaValue) {
								if ($risultatoScommessoValue=="1"){
									$esito = "Vinta";
								}
							}
							if ($puntiSquadraCasaValue < $puntiSquadraTrasfertaValue) {
								if ($risultatoScommessoValue=="2"){
									$esito = "Vinta";
								}
							}
							if ($puntiSquadraCasaValue == $puntiSquadraTrasfertaValue) {
								if ($risultatoScommessoValue=="X"){
									$esito = "Vinta";
								}
							}
							if ($puntiSquadraCasaValue>=1 && $puntiSquadraTrasfertaValue>=1) {
								if ($risultatoScommessoValue=="GG"){
									$esito = "Vinta";
								}
							}
							if (($puntiSquadraCasaValue==0 && $puntiSquadraTrasfertaValue==0) || ($puntiSquadraCasaValue==0 && $puntiSquadraTrasfertaValue>0) || ($puntiSquadraCasaValue>0 && $puntiSquadraTrasfertaValue==0)) {
								if ($risultatoScommessoValue=="NG"){
									$esito = "Vinta";
								}
							}
							if ((int)$puntiSquadraCasaValue+(int)$puntiSquadraTrasfertaValue>=3) {
								if ($risultatoScommessoValue=="Over"){
									$esito = "Vinta";
								}
							}
							if ((int)$puntiSquadraCasaValue+(int)$puntiSquadraTrasfertaValue<=2) {
								if ($risultatoScommessoValue=="Under"){
									$esito = "Vinta";
								}
							}

						}
						// La partita non e' terminata
						else {
							$esito = "In attesa";
						}
						// Dati estratti dalla scommessa piazzata dall'utente
						$risultatoScommesso = $scommettitore->nextSibling;
						$risultatoScommessoValue = $risultatoScommesso->textContent;


						$puntata = $risultatoScommesso->nextSibling;
						$puntataValue = $puntata->textContent;
				
				

						$quota = $puntata->nextSibling;
						$quotaValue = $quota->textContent;

						$vincita = $quota->nextSibling;
						$vincitaValue = $vincita->textContent;
				
				
						break;
					}
				   
            }
           if ($esito == "Vinta"){
           $tot_puntate = $tot_puntate + $puntataValue;
            $elenco.=
                "\n<tr>
                    <td>$idValue</td>
                    <td>$anno_mese_giorno_partita</td>
                    <td>$oraInizioValue - $oraFineValue</td>
                    <td>$scommettitoreValue</td>
                    <td>$risultatoScommessoValue</td>
                    <td>$puntataValue &euro;</td>
                    <td>$quotaValue</td>
                    <td>$vincitaValue &euro;</td>
                    <td>$stato</td>
                    <td>$esito</td>
                </tr>\n
                ";
           }
        } //fine loop
			
        $elenco.="</tbody>\n</table>\n";

		echo "<hr />";
		echo "<h2>CALCIO</h2>";
        echo "$elenco";
		echo "<h3 style=\"text-align: center;\">Totale speso in scommesse di calcio: $tot_puntate &euro;</h3>";
		echo "<hr />";

		
        ////////////////////////////////////////////////////////////
        // Lettura file fileXML/scommesseUtenti/scommesseBasket.xml

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
                            <td class=\"head\">ID Partita</td>
							<td class=\"head\">Data Partita</td>
                            <td class=\"head\">Ora Inizio - Ora Fine</td>
                            <td class=\"head\">Scommettitore</td>
                            <td class=\"head\">Risultato giocato</td>
                            <td class=\"head\">Puntata</td>
                            <td class=\"head\">Quota</td>
                            <td class=\"head\">Potenziale Vincita</td>
                            <td class=\"head\">Stato</td>
                            <td class=\"head\">Esito</td>
					    </tr>\n";

		$tot_puntate = 0;

        for ($i=0; $i<$lunghezza; $i++) {

			$scommessa = $scommesseBasket->item($i);

			// id della partita cui la scommessa fa riferimento
			$id = $scommessa->firstChild;
            $idValue = $id->textContent;

			$id_scommessa = $id->nextSibling;
			$id_scommessa_value = $id_scommessa->textContent;

			$scommettitore = $id_scommessa->nextSibling;
			$scommettitoreValue = $scommettitore->textContent;


				// Leggiamo il file xml contenente le partite di basket per recuperare i dati relativi alla data e all'ora della partita su cui si e' scommesso
				/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
				# Lettura file "basket.xml"
				$xmlString = "";
				foreach ( file("fileXML/scommesseDisponibili/basket.xml") as $node ) {
					$xmlString .= trim($node);
				}

				$doc = new DOMdocument();
				$doc->formatOutput = true;
				$doc->loadXML($xmlString);
				
				if (!$doc->loadXML($xmlString)) {
					die ("Error mentre si andava parsando il documento\n");
				}
				/////////////////////////////////////////////////////////////////////////

				$scommesse = $doc->getElementsByTagName('scommessa');

				foreach ($scommesse as $scommessa) {
					$idPartita = $scommessa->firstChild;
					$idPartitaValue = $idPartita->textContent;

					// Controlliamo che l'id della scommessa sia uguale all'id della partita
					// Se sono uguali significa che la scommessa fa riferimento a quella partita
					if($idPartitaValue==$idValue) {
						$nome = $idPartita->nextSibling;
						$quotaBasket = $nome->nextSibling;

						// Estraggo i dati relativi all'ora della partita
						$ora = $quotaBasket->nextSibling;
						$oraInizio = $ora->firstChild;
						$oraInizioValue = $oraInizio->textContent;
						$oraFine = $ora->lastChild;
						$oraFineValue = $oraFine->textContent;

						// Estraggo i dati relativi alla data in cui si giocs la partita
						$data = $ora->nextSibling;
						$giorno = $data->firstChild;
						$giornoValue = $giorno->textContent;
						$mese = $giorno->nextSibling;
						$meseValue = $mese->textContent;
						$anno = $data->lastChild;
						$annoValue = $anno->textContent;

						$anno_mese_giorno_partita = trim($annoValue)."-".trim($meseValue)."-".trim($giornoValue);

						////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
						// Verifichiamo se la partita e' terminata confrontando la data e l'ora di fine della partita con la data e l'ora attuali
						$current_date = date("Y-m-d");
						$current_time = date("H:i:s");
						
						if (($current_date > $anno_mese_giorno_partita) || (($current_date == $anno_mese_giorno_partita) && ($current_time > $oraFineValue))) {
							$stato = "Terminata";
						}
						else {
							$stato = "-";
						}
						////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
						// Se la partita e' terminata, estraiamo il risultato
						if ($stato == "Terminata") {
							$puntata = $data->nextSibling;
							$risultato = $puntata->nextSibling;
							$puntiSquadraCasa = $risultato->firstChild;
							$puntiSquadraCasaValue = $puntiSquadraCasa->textContent;
							$puntiSquadraTrasferta = $risultato->lastChild;
							$puntiSquadraTrasfertaValue = $puntiSquadraTrasferta->textContent;

							// Dati estratti dalla scommessa piazzata dall'utente
							$risultatoScommesso = $scommettitore->nextSibling;
							$risultatoScommessoValue = $risultatoScommesso->textContent;

							// Confrontiamo il risultato giocato col risultato effettivo della partita
							$esito = "Persa";

							if ($puntiSquadraCasaValue > $puntiSquadraTrasfertaValue) {
								if ($risultatoScommessoValue=="1"){
									$esito = "Vinta";
								}
							}
							if ($puntiSquadraCasaValue < $puntiSquadraTrasfertaValue) {
								if ($risultatoScommessoValue=="2"){
									$esito = "Vinta";
								}
							}
							
						}
						// La partita non e' terminata
						else {
							$esito = "In attesa";
						}
						
						$risultato = $scommettitore->nextSibling;
                		$risultatoValue = $risultato->textContent;

                		$puntata = $risultato->nextSibling;
                		$puntataValue = $puntata->textContent;


						$quota = $puntata->nextSibling;
						$quotaValue = $quota->textContent;

						$vincita = $quota->nextSibling;
						$vincitaValue = $vincita->textContent;

						break;
					}
				}
			
				//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////




			 if ($esito == "Vinta"){
			 $tot_puntate = $tot_puntate + $puntataValue;
                $elenco.=
                "\n<tr>
                    <td>$idValue</td>
					<td>$anno_mese_giorno_partita</td>
                    <td>$oraInizioValue - $oraFineValue</td>
                    <td>$scommettitoreValue</td>
                    <td>$risultatoValue</td>
                    <td>$puntataValue &euro;</td>
                    <td>$quotaValue</td>
                    <td>$vincitaValue &euro;</td>
                    <td>$stato</td>
                    <td>$esito</td>
                </tr>\n
                ";
            }
        }

        $elenco.="</tbody>\n</table>\n";

		echo "<h2>BASKET</h2>";
        echo "$elenco";
		echo "<h3 style=\"text-align: center;\">Totale speso in scommesse di basket: $tot_puntate &euro;</h3>";
		echo "<hr />";
		

		/////////////////////////////////////////////////////////////////////////////////

        // Lettura file fileXML/scommesseUtenti/scommesseTennis.xml

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
                            <td class=\"head\">ID Partita</td>
							<td class=\"head\">Data Partita</td>
                            <td class=\"head\">Ora Inizio - Ora Fine</td>
                            <td class=\"head\">Scommettitore</td>
                            <td class=\"head\">Risultato giocato</td>
                            <td class=\"head\">Puntata</td>
                            <td class=\"head\">Quota</td>
                            <td class=\"head\">Potenziale Vincita</td>
                            <td class=\"head\">Stato</td>
                            <td class=\"head\">Esito</td>
					    </tr>\n";

		$tot_puntate = 0;

        for ($i=0; $i<$lunghezza; $i++) {

			$scommessa = $scommesseTennis->item($i);

			$pagata = $scommessa->getAttribute("pagata");


			// id della partita cui la scommessa fa riferimento
			$id = $scommessa->firstChild;
            $idValue = $id->textContent;

			$id_scommessa = $id->nextSibling;
			$id_scommessa_value = $id_scommessa->textContent;

			$scommettitore = $id_scommessa->nextSibling;
			$scommettitoreValue = $scommettitore->textContent;

				// Leggiamo il file xml contenente le partite di tennis per recuperare i dati relativi alla data e all'ora della partita su cui si e' scommesso
				/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
				# Lettura file "tennis.xml"
				$xmlString = "";
				foreach ( file("fileXML/scommesseDisponibili/tennis.xml") as $node ) {
					$xmlString .= trim($node);
				}

				$doc = new DOMdocument();
				$doc->formatOutput = true;
				$doc->loadXML($xmlString);
				
				if (!$doc->loadXML($xmlString)) {
					die ("Error mentre si andava parsando il documento\n");
				}
				/////////////////////////////////////////////////////////////////////////

				$scommesse = $doc->getElementsByTagName('scommessa');

				foreach ($scommesse as $scommessa) {
					$idPartita = $scommessa->firstChild;
					$idPartitaValue = $idPartita->textContent;

					// Controlliamo che l'id della scommessa sia uguale all'id della partita
					// Se sono uguali significa che la scommessa fa riferimento a quella partita
					if($idPartitaValue==$idValue) {
						$nome = $idPartita->nextSibling;
						$quotaTennis = $nome->nextSibling;

						// Estraggo i dati relativi all'ora della partita
						$ora = $quotaTennis->nextSibling;
						$oraInizio = $ora->firstChild;
						$oraInizioValue = $oraInizio->textContent;
						$oraFine = $ora->lastChild;
						$oraFineValue = $oraFine->textContent;

						// Estraggo i dati relativi alla data in cui si giocs la partita
						$data = $ora->nextSibling;
						$giorno = $data->firstChild;
						$giornoValue = $giorno->textContent;
						$mese = $giorno->nextSibling;
						$meseValue = $mese->textContent;
						$anno = $data->lastChild;
						$annoValue = $anno->textContent;

						$anno_mese_giorno_partita = trim($annoValue)."-".trim($meseValue)."-".trim($giornoValue);

						////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
						// Verifichiamo se la partita e' terminata confrontando la data e l'ora di fine della partita con la data e l'ora attuali
						$current_date = date("Y-m-d");
						$current_time = date("H:i:s");
						
						if (($current_date > $anno_mese_giorno_partita) || (($current_date == $anno_mese_giorno_partita) && ($current_time > $oraFineValue))) {
							$stato = "Terminata";
						}
						else {
							$stato = "-";
						}
						////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
						// Se la partita e' terminata, estraiamo il risultato
						if ($stato == "Terminata") {
							$puntata = $data->nextSibling;
							$risultato = $puntata->nextSibling;
							$puntiSquadraCasa = $risultato->firstChild;
							$puntiSquadraCasaValue = $puntiSquadraCasa->textContent;
							$puntiSquadraTrasferta = $risultato->lastChild;
							$puntiSquadraTrasfertaValue = $puntiSquadraTrasferta->textContent;

							// Dati estratti dalla scommessa piazzata dall'utente
							$risultatoScommesso = $scommettitore->nextSibling;
							$risultatoScommessoValue = $risultatoScommesso->textContent;

							// Confrontiamo il risultato giocato col risultato effettivo della partita
							$esito = "Persa";

							if ($puntiSquadraCasaValue > $puntiSquadraTrasfertaValue) {
								if ($risultatoScommessoValue=="1"){
									$esito = "Vinta";
								}
							}
							if ($puntiSquadraCasaValue < $puntiSquadraTrasfertaValue) {
								if ($risultatoScommessoValue=="2"){
									$esito = "Vinta";
								}
							}
							
						}
						// La partita non e' terminata
						else {
							$esito = "In attesa";
						}
                			$risultato = $scommettitore->nextSibling;
               				$risultatoValue = $risultato->textContent;

                			$puntata = $risultato->nextSibling;
                			$puntataValue = $puntata->textContent;

							$quota = $puntata->nextSibling;
							$quotaValue = $quota->textContent;

							$vincita = $quota->nextSibling;
							$vincitaValue = $vincita->textContent;

						break;
					}
				}
			
				//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

				if ($esito == "Vinta"){
           		$tot_puntate = $tot_puntate + $puntataValue;
                $elenco.=
                "\n<tr>
                    <td>$idValue</td>
					<td>$anno_mese_giorno_partita</td>
                    <td>$oraInizioValue - $oraFineValue</td>
                    <td>$scommettitoreValue</td>
                    <td>$risultatoValue</td>
                    <td>$puntataValue &euro;</td>
                    <td>$quotaValue</td>
					<td>$vincitaValue &euro;</td>
                    <td>$stato</td>
                    <td>$esito</td>
                </tr>\n
                ";
            }
        }

        $elenco.="</tbody>\n</table>\n";

		echo "<h2>TENNIS</h2>";
        echo "$elenco";
		echo "<h3 style=\"text-align: center;\">Totale speso in scommesse di tennis: $tot_puntate &euro;</h3>";
		echo "<hr />";

		/////////////////////////////////////////////////////////////////////////////////

        // Lettura file fileXML/scommesseUtenti/scommesseIppica.xml

		$xmlString = "";
        foreach ( file("fileXML/scommesseUtenti/scommesseIppica.xml") as $node ) {
            $xmlString .= trim($node);
        }

        $doc = new DOMdocument();
        $doc->loadXML($xmlString);
            
        if (!$doc->loadXML($xmlString)) {
            die ("Errore mentre si andava parsando il documento\n");
        }

        $scommesseIppica = $doc->documentElement->childNodes;
        $lunghezza = $scommesseIppica->length;

        $elenco = "<table class=\"tablecenter\">
    	            <tbody>
                        <tr> 	
                            <td class=\"head\">ID Corsa</td>
							<td class=\"head\">Data Corsa</td>
                            <td class=\"head\">Ora Inizio - Ora Fine</td>
                            <td class=\"head\">Scommettitore</td>
                            <td class=\"head\">Risultato giocato</td>
                            <td class=\"head\">Puntata</td>
                            <td class=\"head\">Quota</td>
                            <td class=\"head\">Potenziale Vincita</td>
                            <td class=\"head\">Stato</td>
                            <td class=\"head\">Esito</td>
					    </tr>\n";

		$tot_puntate = 0;

        for ($i=0; $i<$lunghezza; $i++) {

			$scommessa = $scommesseIppica->item($i);


			// id della partita cui la scommessa fa riferimento
			$id = $scommessa->firstChild;
            $idValue = $id->textContent;

			$id_scommessa = $id->nextSibling;
			$id_scommessa_value = $id_scommessa->textContent;

			$scommettitore = $id_scommessa->nextSibling;
			$scommettitoreValue = $scommettitore->textContent;

            

				// Leggiamo il file xml contenente le corse di ippica per recuperare i dati relativi alla data e all'ora della partita su cui si e' scommesso
				/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
				# Lettura file "ippica.xml"
				$xmlString = "";
				foreach ( file("fileXML/scommesseDisponibili/ippica.xml") as $node ) {
					$xmlString .= trim($node);
				}

				$doc = new DOMdocument();
				$doc->formatOutput = true;
				$doc->loadXML($xmlString);
				
				if (!$doc->loadXML($xmlString)) {
					die ("Error mentre si andava parsando il documento\n");
				}
				/////////////////////////////////////////////////////////////////////////

				$scommesse = $doc->getElementsByTagName('scommessa');

				foreach ($scommesse as $scommessa) {
					$idCorsa = $scommessa->firstChild;
					$idCorsaValue = $idCorsa->textContent;

					// Controlliamo che l'id della scommessa sia uguale all'id della partita
					// Se sono uguali significa che la scommessa fa riferimento a quella partita
					if($idCorsaValue==$idValue) {
						$data = $idCorsa->nextSibling;
						$ora = $data->nextSibling;

						// Estraggo i dati relativi all'ora della partita
						$oraInizio = $ora->firstChild;
						$oraInizioValue = $oraInizio->textContent;
						$oraFine = $ora->lastChild;
						$oraFineValue = $oraFine->textContent;

						// Estraggo i dati relativi alla data in cui si giocs la partita
						$giorno = $data->firstChild;
						$giornoValue = $giorno->textContent;
						$mese = $giorno->nextSibling;
						$meseValue = $mese->textContent;
						$anno = $data->lastChild;
						$annoValue = $anno->textContent;

						$anno_mese_giorno_partita = trim($annoValue)."-".trim($meseValue)."-".trim($giornoValue);

						////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
						// Verifichiamo se la partita e' terminata confrontando la data e l'ora di fine della partita con la data e l'ora attuali
						$current_date = date("Y-m-d");
						$current_time = date("H:i:s");
						
						if (($current_date > $anno_mese_giorno_partita) || (($current_date == $anno_mese_giorno_partita) && ($current_time > $oraFineValue))) {
							$stato = "Terminata";
						}
						else {
							$stato = "-";
						}
						////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
						// Se la partita e' terminata, estraiamo il risultato
						if ($stato == "Terminata") {
							$cavalli = $ora->nextSibling;
							$distanza = $cavalli->nextSibling;
							$puntata = $distanza->nextSibling;
							$risultato = $puntata->nextSibling;

							$primo = $risultato->firstChild;
							// # cavallo arrivato per primo
							$primoArrivatoValue = $primo->textContent;
							$secondo = $primo->nextSibling;
							// # cavallo arrivato per secondo
							$secondoArrivatoValue = $secondo->textContent;
							$terzo = $risultato->lastChild;
							// # cavallo arrivato per terzo
							$terzoArrivatoValue = $terzo->textContent;

							// Dati estratti dalla scommessa piazzata dall'utente (file scommesseIppica.xml)
							$risultatoScommesso = $scommettitore->nextSibling;
							$primo = $risultatoScommesso->firstChild;
							// # cavallo scommesso al primo posto
							$primoScommessoValue = $primo->textContent;
							$secondo = $primo->nextSibling;
							// # cavallo scommesso al secondo posto
							$secondoScommessoValue = $secondo->textContent;
							$terzo = $risultatoScommesso->lastChild;
							// # cavallo scommesso al terzo posto
							$terzoScommessoValue = $terzo->textContent;

							// Confrontiamo il risultato giocato col risultato effettivo della partita
							$esito = "Persa";

							if ($primoScommessoValue == $primoArrivatoValue) {
									$esito = "Vinta";
							}
							if ($secondoScommessoValue == $secondoArrivatoValue) {
								$esito = "Vinta";
							}
							if ($terzoScommessoValue == $terzoArrivatoValue) {
								$esito = "Vinta";
							}
							
							
						}
						// La partita non e' terminata
						else {
							$esito = "In attesa";
						}
						
						$risultato = $scommettitore->nextSibling;
                		$primo = $risultato->firstChild;
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


						break;
					}
				}

				if ($esito == "Vinta"){
				$tot_puntate = $tot_puntate + $puntataValue;
                $elenco.=
                "\n<tr>
                    <td>$idValue</td>
					<td>$anno_mese_giorno_partita</td>
					<td>$oraInizioValue - $oraFineValue</td>
                    <td>$scommettitoreValue</td>
                    <td>$risultatoValue</td>
                    <td>$puntataValue &euro;</td>
                    <td>$quotaValue</td>
                    <td>$vincitaValue &euro;</td>
                    <td>$stato</td>
                    <td>$esito</td>
                </tr>\n
                ";
            }
        }

        $elenco.="</tbody>\n</table>\n";

		echo "<h2>IPPICA</h2>";
        echo "$elenco";
		echo "<h3 style=\"text-align: center;\">Totale speso in scommesse ippiche: $tot_puntate &euro;</h3>";
		echo "<hr />";

		/////////////////////////////////////////////////////////////////////////////////

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
