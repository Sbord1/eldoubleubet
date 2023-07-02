<?php
	ini_set('display_errors', 1);
	error_reporting(E_ALL);

	session_start();
?>

<?xml version="1.0" encoding="ISO-8859-1"?>
<!DOCTYPE movies SYSTEM "movies.dtd">
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
		}

  		td.head{
  		 	background-color: #FDEBD0;
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
	
	
	<h4 style="text-align: center;">Clicca sulla quota che desideri per piazzare la scommessa</h4>
    <table class="tablecenter">
    	<tbody>
<?php 
	
/////////////////////////////////////////////////////////////////////////
# Lettura file "calcio.xml"
$xmlString = "";
foreach ( file("calcio.xml") as $node ) {
	$xmlString .= trim($node);
}

    $doc = new DOMdocument();
  	$doc->loadXML($xmlString);
    
    if (!$doc->loadXML($xmlString)) {
  		die ("Error mentre si andava parsando il documento\n");
}
/////////////////////////////////////////////////////////////////////////


    
    $calcio = $doc-> documentElement-> childNodes;
    $lunghezza = $calcio->length;
   	
	// Costruiamo i titoli delle colonne della tabella che conterra' le scommesse di calcio estratte da calcio.xml
	$elenco = "<tr> 
					<td class=\"head\"> Ora di inizio </td>
					<td class=\"head\"> Ora di fine </td>
					<td class=\"head\"> Partita </td>
					<td class=\"head\"> 1 </td>
					<td class=\"head\"> 2 </td>
					<td class=\"head\"> X </td>
					<td class=\"head\"> Under 2.5 </td>
					<td class=\"head\"> Over 2.5 </td>
					<td class=\"head\"> GG </td>
					<td class=\"head\"> NG </td> </tr>\n";

	//ciclo per ottenere info su tutte le scommesse di calcio
   for ($i=0; $i<$lunghezza; $i++) {
	
		$scommessa = $calcio->item($i); //e' uno dei record
	
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
		$puntiSquadraTrasfertaValue = $puntiSquadraTrasferta->textContent;
	

// cliccando sulla quota, mi rimanda alla pagina piazzaScommessa.php dove so quale quota ho cliccato e di quale squadra
		$elenco.="\n<tr>
						<td> $oraInizioValue </td>
						<td> $oraFineValue </td>
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
