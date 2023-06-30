<?xml version="1.0" encoding="ISO-8859-1"?>
<!DOCTYPE movies SYSTEM "movies.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
 
	<head>
		<title> Calcio </title>
		<style>
		tr {
			background-color: rgb(228, 240, 245);
			height: 30px;}
  		 td.head{
  		 	background-color: #FDEBD0;
  		 	}

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
		</style>
	</head>

	<body style= "background-color: #34495E" >
	<?php require("./menuConSwitch.php"); ?>
	
	<h4 style=" color: white; margin-left:36%"> Clicca sulla quota che desideri per piazzare la scommessa </h4>
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
					<td class=\"head\"> Ora di inizio </td>
					<td class=\"head\"> Partita </td>
					<td class=\"head\"> 1 </td>
					<td class=\"head\"> 2 </td>
					<td class=\"head\"> X </td>
					<td class=\"head\"> Under 2.5 </td>
					<td class=\"head\"> Over 2.5 </td>
					<td class=\"head\"> GG </td>
					<td class=\"head\"> NG </td> </tr>\n";

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
	

// cliccando sulla quota, mi rimanda alla pagina piazzaScommessa.php dove so quale quota ho cliccato e di quale squadra
		$elenco.="\n<tr>
						<td> $oraInizioValue </td>
						<td> $squadraCasaValue - $squadraTrasfertaValue </td>
						 <td> 
						 		<form method=\"post\" action=\"piazzaScommessa.php\"> 
						  		<button type=\"submit\" name=\"submit\" value=\"submit\" class=\"link-button\"> $quota1Value </button>
						  		<input type=\"hidden\" name=\"squadraCasa\" value=\"$squadraCasaValue\">
						 		<input type=\"hidden\" name=\"squadraTrasferta\" value=\"$squadraTrasfertaValue\">
						 		<input type=\"hidden\" name=\"quota\" value=\"$quota1Value\"> </form>
						</td>
						<td> 
								<form method=\"post\" action=\"piazzaScommessa.php\"> 
								<button type=\"submit\" name=\"submit\" value=\"submit\" class=\"link-button\"> $quotaxValue </button>
								<input type=\"hidden\" name=\"squadraCasa\" value=\"$squadraCasaValue\">
								<input type=\"hidden\" name=\"squadraTrasferta\" value=\"$squadraTrasfertaValue\">
								<input type=\"hidden\" name=\"quota\" value=\"$quotaxValue\"> </form> 
						 </td>
						 <td>
								<form method=\"post\" action=\"piazzaScommessa.php\"> 
								<button type=\"submit\" name=\"submit\" value=\"submit\" class=\"link-button\"> $quota2Value </button>
								<input type=\"hidden\" name=\"squadraCasa\" value=\"$squadraCasaValue\">
								<input type=\"hidden\" name=\"squadraTrasferta\" value=\"$squadraTrasfertaValue\">
								<input type=\"hidden\" name=\"quota\" value=\"$quota2Value\"> </form>
						 </td>
						 <td>
								<form method=\"post\" action=\"piazzaScommessa.php\"> 
								<button type=\"submit\" name=\"submit\" value=\"submit\" class=\"link-button\">  $quotaUnderValue </button>
								<input type=\"hidden\" name=\"squadraCasa\" value=\"$squadraCasaValue\">
								<input type=\"hidden\" name=\"squadraTrasferta\" value=\"$squadraTrasfertaValue\">
								<input type=\"hidden\" name=\"quota\" value=\" $quotaUnderValue\"> </form>
						</td>
						<td> 
						 		<form method=\"post\" action=\"piazzaScommessa.php\"> 
								<button type=\"submit\" name=\"submit\" value=\"submit\" class=\"link-button\">  $quotaOverValue  </button>
								<input type=\"hidden\" name=\"squadraCasa\" value=\"$squadraCasaValue\">
								<input type=\"hidden\" name=\"squadraTrasferta\" value=\"$squadraTrasfertaValue\">
								<input type=\"hidden\" name=\"quota\" value=\" $quotaOverValue \"> </form>
						</td>
						<td>
						 		<form method=\"post\" action=\"piazzaScommessa.php\"> 
								<button type=\"submit\" name=\"submit\" value=\"submit\" class=\"link-button\">  $quotaGGValue  </button>
								<input type=\"hidden\" name=\"squadraCasa\" value=\"$squadraCasaValue\">
								<input type=\"hidden\" name=\"squadraTrasferta\" value=\"$squadraTrasfertaValue\">
								<input type=\"hidden\" name=\"quota\" value=\" $quotaGGValue \"> </form> 
						</td>
						<td>
								<form method=\"post\" action=\"piazzaScommessa.php\"> 
								<button type=\"submit\" name=\"submit\" value=\"submit\" class=\"link-button\">  $quotaNGValue  </button>
								<input type=\"hidden\" name=\"squadraCasa\" value=\"$squadraCasaValue\">
								<input type=\"hidden\" name=\"squadraTrasferta\" value=\"$squadraTrasfertaValue\">
								<input type=\"hidden\" name=\"quota\" value=\" $quotaNGValue \"> </form>
						</td> </tr>\n";
	
			
}

	echo "$elenco";
	echo "</tbody>\n</table>";
?> 	
	</body>
</html>
