<?php 

	session_start();
	
	
	switch($_POST['category']){
		
			
			
			
			
		//Mostro proposte scommesse relative al calcio
		case "calcio":
			
			$xml_file_name = "fileXML/proposte/proposteScommessaCalcio.xml";
			$xmlString="";
			foreach ( file("$xml_file_name") as $node ) {
				$xmlString .= trim($node);
			}
		
			$doc = new DOMdocument();
			$doc->loadXML($xmlString);
	

	   		if (!$doc->loadXML($xmlString)) {
				die ("Error mentre si andava parsando il documento\n");
			}
			
			$proposteScommessaCalcio = $doc-> documentElement-> childNodes;
			$lunghezza = $proposteScommessaCalcio->length;



			$elenco = "<tr style=\"background-color: lightgreen\"> 
							<th> ID </th>
							<th> Data Evento </th>
							<th> Ora Inizio</th>
							<th> Ora Fine</th>
							<th> Nome Evento</th>
							<th> Quota 1 </th>
							<th> Quota X </th>
							<th> Quota 2 </th>
							<th> Quota Under </th>
							<th> Quota Over </th>
							<th> Quota GG </th>
							<th> Quota NG </th>
							<th> Utente </th>
							<th> Azione </th>
				
							</tr>\n";


			//ciclo per ottenere info su tutte le proposte di una stessa categoria
			for ($i=0; $i<$lunghezza; $i++) {

				$proposteScommessa = $proposteScommessaCalcio->item($i); //Ë uno dei record
	
				$id = $proposteScommessa->firstChild; //id primo child
				$idNumber = $id->textContent;
		
		
				$nome = $id->nextSibling;  //nome secondo child
				$squadraCasa = $nome->firstChild;
				$squadraCasaValue = $squadraCasa ->textContent;
				$squadraTrasferta = $nome->lastChild;
				$squadraTrasfertaValue = $squadraTrasferta->textContent;
	
				$quotaCalcio = $nome->nextSibling; //quota terzo child
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
	
				$ora = $quotaCalcio->nextSibling; //ora quarto child
				$oraInizio = $ora->firstChild;
				$oraInizioValue = $oraInizio->textContent;
				$oraFine = $ora->lastChild;
				$oraFineValue = $oraFine->textContent;
	
				$data = $ora->nextSibling; //data quinto child
				$giorno = $data->firstChild;
				$giornoValue = $giorno->textContent;
				$mese = $giorno->nextSibling;
				$meseValue = $mese->textContent;
				$anno = $data->lastChild;
				$annoValue = $anno->textContent;
				$anno_mese_giorno = trim($annoValue)."-".trim($meseValue)."-".trim($giornoValue);
				
				$puntata = $data->nextSibling; //puntata sesto figlio
				$minima = $puntata->firstChild;
				$minimaValue = $minima->textContent;
				$massima = $puntata->lastChild;
				$massimaValue = $massima->textContent;
	
				$utente = $proposteScommessa->lastChild;
				$utenteValue = $utente->textContent;


				$elenco.="\n<tr style=\"background-color: white;\">
								<td> $idNumber </td>
								<td> $anno_mese_giorno </td>
								<td> $oraInizioValue </td>
								<td> $oraFineValue </td>
								<td> $squadraCasaValue - $squadraTrasfertaValue </td>
								<td> $quota1Value </td>
								<td> $quotaxValue </td>
								<td> $quota2Value </td>
								<td> $quotaUnderValue </td>
								<td> $quotaOverValue </td>
								<td> $quotaGGValue </td>
								<td> $quotaNGValue </td>
								<td> $utenteValue </td>
								<form method=\"post\" action=\"decisioneApprovaScommessa.php\">
									<input type=\"hidden\" name=\"category\" value=\"calcio\">
									<input type=\"hidden\" name=\"id\" value=\"$idNumber\">
									<input type=\"hidden\" name=\"data\" value=\"$anno_mese_giorno\">
									<input type=\"hidden\" name=\"oraInizio\" value=\"$oraInizioValue\">
									<input type=\"hidden\" name=\"oraFine\" value=\"$oraFineValue\">
									<input type=\"hidden\" name=\"squadraCasa\" value=\"$squadraCasaValue\">
									<input type=\"hidden\" name=\"squadraTrasferta\" value=\"$squadraTrasfertaValue\">
									<input type=\"hidden\" name=\"quota1\" value=\"$quota1Value\">
									<input type=\"hidden\" name=\"quotax\" value=\"$quotaxValue\">
									<input type=\"hidden\" name=\"quota2\" value=\"$quota2Value\">
									<input type=\"hidden\" name=\"quotaUnder\" value=\"$quotaUnderValue\">
									<input type=\"hidden\" name=\"quotaOver\" value=\"$quotaOverValue\">
									<input type=\"hidden\" name=\"quotaGG\" value=\"$quotaGGValue\">
									<input type=\"hidden\" name=\"quotaNG\" value=\"$quotaNGValue\">
									<td> <button type=\"submit\" name=\"accetta\" value=\"submit\" class=\"link-button\"> Accetta </button> 
				   				 	<button type=\"submit\" name=\"rifiuta\" value=\"submit\" class=\"link-button\"> Rifiuta </button> </td>
				   				 </form> </tr>";
		
				}
				$elenco.="</tbody></table>";
			break;
			
			
		//////////////////////////////////////////////
		//Mostro proposte scommesse relative al basket
			
		case "basket":
			$xml_file_name = "fileXML/proposte/proposteScommessaBasket.xml";
			$xmlString="";
			foreach ( file("$xml_file_name") as $node ) {
				$xmlString .= trim($node);
			}
		
			$doc = new DOMdocument();
			$doc->loadXML($xmlString);
	

	   		if (!$doc->loadXML($xmlString)) {
				die ("Error mentre si andava parsando il documento\n");
			}
			
			$proposteScommessaBasket = $doc-> documentElement-> childNodes;
			$lunghezza = $proposteScommessaBasket->length;



			$elenco = "<tr style=\"background-color: lightgreen\"> 
							<th> ID </th>
							<th> Data Evento </th>
							<th> Ora Inizio</th>
							<th> Ora Fine</th>
							<th> Nome Evento</th>
							<th> Quota 1 </th>
							<th> Quota 2 </th>
							<th> Utente </th>
							<th> Azione </th>
							</tr>\n";


			//ciclo per ottenere info su tutte le proposte di una stessa categoria
			for ($i=0; $i<$lunghezza; $i++) {

				$proposteScommessa = $proposteScommessaBasket->item($i); //Ë uno dei record
	
				$id = $proposteScommessa->firstChild; 
				$idNumber = $id->textContent;

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
				$anno_mese_giorno = trim($annoValue)."-".trim($meseValue)."-".trim($giornoValue);
	
				$utente = $proposteScommessa->lastChild;
				$utenteValue = $utente->textContent;


				$elenco.="\n<tr style=\"background-color: white;\">
								<td> $idNumber </td>
								<td> $anno_mese_giorno </td>
								<td> $oraInizioValue </td>
								<td> $oraFineValue </td>
								<td> $squadraCasaValue - $squadraTrasfertaValue </td>
								<td> $quota1Value </td>
								<td> $quota2Value </td>
								<td> $utenteValue </td>
								<form method=\"post\" action=\"decisioneApprovaScommessa.php\">
									<input type=\"hidden\" name=\"category\" value=\"basket\">
									<input type=\"hidden\" name=\"id\" value=\"$idNumber\">
									<input type=\"hidden\" name=\"data\" value=\"$anno_mese_giorno\">
									<input type=\"hidden\" name=\"oraInizio\" value=\"$oraInizioValue\">
									<input type=\"hidden\" name=\"oraFine\" value=\"$oraFineValue\">
									<input type=\"hidden\" name=\"squadraCasa\" value=\"$squadraCasaValue\">
									<input type=\"hidden\" name=\"squadraTrasferta\" value=\"$squadraTrasfertaValue\">
									<input type=\"hidden\" name=\"quota1\" value=\"$quota1Value\">
									<input type=\"hidden\" name=\"quota2\" value=\"$quota2Value\">
									<td> <button type=\"submit\" name=\"accetta\" value=\"submit\" class=\"link-button\"> Accetta </button> 
				   				 	<button type=\"submit\" name=\"rifiuta\" value=\"submit\" class=\"link-button\"> Rifiuta </button> </td>
				   				 </form> </tr>";
				}
				$elenco.="</tbody></table>";
			break;
			
		//////////////////////////////////////////////
		//Mostro proposte scommesse relative al tennis	
		case "tennis":
		
			$xml_file_name = "fileXML/proposte/proposteScommessaTennis.xml";
			$xmlString="";
			foreach ( file("$xml_file_name") as $node ) {
				$xmlString .= trim($node);
			}
		
			$doc = new DOMdocument();
			$doc->loadXML($xmlString);
	

	   		if (!$doc->loadXML($xmlString)) {
				die ("Error mentre si andava parsando il documento\n");
			}
			
			$proposteScommessaTennis = $doc-> documentElement-> childNodes;
			$lunghezza = $proposteScommessaTennis->length;



			$elenco = "<tr style=\"background-color: lightgreen\"> 
							<th> ID </th>
							<th> Data Evento </th>
							<th> Ora Inizio</th>
							<th> Ora Fine</th>
							<th> Nome Evento </th>
							<th> Quota 1 </th>
							<th> Quota 2 </th>
							<th> Utente </th>
							<th> Azione </th>
							</tr>\n";


			//ciclo per ottenere info su tutte le proposte di una stessa categoria
			for ($i=0; $i<$lunghezza; $i++) {

				$proposteScommessa = $proposteScommessaTennis->item($i); //Ë uno dei record
	 
	
				$id = $proposteScommessa->firstChild; 
				$idNumber = $id->textContent;

				$nome = $id->nextSibling;
				$giocatoreCasa = $nome->firstChild;
				$giocatoreCasaValue = $giocatoreCasa->textContent;
				$giocatoreTrasferta = $nome->lastChild;
				$giocatoreTrasfertaValue = $giocatoreTrasferta->textContent;

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
				$anno_mese_giorno = trim($annoValue)."-".trim($meseValue)."-".trim($giornoValue);
	
				$utente = $proposteScommessa->lastChild;
				$utenteValue = $utente->textContent;


				$elenco.="\n<tr style=\"background-color: white;\">
								<td> $idNumber </td>
								<td> $anno_mese_giorno </td>
								<td> $oraInizioValue </td>
								<td> $oraFineValue </td>
								<td> $giocatoreCasaValue - $giocatoreTrasfertaValue </td>
								<td> $quota1Value </td>
								<td> $quota2Value </td>
								<td> $utenteValue </td>
								<form method=\"post\" action=\"decisioneApprovaScommessa.php\">
									<input type=\"hidden\" name=\"category\" value=\"tennis\">
									<input type=\"hidden\" name=\"id\" value=\"$idNumber\">
									<input type=\"hidden\" name=\"data\" value=\"$anno_mese_giorno\">
									<input type=\"hidden\" name=\"oraInizio\" value=\"$oraInizioValue\">
									<input type=\"hidden\" name=\"oraFine\" value=\"$oraFineValue\">
									<input type=\"hidden\" name=\"giocatoreCasa\" value=\"$giocatoreCasaValue\">
									<input type=\"hidden\" name=\"giocatoreTrasferta\" value=\"$giocatoreTrasfertaValue\">
									<input type=\"hidden\" name=\"quota1\" value=\"$quota1Value\">
									<input type=\"hidden\" name=\"quota2\" value=\"$quota2Value\">
									<td> <button type=\"submit\" name=\"accetta\" value=\"submit\" class=\"link-button\"> Accetta </button> 
				   				 	<button type=\"submit\" name=\"rifiuta\" value=\"submit\" class=\"link-button\"> Rifiuta </button> </td>
				   				 </form> </tr>";	
				}
				$elenco.="</tbody></table>";
			break;
			
		//////////////////////////////////////////////
		//Mostro proposte scommesse relative all'ippica
			
		case "ippica":
			$xml_file_name = "fileXML/proposte/proposteScommessaIppica.xml";
			$xmlString="";
			foreach ( file("$xml_file_name") as $node ) {
				$xmlString .= trim($node);
			}
		
			$doc = new DOMdocument();
			$doc->loadXML($xmlString);
	

	   		if (!$doc->loadXML($xmlString)) {
				die ("Error mentre si andava parsando il documento\n");
			}
			
			$proposteScommessaIppica = $doc-> documentElement-> childNodes;
			$lunghezza = $proposteScommessaIppica->length;

			// Costruiamo i titoli delle colonne della tabella che conterra' le scommesse di ippica estratte da ippica.xml
			$elenco = "
			<table class=\"tablecenter\">
				<tbody>
					<tr style=\"background-color: lightgreen\">
					<th > ID </th> 
					<th > Data </th>
					<th > Ora di inizio </th>
					<th > Ora di fine </th>
					<th > Distanza </th>
					<th > Cavalli </th>
					<th > Numero </th>
					<th > 1&deg; posto</th>
					<th > 2&deg; posto </th>
					<th > 3&deg; posto </th>
					<th > Utente </th>
					<th > Azione </th>
					</tr>\n";
						
			//ciclo per ottenere info su tutte le proposte di una stessa categoria
			for ($i=0; $i<$lunghezza; $i++) {

				$proposteScommessa = $proposteScommessaIppica->item($i); //Ë uno dei record
	
	
				$id = $proposteScommessa->firstChild; 
				$idNumber = $id->textContent;

				$data = $id->nextSibling;
				$giorno = $data->firstChild;
				$giornoValue = $giorno->textContent;
				$mese = $giorno->nextSibling;
				$meseValue = $mese->textContent;
				$anno = $data->lastChild;
				$annoValue = $anno->textContent;
				$anno_mese_giorno = trim($annoValue)."-".trim($meseValue)."-".trim($giornoValue);
				
				$ora = $data->nextSibling;
				$oraInizio = $ora->firstChild;
				$oraInizioValue = $oraInizio->textContent;
				$oraFine = $ora->lastChild;
				$oraFineValue = $oraFine->textContent;

				/////////////////////////////////////////////////

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
		

				/////////////////////////////////////////////////

				$distanza = $cavalli->nextSibling;
				$distanzaValue = $distanza->textContent;
				
				$utente = $proposteScommessa->lastChild;
				$utenteValue = $utente->textContent;
				
				// cliccando sulla quota, mi rimanda alla pagina piazzaScommessa.php dove so quale quota ho cliccato e di quale squadra
				$elenco.="\n<tr>
				<td rowspan=\"8\">$idNumber</td>
				<td rowspan=\"8\">$anno_mese_giorno</td>
				<td rowspan=\"8\">$oraInizioValue</td>
				<td rowspan=\"8\">$oraFineValue</td>
				<td rowspan=\"8\">$distanzaValue</td>
				
				<td>$nomeCavallo1Value</td>
				<td>$numeroCavallo1Value</td>
				<td> $quoteCavallo1_quota1Value </td>
				<td> $quoteCavallo1_quota2Value  </td>
				<td> $quoteCavallo1_quota3Value </td>
				
				<td rowspan=\"8\"> $utenteValue</td>
				<td rowspan=\"8\"> 
								<form method=\"post\" action=\"decisioneApprovaScommessa.php\">
									<input type=\"hidden\" name=\"category\" value=\"ippica\">
									<input type=\"hidden\" name=\"id\" value=\"$idNumber\">
									<input type=\"hidden\" name=\"data\" value=\"$anno_mese_giorno\">
									<input type=\"hidden\" name=\"oraInizio\" value=\"$oraInizioValue\">
									<input type=\"hidden\" name=\"oraFine\" value=\"$oraFineValue\">
									<input type=\"hidden\" name=\"distanza\" value=\"$distanzaValue\">
									
									<input type=\"hidden\" name=\"nomePrimo\" value=\"$nomeCavallo1Value\">
									<input type=\"hidden\" name=\"numeroPrimo\" value=\"$numeroCavallo1Value\">
									<input type=\"hidden\" name=\"quotaPrimo1\" value=\"$quoteCavallo1_quota1Value\">
									<input type=\"hidden\" name=\"quotaPrimo2\" value=\"$quoteCavallo1_quota2Value\">
									<input type=\"hidden\" name=\"quotaPrimo3\" value=\"$quoteCavallo1_quota3Value\">
									
									<input type=\"hidden\" name=\"nomeSecondo\" value=\"$nomeCavallo2Value\">
									<input type=\"hidden\" name=\"numeroSecondo\" value=\"$numeroCavallo2Value\">
									<input type=\"hidden\" name=\"quotaSecondo1\" value=\"$quoteCavallo2_quota1Value\">
									<input type=\"hidden\" name=\"quotaSecondo2\" value=\"$quoteCavallo2_quota2Value\">
									<input type=\"hidden\" name=\"quotaSecondo3\" value=\"$quoteCavallo2_quota3Value\">
									
									<input type=\"hidden\" name=\"nomeTerzo\" value=\"$nomeCavallo3Value\">
									<input type=\"hidden\" name=\"numeroTerzo\" value=\"$numeroCavallo3Value\">
									<input type=\"hidden\" name=\"quotaTerzo1\" value=\"$quoteCavallo3_quota1Value\">
									<input type=\"hidden\" name=\"quotaTerzo2\" value=\"$quoteCavallo3_quota2Value\">
									<input type=\"hidden\" name=\"quotaTerzo3\" value=\"$quoteCavallo3_quota3Value\">
									
									<input type=\"hidden\" name=\"nomeQuarto\" value=\"$nomeCavallo4Value\">
									<input type=\"hidden\" name=\"numeroQuarto\" value=\"$numeroCavallo4Value\">
									<input type=\"hidden\" name=\"quotaQuarto1\" value=\"$quoteCavallo4_quota1Value\">
									<input type=\"hidden\" name=\"quotaQuarto2\" value=\"$quoteCavallo4_quota2Value\">
									<input type=\"hidden\" name=\"quotaQuarto3\" value=\"$quoteCavallo4_quota3Value\">
									
									<input type=\"hidden\" name=\"nomeQuinto\" value=\"$nomeCavallo5Value\">
									<input type=\"hidden\" name=\"numeroQuinto\" value=\"$numeroCavallo5Value\">
									<input type=\"hidden\" name=\"quotaQuinto1\" value=\"$quoteCavallo5_quota1Value\">
									<input type=\"hidden\" name=\"quotaQuinto2\" value=\"$quoteCavallo5_quota2Value\">
									<input type=\"hidden\" name=\"quotaQuinto3\" value=\"$quoteCavallo5_quota3Value\">
									
									<input type=\"hidden\" name=\"nomeSesto\" value=\"$nomeCavallo6Value\">
									<input type=\"hidden\" name=\"numeroSesto\" value=\"$numeroCavallo6Value\">
									<input type=\"hidden\" name=\"quotaSesto1\" value=\"$quoteCavallo6_quota1Value\">
									<input type=\"hidden\" name=\"quotaSesto2\" value=\"$quoteCavallo6_quota2Value\">
									<input type=\"hidden\" name=\"quotaSesto3\" value=\"$quoteCavallo6_quota3Value\">
									
									<input type=\"hidden\" name=\"nomeSettimo\" value=\"$nomeCavallo7Value\">
									<input type=\"hidden\" name=\"numeroSettimo\" value=\"$numeroCavallo7Value\">
									<input type=\"hidden\" name=\"quotaSettimo1\" value=\"$quoteCavallo7_quota1Value\">
									<input type=\"hidden\" name=\"quotaSettimo2\" value=\"$quoteCavallo7_quota2Value\">
									<input type=\"hidden\" name=\"quotaSettimo3\" value=\"$quoteCavallo7_quota3Value\">
									
									<input type=\"hidden\" name=\"nomeOttavo\" value=\"$nomeCavallo8Value\">
									<input type=\"hidden\" name=\"numeroOttavo\" value=\"$numeroCavallo8Value\">
									<input type=\"hidden\" name=\"quotaOttavo1\" value=\"$quoteCavallo8_quota1Value\">
									<input type=\"hidden\" name=\"quotaOttavo2\" value=\"$quoteCavallo8_quota2Value\">
									<input type=\"hidden\" name=\"quotaOttavo3\" value=\"$quoteCavallo8_quota3Value\">
									
									 <button type=\"submit\" name=\"accetta\" value=\"submit\" class=\"link-button\"> Accetta </button> 
				   				 	<button type=\"submit\" name=\"rifiuta\" value=\"submit\" class=\"link-button\"> Rifiuta </button> 
				   				 </form> 	</td>
				</tr>\n

				<tr>
		   
			
					<td>$nomeCavallo2Value</td>
					<td>$numeroCavallo2Value</td>
					<td> $quoteCavallo2_quota1Value </td>
					<td> $quoteCavallo2_quota2Value </td>
					<td> $quoteCavallo2_quota3Value </td>
				
				</tr>\n

				<tr>
		   

					<td>$nomeCavallo3Value</td>
					<td>$numeroCavallo3Value</td>
					<td> $quoteCavallo3_quota1Value </td>
					<td> $quoteCavallo3_quota2Value </td>
					<td> $quoteCavallo3_quota3Value </td>
				</tr>\n

				<tr>
		   
		
					<td>$nomeCavallo4Value</td>
					<td>$numeroCavallo4Value</td>
					<td> $quoteCavallo4_quota1Value </td>
					<td> $quoteCavallo4_quota2Value </td>
					<td> $quoteCavallo4_quota3Value </td>
				</tr>\n

				<tr>
		  
	 
					<td>$nomeCavallo5Value</td>
					<td>$numeroCavallo5Value</td>
					<td> $quoteCavallo5_quota1Value </td>
					<td> $quoteCavallo5_quota2Value </td>
					<td> $quoteCavallo5_quota3Value </td>
				</tr>\n

				<tr>
			

					<td>$nomeCavallo6Value</td>
					<td>$numeroCavallo6Value</td>
					<td> $quoteCavallo6_quota1Value </td>
					<td> $quoteCavallo6_quota2Value </td>
					<td> $quoteCavallo6_quota3Value </td>
				</tr>\n

				<tr>
		   

					<td>$nomeCavallo7Value</td>
					<td>$numeroCavallo7Value</td>
					<td> $quoteCavallo7_quota1Value </td>
					<td> $quoteCavallo7_quota2Value </td>
					<td> $quoteCavallo7_quota3Value  </td>
				</tr>\n

				<tr>
		  

					<td>$nomeCavallo8Value</td>
					<td>$numeroCavallo8Value</td>
					<td> $quoteCavallo8_quota1Value </td>
					<td> $quoteCavallo8_quota2Value </td>
					<td> $quoteCavallo8_quota3Value </td>
					<td> </td>
				</tr>\n";	
				}
				$elenco.="</tbody></table>";
			break;
			
	}//fine switch
	
	

	
?> 	


<?xml version="1.0" encoding="ISO-8859-1"?>
<!DOCTYPE movies SYSTEM "movies.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
 
	<head>
		<title> Approva scommessa </title>
		<style>
		

		.tablecenter{
			padding: 10px;
			margin-right: auto;
			margin-left: auto;
			width: 75%;
			padding-bottom: 15px;
            border: 1px solid black;
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
	
			height: 30px;
			text-align:center;
		}
       
  
		</style>
	</head>

	<body >
	<header>
            <div>
                <table style="margin-left: auto; margin-right: auto;">
                    <tbody>
                        <tr>
                            <td><img src="loghi/logo.png" alt="Logo del sito" width="128px" height="auto" /></td>
                            <td><h1 style="color: white;">ELDOUBLEUBET</h1></td>
                        </tr>
                    </tbody>
                </table>
              </div> 
              <?php require_once("./menuConSwitch.php"); ?>           
        </header>
	
	<h3 style="text-align: center">Lista proposte scommesse</h3>
    <table border="1" cellpadding="5" style="border-color: black; margin-left: auto; margin-right: auto;">
    	<tbody>
    	<?php
    		echo("$elenco");
    	?>
    <h3 style="text-align: center;">
            <a href="inizio.php" alt="Home">Homepage</a>
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
