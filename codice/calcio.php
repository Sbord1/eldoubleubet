<?xml version="1.0" encoding="ISO-8859-1"?>
<!DOCTYPE movies SYSTEM "movies.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
 
	<head>
		<title> Calcio </title>
		<style>
  		 td.heading {
  			border: 1px solid black;
  			padding: 4px 6px;
			}

		.tablecenter{
					padding: 10px;
					border-spacing: 10px 0;
					margin-right: auto;
					margin-left: auto;}
		</style>
	</head>

	<body style= "background-color: #34495E" >
	
		
    <table class="tablecenter">
    	<tbody>
<?php 


$xmlString = "";
foreach ( file("calcio.xml") as $node ) {
	$xmlString .= trim($node);
}

    $doc = new DOMdocument();
  	$doc->loadXML($xmlString);
    
    if (!$doc->loadXML($xmlString)) {
  		die ("Error mentre si andava parsando il documento\n");
}

    
    $calcio = $doc-> documentElement-> childNodes;
    $lunghezza = $calcio->length;
   	
   	// se questa pagina e' stata chiamata con "next=qualchecosa" nella
	// uri di chiamata, vuol dire che avevamo gia' stampato qualcosa e riprendiamo da lì;



	$elenco = "<tr> 
					<td> Ora di inizio </td>
					<td> Partita </td>
					<td> 1 </td>
					<td> 2 </td>
					<td> X </td>
					<td> Under 2.5 </td>
					<td> Over 2.5 </td>
					<td> GG </td>
					<td> NG </td> </tr>\n";

	//ciclo per ottenere info su tutti i film di una stessa categoria
   for ($i=0; $i<$lunghezza; $i++) {
	
		$scommessa = $calcio->item($i); //è uno dei record
	
		$id = $scommessa->firstChild; //id primo child
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
	
		$puntata = $data->nextSibling; //puntata sesto figlio
		$minima = $puntata->firstChild;
		$minimaValue = $minima->textContent;
		$massima = $puntata->lastChild;
		$massimaValue = $massima->textContent;
	
		$risultato = $scommessa->lastChild; //risultato ultimo figlio
		$puntiSquadraCasa = $risultato->firstChild;
		$puntiSquadraCasaValue = $puntiSquadraCasa->textContent;
		$puntiSquadraTrasferta = $risultato->lastChild;
		$puntiSquadraTrasfertaValue = $puntiSquadraTrasfertaValue->textContent;
	
		
		
	
		$elenco.="\n<tr>
						<td> $oraInizioValue </td>
						 <td>  $squadraCasaValue - $squadraTrasfertaValue </td>
						 <td> $quota1Value </td>
						 <td> $quotaxValue </td>
						 <td> $quota2Value </td>
						 <td> $quotaUnderValue </td>
						 <td> $quotaOverValue </td>
						 <td> $quotaGGValue </td>
						 <td> $quotaNGValue </td> </tr>\n";
	
			
}

	echo "$elenco";
	echo "</tbody>\n</table>";
    	
?> 	
	</body>
</html>