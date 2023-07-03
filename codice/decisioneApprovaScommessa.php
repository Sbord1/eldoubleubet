<?php 
	
		//controllo se ho cliccato il bottone per rifiutare o accettare proposta
		//Se accettata devo inserirla nell'apposito file xml e rimuovere la proposta nel file xml delle proposte
		if (isset($_POST['accetta']) || (isset($_POST['rifiuta']))){
		
		
			switch($_POST['category']){
			
				case "calcio":
				
					//accetto la proposta
					if (isset($_POST['accetta'])){
			
			
						$xml_file_name = "fileXML/scommesseDisponibili/calcio.xml";
						$xmlString="";
						foreach ( file("$xml_file_name") as $node ) {
							$xmlString .= trim($node);
						}
		
						$doc = new DOMdocument();
						$doc->loadXML($xmlString);
	

						if (!$doc->loadXML($xmlString)) {
							die ("Error mentre si andava parsando il documento\n");
						}
				
						$calcio = $doc->documentElement; //root
						$lunghezza = $calcio->childNodes->length;  //lunghezza corrisponde a quante scommesse ci sono
		
						//Ottengo l'id dell'ultimo nodo, questo perchè il nuovo nodo deve avere id+1
						$h1 = $doc->getElementsByTagName("id")[$lunghezza-1]->nodeValue;
						$h1 = $h1 + 1;
		
		
						//Inserisco alla fine la nuova richiesta
						$scommessa = $doc->createElement("scommessa");
				
						$id = $doc->createElement("id","$h1");
						$scommessa->appendChild($id);
		
						$nome = $doc->createElement("nome");  //creo elemento nome
						$squadraCasa = $doc->createElement("squadraCasa", $_POST['squadraCasa']);  
						$nome->appendChild($squadraCasa);
						$squadraTrasferta = $doc->createElement("squadraTrasfera",$_POST['squadraTrasferta']);  
						$nome->appendChild($squadraTrasferta);
						$scommessa->appendChild($nome);
		
		
		
						$quotaCalcio =$doc->createElement("quotaCalcio");  //creo elemento quotaCalcio
						$quota1 = $doc->createElement("quota1", $_POST['quota1']);  
						$quotaCalcio->appendChild($quota1);
						$quotax = $doc->createElement("quotax", $_POST['quotax']);  
						$quotaCalcio->appendChild($quotax);
						$quota2 = $doc->createElement("quota2", $_POST['quota2']);  
						$quotaCalcio->appendChild($quota2);
						$quotaUnder = $doc->createElement("quotaUnder", $_POST['quotaUnder']);  
						$quotaCalcio->appendChild($quotaUnder);
						$quotaOver = $doc->createElement("quotaOver", $_POST['quotaOver']);  
						$quotaCalcio->appendChild($quotaOver);
						$quotaGG = $doc->createElement("quotaGG", $_POST['quotaGG']);  
						$quotaCalcio->appendChild($quotaGG);
						$quotaNG = $doc->createElement("quotaNG", $_POST['quotaNG']);  
						$quotaCalcio->appendChild($quotaNG);
						$scommessa->appendChild($quotaCalcio);
	
	
			
						$ora = $doc->createElement("ora"); //creo elemento ora
						$oraInizio = $doc->createElement("oraInizio",$_POST['oraInizio']);
						$ora->appendChild($oraInizio);
						$oraFine = $doc->createElement("oraFine",$_POST['oraFine']);
						$ora->appendChild($oraFine);
						$scommessa->appendChild($ora);
	
						//calcolo data
						$giornoValue = date("d",strtotime($_POST['data']));
						$meseValue = date("m",strtotime($_POST['data']));
						$annoValue = date("Y",strtotime($_POST['data']));

		
						$data = $doc->createElement("data"); //creo elemento data
						$giorno = $doc->createElement("giorno","$giornoValue");
						$data->appendChild($giorno);
						$mese = $doc->createElement("mese","$meseValue");
						$data->appendChild($mese);
						$anno = $doc->createElement("anno","$annoValue");
						$data->appendChild($anno);
						$scommessa->appendChild($data);
		
	
	
						$puntata = $doc->createElement("puntata"); //creo elemento puntata
						$minima = $doc->createElement("minima","1");
						$puntata->appendChild($minima);
						$massima = $doc->createElement("puntata","9999");
						$puntata->appendChild($massima);
						$scommessa->appendChild($puntata);
	
				
						$risultato = $doc->createElement("risultato");
						$puntiSquadraCasa = $doc ->createElement("puntiSquadraCasa");
						$risultato->appendChild($puntiSquadraCasa);
						$puntiSquadraTrasferta = $doc ->createElement("puntiSquadraTrasferta");
						$risultato->appendChild($puntiSquadraTrasferta);
						$scommessa->appendChild($risultato);
		
		
				
						$calcio->appendChild($scommessa);
	
	

	
						# Salvataggio del file XML
						$doc->save($xml_file_name);
		
			
			
					} //FINE ACCETTA
			
					//ora cancello la proposta
					$xml_file_name = "fileXML/proposte/proposteScommessaCalcio.xml";
					$xmlString="";
					foreach ( file("$xml_file_name") as $node ) {
						$xmlString .= trim($node);
					}
		
					$doc = new DOMdocument();
					$doc->loadXML($xmlString);
					$proposteScommessaCalcio = $doc->documentElement;

					if (!$doc->loadXML($xmlString)) {
						die ("Error mentre si andava parsando il documento\n");
					}
					
					//trovo il nodo in questione
					$lista = $doc->getElementsByTagName("id");
					foreach ($lista as $l){
						if ($l->nodeValue == $_POST['id']){
							$l->parentNode->parentNode->removeChild($l->parentNode);
							}
							
					}
			
					$doc->save($xml_file_name);
					
		
				break;
				
			//////////////////////////////////
			
			case "basket":
				
					//accetto la proposta
					if (isset($_POST['accetta'])){
			
			
						$xml_file_name = "fileXML/scommesseDisponibili/basket.xml";
						$xmlString="";
						foreach ( file("$xml_file_name") as $node ) {
							$xmlString .= trim($node);
						}
		
						$doc = new DOMdocument();
						$doc->loadXML($xmlString);
	

						if (!$doc->loadXML($xmlString)) {
							die ("Error mentre si andava parsando il documento\n");
						}
				
					$basket = $doc->documentElement; //root
					$lunghezza = $basket->childNodes->length;  //lunghezza corrisponde a quante richieste ci sono
		
					//Ottengo l'id dell'ultimo nodo, questo perchè il nuovo nodo deve avere id+1
					$h1 = $doc->getElementsByTagName("id")[$lunghezza-1]->nodeValue;
					$h1 = $h1 + 1;
		
		
					//Inserisco alla fine la nuova richiesta
					$scommessa = $doc->createElement("scommessa");
	
					$id = $doc->createElement("id","$h1"); //creo elemento id
					$scommessa->appendChild($id);
		
		
					$nome = $doc->createElement("nome");  //creo elemento nome
					$squadraCasa = $doc->createElement("squadraCasa", $_POST['squadraCasa']);  
					$nome->appendChild($squadraCasa);
					$squadraTrasferta = $doc->createElement("squadraTrasfera",$_POST['squadraTrasferta']);  
					$nome->appendChild($squadraTrasferta);
					$scommessa->appendChild($nome);
		
		
		
					$quotaBasket =$doc->createElement("quotaBasket");  //creo elemento quotaBasket
					$quota1 = $doc->createElement("quota1", $_POST['quota1']);  
					$quotaBasket->appendChild($quota1);
					$quota2 = $doc->createElement("quota2", $_POST['quota2']);  
					$quotaBasket->appendChild($quota2);
					$scommessa->appendChild($quotaBasket);
	
	
			
					$ora = $doc->createElement("ora"); //creo elemento ora
					$oraInizio = $doc->createElement("oraInizio",$_POST['oraInizio']);
					$ora->appendChild($oraInizio);
					$oraFine = $doc->createElement("oraFine",$_POST['oraFine']);
					$ora->appendChild($oraFine);
					$scommessa->appendChild($ora);
	
					//calcolo data
					$giornoValue = date("d",strtotime($_POST['data']));
					$meseValue = date("m",strtotime($_POST['data']));
					$annoValue = date("Y",strtotime($_POST['data']));

		
					$data = $doc->createElement("data"); //creo elemento data
					$giorno = $doc->createElement("giorno","$giornoValue");
					$data->appendChild($giorno);
					$mese = $doc->createElement("mese","$meseValue");
					$data->appendChild($mese);
					$anno = $doc->createElement("anno","$annoValue");
					$data->appendChild($anno);
					$scommessa->appendChild($data);
		
	
	
					$puntata = $doc->createElement("puntata"); //creo elemento puntata
					$minima = $doc->createElement("minima","1");
					$puntata->appendChild($minima);
					$massima = $doc->createElement("puntata","9999");
					$puntata->appendChild($massima);
					$scommessa->appendChild($puntata);
					
					$risultato = $doc->createElement("risultato");
					$puntiSquadraCasa = $doc ->createElement("puntiSquadraCasa");
					$risultato->appendChild($puntiSquadraCasa);
					$puntiSquadraTrasferta = $doc ->createElement("puntiSquadraTrasferta");
					$risultato->appendChild($puntiSquadraTrasferta);
					$scommessa->appendChild($risultato);
		
				
					$basket->appendChild($scommessa);
	

					# Salvataggio del file XML
					$doc->save($xml_file_name);
			
			
					} //FINE ACCETTA
			
					//ora cancello la proposta
					$xml_file_name = "fileXML/proposte/proposteScommessaBasket.xml";
					$xmlString="";
					foreach ( file("$xml_file_name") as $node ) {
						$xmlString .= trim($node);
					}
		
					$doc = new DOMdocument();
					$doc->loadXML($xmlString);
					$proposteScommessaBasket = $doc->documentElement;

					if (!$doc->loadXML($xmlString)) {
						die ("Error mentre si andava parsando il documento\n");
					}
					
					//trovo il nodo in questione
					$lista = $doc->getElementsByTagName("id");
					foreach ($lista as $l){
						if ($l->nodeValue == $_POST['id']){
							$l->parentNode->parentNode->removeChild($l->parentNode);
							}
							
					}
			
					$doc->save($xml_file_name);
					
		
				break;
				
				//////////////////////////////////
			
			case "tennis":
				
					//accetto la proposta
					if (isset($_POST['accetta'])){
			
			
						$xml_file_name = "fileXML/scommesseDisponibili/tennis.xml";
						$xmlString="";
						foreach ( file("$xml_file_name") as $node ) {
							$xmlString .= trim($node);
						}
		
						$doc = new DOMdocument();
						$doc->loadXML($xmlString);
	

						if (!$doc->loadXML($xmlString)) {
							die ("Error mentre si andava parsando il documento\n");
						}
				
					$tennis = $doc->documentElement; //root
					$lunghezza = $tennis->childNodes->length;  //lunghezza corrisponde a quante richieste ci sono
		
					//Ottengo l'id dell'ultimo nodo, questo perchè il nuovo nodo deve avere id+1
					$h1 = $doc->getElementsByTagName("id")[$lunghezza-1]->nodeValue;
					$h1 = $h1 + 1;
		
		
					//Inserisco alla fine la nuova richiesta
					$scommessa = $doc->createElement("scommessa");
	
					$id = $doc->createElement("id","$h1"); //creo elemento id
					$scommessa->appendChild($id);
		
		
					$nome = $doc->createElement("nome");  //creo elemento nome
					$giocatoreCasa = $doc->createElement("giocatoreCasa", $_POST['giocatoreCasa']);  
					$nome->appendChild($giocatoreCasa);
					$giocatoreTrasferta = $doc->createElement("giocatoreTrasfera",$_POST['giocatoreTrasferta']);  
					$nome->appendChild($giocatoreTrasferta);
					$scommessa->appendChild($nome);
		
		
		
					$quotaTennis =$doc->createElement("quotaTennis");  //creo elemento quotaBasket
					$quota1 = $doc->createElement("quota1", $_POST['quota1']);  
					$quotaTennis->appendChild($quota1);
					$quota2 = $doc->createElement("quota2", $_POST['quota2']);  
					$quotaTennis->appendChild($quota2);
					$scommessa->appendChild($quotaTennis);
	
	
			
					$ora = $doc->createElement("ora"); //creo elemento ora
					$oraInizio = $doc->createElement("oraInizio",$_POST['oraInizio']);
					$ora->appendChild($oraInizio);
					$oraFine = $doc->createElement("oraFine",$_POST['oraFine']);
					$ora->appendChild($oraFine);
					$scommessa->appendChild($ora);
	
					//calcolo data
					$giornoValue = date("d",strtotime($_POST['data']));
					$meseValue = date("m",strtotime($_POST['data']));
					$annoValue = date("Y",strtotime($_POST['data']));

		
					$data = $doc->createElement("data"); //creo elemento data
					$giorno = $doc->createElement("giorno","$giornoValue");
					$data->appendChild($giorno);
					$mese = $doc->createElement("mese","$meseValue");
					$data->appendChild($mese);
					$anno = $doc->createElement("anno","$annoValue");
					$data->appendChild($anno);
					$scommessa->appendChild($data);
		

					$puntata = $doc->createElement("puntata"); //creo elemento puntata
					$minima = $doc->createElement("minima","1");
					$puntata->appendChild($minima);
					$massima = $doc->createElement("puntata","9999");
					$puntata->appendChild($massima);
					$scommessa->appendChild($puntata);
					
					$risultato = $doc->createElement("risultato");
					$puntiGiocatoreCasa = $doc ->createElement("puntiGiocatoreCasa");
					$risultato->appendChild($puntiGiocatoreCasa);
					$puntiGiocatoreTrasferta = $doc ->createElement("puntiGiocatoreTrasferta");
					$risultato->appendChild($puntiGiocatoreTrasferta);
					$scommessa->appendChild($risultato);
		
				
					$tennis->appendChild($scommessa);
	

					# Salvataggio del file XML
					$doc->save($xml_file_name);
			
			
					} //FINE ACCETTA
			
					//ora cancello la proposta
					$xml_file_name = "fileXML/proposte/proposteScommessaTennis.xml";
					$xmlString="";
					foreach ( file("$xml_file_name") as $node ) {
						$xmlString .= trim($node);
					}
		
					$doc = new DOMdocument();
					$doc->loadXML($xmlString);
					$proposteScommessaTennis = $doc->documentElement;

					if (!$doc->loadXML($xmlString)) {
						die ("Error mentre si andava parsando il documento\n");
					}
					
					//trovo il nodo in questione
					$lista = $doc->getElementsByTagName("id");
					foreach ($lista as $l){
						if ($l->nodeValue == $_POST['id']){
							$l->parentNode->parentNode->removeChild($l->parentNode);
							}
							
					}
			
					$doc->save($xml_file_name);
					
		
				break;
				
				//////////////////////////////////
			
			case "ippica":
				
					//accetto la proposta
					if (isset($_POST['accetta'])){
			
			
						$xml_file_name = "fileXML/scommesseDisponibili/ippica.xml";
						$xmlString="";
						foreach ( file("$xml_file_name") as $node ) {
							$xmlString .= trim($node);
						}
		
						$doc = new DOMdocument();
						$doc->loadXML($xmlString);
	

						if (!$doc->loadXML($xmlString)) {
							die ("Error mentre si andava parsando il documento\n");
						}
				
					$ippica = $doc->documentElement; //root
		$lunghezza = $ippica->childNodes->length;  //lunghezza corrisponde a quante richieste ci sono
	
		//Ottengo l'id dell'ultimo nodo, questo perchè il nuovo nodo deve avere id+1
		$h1 = $doc->getElementsByTagName("id")[$lunghezza-1]->nodeValue;
		$h1 = $h1 + 1;
		
		
		//Inserisco alla fine la nuova richiesta
		$scommessa = $doc->createElement("scommessa");
	
		$id = $doc->createElement("id","$h1"); //creo elemento id
		$scommessa->appendChild($id);
		
		//calcolo data
		$giornoValue = date("d",strtotime($_POST['data']));
		$meseValue = date("m",strtotime($_POST['data']));
		$annoValue = date("Y",strtotime($_POST['data']));
		
		
		$data = $doc->createElement("data"); //creo elemento data
		$giorno = $doc->createElement("giorno","$giornoValue");
		$data->appendChild($giorno);
		$mese = $doc->createElement("mese","$meseValue");
		$data->appendChild($mese);
		$anno = $doc->createElement("anno","$annoValue");
		$data->appendChild($anno);
		$scommessa->appendChild($data);
		
			
		$ora = $doc->createElement("ora"); //creo elemento ora
		$oraInizio = $doc->createElement("oraInizio",$_POST['oraInizio']);
		$ora->appendChild($oraInizio);
		$oraFine = $doc->createElement("oraFine",$_POST['oraFine']);
		$ora->appendChild($oraFine);
		$scommessa->appendChild($ora);
	
	
		$cavalli = $doc->createElement("cavalli"); //creo elemento cavalli
		
			$cavalloPrimo = $doc->CreateElement("cavallo"); //primo cavallo
				$nomePrimo = $doc->createElement("nome",$_POST['nomePrimo']);
				$cavalloPrimo->appendChild($nomePrimo);
				$numeroPrimo = $doc->createElement("numero",$_POST['numeroPrimo']);
				$cavalloPrimo->appendChild($numeroPrimo);
				$quotePrimo = $doc->createElement("quote");
					$quotaPrimo1 = $doc->createElement("quota1",$_POST['quotaPrimo1']);
					$quotePrimo->appendChild($quotaPrimo1);
					$quotaPrimo2 = $doc->createElement("quota2",$_POST['quotaPrimo2']);
					$quotePrimo->appendChild($quotaPrimo2);
					$quotaPrimo3 = $doc->createElement("quota3",$_POST['quotaPrimo3']);
					$quotePrimo->appendChild($quotaPrimo3);
				$cavalloPrimo->appendChild($quotePrimo);
			$cavalli->appendChild($cavalloPrimo);

			
			$cavalloSecondo = $doc->CreateElement("cavallo"); //secondo cavallo
				$nomeSecondo = $doc->createElement("nome",$_POST['nomeSecondo']);
				$cavalloSecondo->appendChild($nomeSecondo);
				$numeroSecondo = $doc->createElement("numero",$_POST['numeroSecondo']);
				$cavalloSecondo->appendChild($numeroSecondo);				
				$quoteSecondo = $doc->createElement("quote");
					$quotaSecondo1 = $doc->createElement("quota1",$_POST['quotaSecondo1']);
					$quoteSecondo->appendChild($quotaSecondo1);
					$quotaSecondo2 = $doc->createElement("quota2",$_POST['quotaSecondo2']);
					$quoteSecondo->appendChild($quotaSecondo2);
					$quotaSecondo3 = $doc->createElement("quota3",$_POST['quotaSecondo3']);
					$quoteSecondo->appendChild($quotaSecondo3);
				$cavalloSecondo->appendChild($quoteSecondo);
			$cavalli->appendChild($cavalloSecondo);
			
			$cavalloTerzo = $doc->CreateElement("cavallo"); //terzo cavallo
				$nomeTerzo = $doc->createElement("nome",$_POST['nomeTerzo']);
				$cavalloTerzo->appendChild($nomeTerzo);
				$numeroTerzo = $doc->createElement("numero",$_POST['numeroTerzo']);
				$cavalloTerzo->appendChild($numeroTerzo);
				$quoteTerzo = $doc->createElement("quote");
					$quotaTerzo1 = $doc->createElement("quota1",$_POST['quotaTerzo1']);
					$quoteTerzo->appendChild($quotaTerzo1);
					$quotaTerzo2 = $doc->createElement("quota2",$_POST['quotaTerzo2']);
					$quoteTerzo->appendChild($quotaTerzo2);
					$quotaTerzo3 = $doc->createElement("quota3",$_POST['quotaTerzo3']);
					$quoteTerzo->appendChild($quotaTerzo3);
				$cavalloTerzo->appendChild($quoteTerzo);
			$cavalli->appendChild($cavalloTerzo);
			
			$cavalloQuarto = $doc->CreateElement("cavallo"); //quarto cavallo
				$nomeQuarto = $doc->createElement("nome",$_POST['nomeQuarto']);
				$cavalloQuarto->appendChild($nomeQuarto);
				$numeroQuarto = $doc->createElement("numero",$_POST['numeroQuarto']);
				$cavalloQuarto->appendChild($numeroQuarto);
				$quoteQuarto = $doc->createElement("quote");
					$quotaQuarto1 = $doc->createElement("quota1",$_POST['quotaQuarto1']);
					$quoteQuarto->appendChild($quotaQuarto1);
					$quotaQuarto2 = $doc->createElement("quota2",$_POST['quotaQuarto2']);
					$quoteQuarto->appendChild($quotaQuarto2);
					$quotaQuarto3 = $doc->createElement("quota3",$_POST['quotaQuarto3']);
					$quoteQuarto->appendChild($quotaQuarto3);
				$cavalloQuarto->appendChild($quoteQuarto);
			$cavalli->appendChild($cavalloQuarto);
			
			$cavalloQuinto = $doc->CreateElement("cavallo"); //quinto cavallo
				$nomeQuinto = $doc->createElement("nome",$_POST['nomeQuinto']);
				$cavalloQuinto->appendChild($nomeQuinto);
				$numeroQuinto = $doc->createElement("numero",$_POST['numeroQuinto']);
				$cavalloQuinto->appendChild($numeroQuinto);
				$quoteQuinto = $doc->createElement("quote");
					$quotaQuinto1 = $doc->createElement("quota1",$_POST['quotaQuinto1']);
					$quoteQuinto->appendChild($quotaQuinto1);
					$quotaQuinto2 = $doc->createElement("quota2",$_POST['quotaQuinto2']);
					$quoteQuinto->appendChild($quotaQuinto2);
					$quotaQuinto3 = $doc->createElement("quota3",$_POST['quotaQuinto3']);
					$quoteQuinto->appendChild($quotaQuinto3);
				$cavalloQuinto->appendChild($quoteQuinto);
			$cavalli->appendChild($cavalloQuinto);
			
			$cavalloSesto = $doc->CreateElement("cavallo"); //sesto cavallo
				$nomeSesto = $doc->createElement("nome",$_POST['nomeSesto']);
				$cavalloSesto->appendChild($nomeSesto);
				$numeroSesto = $doc->createElement("numero",$_POST['numeroSesto']);
				$cavalloSesto->appendChild($numeroSesto);
				$quoteSesto = $doc->createElement("quote");
					$quotaSesto1 = $doc->createElement("quota1",$_POST['quotaSesto1']);
					$quoteSesto->appendChild($quotaSesto1);
					$quotaSesto2 = $doc->createElement("quota2",$_POST['quotaSesto2']);
					$quoteSesto->appendChild($quotaSesto2);
					$quotaSesto3 = $doc->createElement("quota3",$_POST['quotaSesto3']);
					$quoteSesto->appendChild($quotaSesto3);
				$cavalloSesto->appendChild($quoteSesto);
			$cavalli->appendChild($cavalloSesto);
			
			$cavalloSettimo = $doc->CreateElement("cavallo"); //settimo cavallo
				$nomeSettimo = $doc->createElement("nome",$_POST['nomeSettimo']);
				$cavalloSettimo->appendChild($nomeSettimo);
				$numeroSettimo = $doc->createElement("numero",$_POST['numeroSettimo']);
				$cavalloSettimo->appendChild($numeroSettimo);
				$quoteSettimo = $doc->createElement("quote");
					$quotaSettimo1 = $doc->createElement("quota1",$_POST['quotaSettimo1']);
					$quoteSettimo->appendChild($quotaSettimo1);
					$quotaSettimo2 = $doc->createElement("quota2",$_POST['quotaSettimo2']);
					$quoteSettimo->appendChild($quotaSettimo2);
					$quotaSettimo3 = $doc->createElement("quota3",$_POST['quotaSettimo3']);
					$quoteSettimo->appendChild($quotaSettimo3);
				$cavalloSettimo->appendChild($quoteSettimo);
			$cavalli->appendChild($cavalloSettimo);
			
			$cavalloOttavo = $doc->CreateElement("cavallo"); //ottavo cavallo
				$nomeOttavo = $doc->createElement("nome",$_POST['nomeOttavo']);
				$cavalloOttavo->appendChild($nomeOttavo);
				$numeroOttavo = $doc->createElement("numero",$_POST['numeroOttavo']);
				$cavalloOttavo->appendChild($numeroOttavo);
				$quoteOttavo = $doc->createElement("quote");
					$quotaOttavo1 = $doc->createElement("quota1",$_POST['quotaOttavo1']);
					$quoteOttavo->appendChild($quotaOttavo1);
					$quotaOttavo2 = $doc->createElement("quota2",$_POST['quotaOttavo2']);
					$quoteOttavo->appendChild($quotaOttavo2);
					$quotaOttavo3 = $doc->createElement("quota3",$_POST['quotaOttavo3']);
					$quoteOttavo->appendChild($quotaOttavo3);
				$cavalloOttavo->appendChild($quotePrimo);
			$cavalli->appendChild($cavalloOttavo);
		$scommessa->appendChild($cavalli);
	
	
		$distanza = $doc->createElement("distanza",$_POST['distanza']); //creo elemento distanza
		$scommessa->appendChild($distanza);
				

		$puntata = $doc->createElement("puntata"); //creo elemento puntata
		$minima = $doc->createElement("minima","1");
		$puntata->appendChild($minima);
		$massima = $doc->createElement("puntata","9999");
		$puntata->appendChild($massima);
		$scommessa->appendChild($puntata);
	
	
	
		$risultato = $doc->createElement("risultato");
		$primo = $doc->createElement("primo");
		$risultato->appendChild($primo);
		$secondo = $doc->createElement("secondo");
		$risultato->appendChild($secondo);
		$terzo = $doc->createElement("terzo");
		$risultato->appendChild($terzo);
		$scommessa->appendChild($risultato);
		
				
		$ippica->appendChild($scommessa);
	

		# Salvataggio del file XML
		$doc->save($xml_file_name);
		
			
					} //FINE ACCETTA
			
					//ora cancello la proposta
					$xml_file_name = "fileXML/proposte/proposteScommessaIppica.xml";
					$xmlString="";
					foreach ( file("$xml_file_name") as $node ) {
						$xmlString .= trim($node);
					}
		
					$doc = new DOMdocument();
					$doc->loadXML($xmlString);
					$proposteScommessaIppica = $doc->documentElement;

					if (!$doc->loadXML($xmlString)) {
						die ("Error mentre si andava parsando il documento\n");
					}
					
					//trovo il nodo in questione
					$lista = $doc->getElementsByTagName("id");
					foreach ($lista as $l){
						if ($l->nodeValue == $_POST['id']){
							$l->parentNode->parentNode->removeChild($l->parentNode);
							}
							
					}
			
					$doc->save($xml_file_name);
					
		
				break;
			} //fine switch
			
		} //fine accetta o rifiuta
?>


<?xml version="1.0" encoding="ISO-8859-1"?>
<!DOCTYPE movies SYSTEM "movies.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
 
	<head>
		<title> Decisione approvazione scommessa </title>
		<style>
		

		.tablecenter{
					padding: 10px;
					margin-right: auto;
					margin-left: auto;
					width: 75%;
					
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
	
	<h3 style="text-align: center">
	<?php if (isset($_POST['accetta'])){
			echo ("Proposta accettata, inserita nel palinsesto!");
			}
		else if (isset($_POST['rifiuta'])){
			echo ("Proposta rifiutata!");
			}
	?>
	</h3>
    <table border="1" cellpadding="5" style="border-color: black; margin-left: auto; margin-right: auto;">
    	<tbody>
    	
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
