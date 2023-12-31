<?php
	ini_set('display_errors', 1);
	error_reporting(E_ALL);

	session_start();
	
	//se sei gestore appare un buttone per eliminare le scommesse
	$eliminato_button="";
	if (isset($_SESSION['tipologia']) && $_SESSION['tipologia']=="gestore"){
		$eliminato_button="Elimina";}
?>

<?xml version="1.0" encoding="ISO-8859-1"?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
 
	<head>
		<title>Lista scommesse di Basket</title>
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
			text-align:center;
		}

  		td.head{
  		 	background-color: #FDEBD0;
			text-align:center;
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

		<h2 style="text-align: center;">BASKET</h2>

        <h4 style="text-align: center;">Clicca sulla quota che desideri per piazzare la scommessa</h4>
    <table class="tablecenter">
    	<tbody>
<?php 
	
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
    $lunghezza = $basket->length;
   	
   	//se premuto pulsante elimina, cambio attributo alla scommessa
   	if (isset($_POST['elimina'])){
   	
   		$scommesse = $doc->getElementsByTagName('scommessa'); //ottengo lista di scommesse
   		
   		foreach ($scommesse as $s){
   			if($s->childNodes[0]->nodeValue == $_POST['idPartita']){
   				$s->setAttribute("eliminato","1");
   			}
   			
		} //fine for each
		
		$doc->save("fileXML/scommesseDisponibili/basket.xml");
	
		/////////////////////////////////////////////////////////////////
		//ora devo cancellare scommessa nelle scommesse degli utenti
		$xmlString2 = "";
		foreach ( file("fileXML/scommesseUtenti/scommesseBasket.xml") as $node ) {
			$xmlString2 .= trim($node);
		}

		$doc2 = new DOMdocument();
		$doc2->loadXML($xmlString2);
	
		if (!$doc->loadXML($xmlString2)) {
			die ("Error mentre si andava parsando il documento\n");
		}
		
		$scommesseUtenti = $doc2->getElementsByTagName("scommessa"); //ottengo lista di scommesse utente
		foreach ($scommesseUtenti as $su){
			if($su->childNodes[0]->nodeValue == $_POST['idPartita']){
			$nomeScommettitore = $su->childNodes[2]->nodeValue;
			$puntataScommettitore = $su->childNodes[4]->nodeValue;
			$su->setAttribute("eliminato","1");
			
			require_once("./connection.php");
					
					//aggiorno credito utente
  					$sqlQuery = "UPDATE $DBuser_table
					set credito= credito + $puntataScommettitore
					where username = \"$nomeScommettitore\"";
					
					$resultQ = mysqli_query($mysqliConnection, $sqlQuery);
					
					if (!$resultQ) {
   						printf("Oops! La query inviata non ha avuto successo!\n");
						exit();
					}
					
					
			}
		}//fine for each
		
		
		$doc2->save("fileXML/scommesseUtenti/scommesseBasket.xml");	
	}	//fine if elimina
	
	
	// Costruiamo i titoli delle colonne della tabella che conterra' le scommesse di basket estratte da basket.xml
	$elenco = "<tr> 
					<td class=\"head\"> ID </td>
					<td class=\"head\"> Data </td>
					<td class=\"head\"> Ora di inizio </td>
					<td class=\"head\"> Ora di fine </td>
					<td class=\"head\"> Partita </td>
					<td class=\"head\"> 1 </td>
					<td class=\"head\"> 2 </td>
                    <td class=\"head\"> Risultato </td>
					
                </tr>\n";

	$current_date = date("Y-m-d");
	$current_time = date("H:i:s");

	//ciclo per ottenere info su tutte le scommesse di calcio
   for ($i=0; $i<$lunghezza; $i++) {
	
		$scommessa = $basket->item($i); 
		$eliminato = $scommessa->getAttribute("eliminato");
		
		$id = $scommessa->firstChild; 
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

        $risultato = $scommessa->lastChild; //risultato ultimo figlio
		$puntiSquadraCasa = $risultato->firstChild;
		$puntiSquadraCasaValue = $puntiSquadraCasa->textContent;
		$puntiSquadraTrasferta = $risultato->lastChild;
		$puntiSquadraTrasfertaValue = $puntiSquadraTrasferta->textContent;

		$anno_mese_giorno = trim($annoValue)."-".trim($meseValue)."-".trim($giornoValue);

        // cliccando sulla quota, mi rimanda alla pagina piazzaScommessa.php dove so quale quota ho cliccato e di quale squadra
        if ($eliminato == "0"){
			// Possiamo scommettere solo su partite non ancora iniziate
			if (($current_date < $anno_mese_giorno) || (($current_date==$anno_mese_giorno) && ($current_time < $oraInizioValue))) {
					$elenco.="\n<tr>
						<td>$idNumber</td>
                        <td>$anno_mese_giorno</td>
                        <td> $oraInizioValue </td>
                        <td> $oraFineValue </td>
                        <td> $squadraCasaValue - $squadraTrasfertaValue </td>
                        <td> 
						 		<form method=\"post\" action=\"piazzaScommessa.php\"> 
						  		<button type=\"submit\" name=\"submit\" value=\"submit\" class=\"link-button\"> $quota1Value </button>
						  		<input type=\"hidden\" name=\"category\" value=\"basket\">
								<input type=\"hidden\" name=\"risultato\" value=\"1\">
								<input type=\"hidden\" name=\"idPartita\" value=\"$idNumber\">
						  		<input type=\"hidden\" name=\"squadraCasa\" value=\"$squadraCasaValue\">
						 		<input type=\"hidden\" name=\"squadraTrasferta\" value=\"$squadraTrasfertaValue\">
						 		<input type=\"hidden\" name=\"quota\" value=\"$quota1Value\"> </form>
						</td>
                        <td>
								<form method=\"post\" action=\"piazzaScommessa.php\"> 
								<button type=\"submit\" name=\"submit\" value=\"submit\" class=\"link-button\"> $quota2Value </button>
								<input type=\"hidden\" name=\"category\" value=\"basket\">
								<input type=\"hidden\" name=\"risultato\" value=\"2\">
								<input type=\"hidden\" name=\"idPartita\" value=\"$idNumber\">
								<input type=\"hidden\" name=\"squadraCasa\" value=\"$squadraCasaValue\">
								<input type=\"hidden\" name=\"squadraTrasferta\" value=\"$squadraTrasfertaValue\">
								<input type=\"hidden\" name=\"quota\" value=\"$quota2Value\"> </form>
						 </td>
                         <td> $puntiSquadraCasaValue - $puntiSquadraTrasfertaValue </td>";
                        
						
						//se evento non svolto mostro il bottone per eliminare
						$elenco.="<td> 
								<form method=\"post\" action=\"\"> 
								<button type=\"submit\" name=\"elimina\" value=\"elimina\" class=\"link-button\">  $eliminato_button  </button>
								<input type=\"hidden\" name=\"idPartita\" value=\"$idNumber\"> </form>
						</td>";
						
						$elenco.="</tr>\n";   
		}
		else {
			$elenco.="
			<tr>
				<td>$idNumber</td>
				<td>$anno_mese_giorno</td>
				<td> $oraInizioValue </td>
				<td> $oraFineValue </td>
				<td> $squadraCasaValue - $squadraTrasfertaValue </td>
				<td> $quota1Value </td>
				<td> $quota2Value </td>
				<td> $puntiSquadraCasaValue - $puntiSquadraTrasfertaValue </td>
			</tr>
			";
		}
    }
}

    echo "$elenco";
	echo "</tbody>\n</table>";
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

	
