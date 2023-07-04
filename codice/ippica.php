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
		<title>Lista scommesse di Ippica</title>
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

	    <h2 style="text-align: center;">IPPICA</h2>

        <h4 style="text-align: center;">Clicca sulla quota che desideri per piazzare la scommessa</h4>

<?php 
	
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
    $lunghezza = $ippica->length;
    
    //se premuto pulsante elimina, cambio attributo alla scommessa
   	if (isset($_POST['elimina'])){
   	
   		$scommesse = $doc->getElementsByTagName('scommessa'); //ottengo lista di scommesse
   		
   		foreach ($scommesse as $s){
   			if($s->childNodes[0]->nodeValue == $_POST['idPartita']){
   				$s->setAttribute("eliminato","1");
   			}
   			
		} //fine for each
		
					
		$doc->save("fileXML/scommesseDisponibili/ippica.xml");
	
		/////////////////////////////////////////////////////////////////
		//ora devo cancellare scommessa nelle scommesse degli utenti
		$xmlString2 = "";
		foreach ( file("fileXML/scommesseUtenti/scommesseIppica.xml") as $node ) {
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
		
		
		$doc2->save("fileXML/scommesseUtenti/scommesseIppica.xml");	
	}	//fine if elimina
	
	

	//ciclo per ottenere info su tutte le scommesse di calcio
   for ($i=0; $i<$lunghezza; $i++) {
	
		$scommessa = $ippica->item($i); 
		$eliminato = $scommessa->getAttribute("eliminato");
		
		$id = $scommessa->firstChild; 
		$idNumber = $id->textContent;

        $data = $id->nextSibling;
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

        $puntata = $distanza->nextSibling;

        $risultato = $puntata->nextSibling;
        $risultatoPrimo = $risultato->firstChild;
        $risultatoPrimoValue = $risultatoPrimo->textContent;
        $risultatoSecondo = $risultatoPrimo->nextSibling;
        $risultatoSecondoValue = $risultatoSecondo->textContent;
        $risultatoTerzo = $risultato->lastChild;
        $risultatoTerzoValue = $risultatoTerzo->textContent;

        $anno_mese_giorno = trim($annoValue)."-".trim($meseValue)."-".trim($giornoValue);
        
		if ($eliminato == "0"){
        // Costruiamo i titoli delle colonne della tabella che conterra' le scommesse di ippica estratte da ippica.xml
        $elenco = "
        <table class=\"tablecenter\">
            <tbody>
                <tr>
                <td class=\"head\"> Data </td>
                <td class=\"head\"> Ora di inizio </td>
                <td class=\"head\"> Ora di fine </td>
                <td class=\"head\"> Cavalli </td>
                <td class=\"head\"> Numero </td>
                <td class=\"head\"> 1&deg; posto</td>
                <td class=\"head\"> 2&deg; posto </td>
                <td class=\"head\"> 3&deg; posto </td>
                <td class=\"head\"> Risultato </td>
                <td class=\"head\"> ID </td>
                <td class=\"head\"> Distanza </td>
                </tr>\n";

        // cliccando sulla quota, mi rimanda alla pagina piazzaScommessa.php dove so quale quota ho cliccato e di quale squadra
		$elenco.="\n<tr>
        <td>$anno_mese_giorno</td>
        <td>$oraInizioValue</td>
        <td>$oraFineValue</td>
        <td>$nomeCavallo1Value</td>
        <td>$numeroCavallo1Value</td>
        <td> 
                 <form method=\"post\" action=\"piazzaScommessa.php\"> 
                  <button type=\"submit\" name=\"submit\" value=\"submit\" class=\"link-button\"> $quoteCavallo1_quota1Value </button>
				  <input type=\"hidden\" name=\"category\" value=\"ippica\">
				  <input type=\"hidden\" name=\"numero\" value=\"1\">
				  <input type=\"hidden\" name=\"risultato\" value=\"1\">
				<input type=\"hidden\" name=\"idPartita\" value=\"$idNumber\">
                  <input type=\"hidden\" name=\"cavallo\" value=\"$nomeCavallo1Value\">
                  <input type=\"hidden\" name=\"quota\" value=\"$quoteCavallo1_quota1Value\"> </form>
        </td>
        <td>
                <form method=\"post\" action=\"piazzaScommessa.php\"> 
                <button type=\"submit\" name=\"submit\" value=\"submit\" class=\"link-button\"> $quoteCavallo1_quota2Value </button>
				<input type=\"hidden\" name=\"category\" value=\"ippica\">
				<input type=\"hidden\" name=\"numero\" value=\"1\">
				  <input type=\"hidden\" name=\"risultato\" value=\"2\">
				<input type=\"hidden\" name=\"idPartita\" value=\"$idNumber\">
                <input type=\"hidden\" name=\"cavallo\" value=\"$nomeCavallo1Value\">
                <input type=\"hidden\" name=\"quota\" value=\"$quoteCavallo1_quota2Value\"> </form>
        </td>
        <td>
                <form method=\"post\" action=\"piazzaScommessa.php\"> 
                <button type=\"submit\" name=\"submit\" value=\"submit\" class=\"link-button\"> $quoteCavallo1_quota3Value </button>
				<input type=\"hidden\" name=\"category\" value=\"ippica\">
				<input type=\"hidden\" name=\"numero\" value=\"1\">
				  <input type=\"hidden\" name=\"risultato\" value=\"3\">
				<input type=\"hidden\" name=\"idPartita\" value=\"$idNumber\">
                <input type=\"hidden\" name=\"cavallo\" value=\"$nomeCavallo1Value\">
                <input type=\"hidden\" name=\"quota\" value=\"$quoteCavallo1_quota3Value\"> </form>
        </td>
        <td rowspan=\"8\">$risultatoPrimoValue - $risultatoSecondoValue - $risultatoTerzoValue</td>
        <td rowspan=\"8\">$idNumber</td>
        <td rowspan=\"8\">$distanzaValue"."m</td>";
		$current_date = date("Y-m-d");
		$current_time = date("H:i:s");
		//se evento non svolto mostro il bottone per eliminare
		if ( ($current_date < $anno_mese_giorno) || (($current_date == $anno_mese_giorno) && ($current_time < $oraFineValue)) ) {
							
		$elenco.="<td rowspan=\"8\">
							<form method=\"post\" action=\"\"> 
							<button type=\"submit\" name=\"elimina\" value=\"elimina\" class=\"link-button\">  $eliminato_button  </button>
							<input type=\"hidden\" name=\"idPartita\" value=\"$idNumber\"> </form>
					</td>";
					}
		$elenco.="</tr>\n";
		

       $elenco.=" <tr>
            <td></td>
            <td></td>
            <td></td>
            <td>$nomeCavallo2Value</td>
            <td>$numeroCavallo2Value</td>
            <td> 
                 <form method=\"post\" action=\"piazzaScommessa.php\"> 
                  <button type=\"submit\" name=\"submit\" value=\"submit\" class=\"link-button\"> $quoteCavallo2_quota1Value </button>
				  <input type=\"hidden\" name=\"category\" value=\"ippica\">
				  <input type=\"hidden\" name=\"numero\" value=\"2\">
				  <input type=\"hidden\" name=\"risultato\" value=\"1\">
				  <input type=\"hidden\" name=\"idPartita\" value=\"$idNumber\">
                  <input type=\"hidden\" name=\"cavallo\" value=\"$nomeCavallo2Value\">
                  <input type=\"hidden\" name=\"quota\" value=\"$quoteCavallo2_quota1Value\"> </form>
            </td>
            <td>
                <form method=\"post\" action=\"piazzaScommessa.php\"> 
                <button type=\"submit\" name=\"submit\" value=\"submit\" class=\"link-button\"> $quoteCavallo2_quota2Value </button>
				<input type=\"hidden\" name=\"category\" value=\"ippica\">
				  <input type=\"hidden\" name=\"numero\" value=\"2\">
				  <input type=\"hidden\" name=\"risultato\" value=\"2\">
				<input type=\"hidden\" name=\"idPartita\" value=\"$idNumber\">
                <input type=\"hidden\" name=\"cavallo\" value=\"$nomeCavallo2Value\">
                <input type=\"hidden\" name=\"quota\" value=\"$quoteCavallo2_quota2Value\"> </form>
            </td>
            <td>
                <form method=\"post\" action=\"piazzaScommessa.php\"> 
                <button type=\"submit\" name=\"submit\" value=\"submit\" class=\"link-button\"> $quoteCavallo2_quota3Value </button>
				<input type=\"hidden\" name=\"category\" value=\"ippica\">
				  <input type=\"hidden\" name=\"numero\" value=\"2\">
				  <input type=\"hidden\" name=\"risultato\" value=\"3\">
				<input type=\"hidden\" name=\"idPartita\" value=\"$idNumber\">
                <input type=\"hidden\" name=\"cavallo\" value=\"$nomeCavallo2Value\">
                <input type=\"hidden\" name=\"quota\" value=\"$quoteCavallo2_quota3Value\"> </form>
            </td>
        </tr>\n

        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td>$nomeCavallo3Value</td>
            <td>$numeroCavallo3Value</td>
            <td> 
                <form method=\"post\" action=\"piazzaScommessa.php\"> 
                <button type=\"submit\" name=\"submit\" value=\"submit\" class=\"link-button\"> $quoteCavallo3_quota1Value </button>
				<input type=\"hidden\" name=\"category\" value=\"ippica\">
				  <input type=\"hidden\" name=\"numero\" value=\"3\">
				  <input type=\"hidden\" name=\"risultato\" value=\"1\">
				<input type=\"hidden\" name=\"idPartita\" value=\"$idNumber\">
                <input type=\"hidden\" name=\"cavallo\" value=\"$nomeCavallo3Value\">
                <input type=\"hidden\" name=\"quota\" value=\"$quoteCavallo3_quota1Value\"> </form>
            </td>
            <td>
                <form method=\"post\" action=\"piazzaScommessa.php\"> 
                <button type=\"submit\" name=\"submit\" value=\"submit\" class=\"link-button\"> $quoteCavallo3_quota2Value </button>
				<input type=\"hidden\" name=\"category\" value=\"ippica\">
				  <input type=\"hidden\" name=\"numero\" value=\"3\">
				  <input type=\"hidden\" name=\"risultato\" value=\"2\">
				<input type=\"hidden\" name=\"idPartita\" value=\"$idNumber\">
                <input type=\"hidden\" name=\"cavallo\" value=\"$nomeCavallo3Value\">
                <input type=\"hidden\" name=\"quota\" value=\"$quoteCavallo3_quota2Value\"> </form>
            </td>
            <td>
                <form method=\"post\" action=\"piazzaScommessa.php\"> 
                <button type=\"submit\" name=\"submit\" value=\"submit\" class=\"link-button\"> $quoteCavallo3_quota3Value </button>
				<input type=\"hidden\" name=\"category\" value=\"ippica\">
				  <input type=\"hidden\" name=\"numero\" value=\"3\">
				  <input type=\"hidden\" name=\"risultato\" value=\"3\">
				<input type=\"hidden\" name=\"idPartita\" value=\"$idNumber\">
                <input type=\"hidden\" name=\"cavallo\" value=\"$nomeCavallo3Value\">
                <input type=\"hidden\" name=\"quota\" value=\"$quoteCavallo3_quota3Value\"> </form>
            </td>
        </tr>\n

        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td>$nomeCavallo4Value</td>
            <td>$numeroCavallo4Value</td>
            <td> 
                <form method=\"post\" action=\"piazzaScommessa.php\"> 
                <button type=\"submit\" name=\"submit\" value=\"submit\" class=\"link-button\"> $quoteCavallo4_quota1Value </button>
				<input type=\"hidden\" name=\"category\" value=\"ippica\">
				  <input type=\"hidden\" name=\"numero\" value=\"4\">
				  <input type=\"hidden\" name=\"risultato\" value=\"1\">
				<input type=\"hidden\" name=\"idPartita\" value=\"$idNumber\">
                <input type=\"hidden\" name=\"cavallo\" value=\"$nomeCavallo4Value\">
                <input type=\"hidden\" name=\"quota\" value=\"$quoteCavallo4_quota1Value\"> </form>
            </td>
            <td>
                <form method=\"post\" action=\"piazzaScommessa.php\"> 
                <button type=\"submit\" name=\"submit\" value=\"submit\" class=\"link-button\"> $quoteCavallo4_quota2Value </button>
				<input type=\"hidden\" name=\"category\" value=\"ippica\">
				  <input type=\"hidden\" name=\"numero\" value=\"4\">
				  <input type=\"hidden\" name=\"risultato\" value=\"2\">
				<input type=\"hidden\" name=\"idPartita\" value=\"$idNumber\">
                <input type=\"hidden\" name=\"cavallo\" value=\"$nomeCavallo4Value\">
                <input type=\"hidden\" name=\"quota\" value=\"$quoteCavallo4_quota2Value\"> </form>
            </td>
            <td>
                <form method=\"post\" action=\"piazzaScommessa.php\"> 
                <button type=\"submit\" name=\"submit\" value=\"submit\" class=\"link-button\"> $quoteCavallo4_quota3Value </button>
				<input type=\"hidden\" name=\"category\" value=\"ippica\">
				  <input type=\"hidden\" name=\"numero\" value=\"4\">
				  <input type=\"hidden\" name=\"risultato\" value=\"3\">
				<input type=\"hidden\" name=\"idPartita\" value=\"$idNumber\">
                <input type=\"hidden\" name=\"cavallo\" value=\"$nomeCavallo4Value\">
                <input type=\"hidden\" name=\"quota\" value=\"$quoteCavallo4_quota3Value\"> </form>
            </td>
        </tr>\n

        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td>$nomeCavallo5Value</td>
            <td>$numeroCavallo5Value</td>
            <td> 
                <form method=\"post\" action=\"piazzaScommessa.php\"> 
                <button type=\"submit\" name=\"submit\" value=\"submit\" class=\"link-button\"> $quoteCavallo5_quota1Value </button>
				<input type=\"hidden\" name=\"category\" value=\"ippica\">
				  <input type=\"hidden\" name=\"numero\" value=\"5\">
				  <input type=\"hidden\" name=\"risultato\" value=\"1\">
				<input type=\"hidden\" name=\"idPartita\" value=\"$idNumber\">
                <input type=\"hidden\" name=\"cavallo\" value=\"$nomeCavallo5Value\">
                <input type=\"hidden\" name=\"quota\" value=\"$quoteCavallo5_quota1Value\"> </form>
            </td>
            <td>
                <form method=\"post\" action=\"piazzaScommessa.php\"> 
                <button type=\"submit\" name=\"submit\" value=\"submit\" class=\"link-button\"> $quoteCavallo5_quota2Value </button>
				<input type=\"hidden\" name=\"category\" value=\"ippica\">
				  <input type=\"hidden\" name=\"numero\" value=\"5\">
				  <input type=\"hidden\" name=\"risultato\" value=\"2\">
				<input type=\"hidden\" name=\"idPartita\" value=\"$idNumber\">
                <input type=\"hidden\" name=\"cavallo\" value=\"$nomeCavallo5Value\">
                <input type=\"hidden\" name=\"quota\" value=\"$quoteCavallo5_quota2Value\"> </form>
            </td>
            <td>
                <form method=\"post\" action=\"piazzaScommessa.php\"> 
                <button type=\"submit\" name=\"submit\" value=\"submit\" class=\"link-button\"> $quoteCavallo5_quota3Value </button>
				<input type=\"hidden\" name=\"category\" value=\"ippica\">
				  <input type=\"hidden\" name=\"numero\" value=\"5\">
				  <input type=\"hidden\" name=\"risultato\" value=\"3\">
				<input type=\"hidden\" name=\"idPartita\" value=\"$idNumber\">
                <input type=\"hidden\" name=\"cavallo\" value=\"$nomeCavallo5Value\">
                <input type=\"hidden\" name=\"quota\" value=\"$quoteCavallo5_quota3Value\"> </form>
            </td>
        </tr>\n

        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td>$nomeCavallo6Value</td>
            <td>$numeroCavallo6Value</td>
            <td> 
                <form method=\"post\" action=\"piazzaScommessa.php\"> 
                <button type=\"submit\" name=\"submit\" value=\"submit\" class=\"link-button\"> $quoteCavallo6_quota1Value </button>
				<input type=\"hidden\" name=\"category\" value=\"ippica\">
				  <input type=\"hidden\" name=\"numero\" value=\"6\">
				  <input type=\"hidden\" name=\"risultato\" value=\"1\">
				<input type=\"hidden\" name=\"idPartita\" value=\"$idNumber\">
                <input type=\"hidden\" name=\"cavallo\" value=\"$nomeCavallo6Value\">
                <input type=\"hidden\" name=\"quota\" value=\"$quoteCavallo6_quota1Value\"> </form>
            </td>
            <td>
                <form method=\"post\" action=\"piazzaScommessa.php\"> 
                <button type=\"submit\" name=\"submit\" value=\"submit\" class=\"link-button\"> $quoteCavallo6_quota2Value </button>
				<input type=\"hidden\" name=\"category\" value=\"ippica\">
				  <input type=\"hidden\" name=\"numero\" value=\"6\">
				  <input type=\"hidden\" name=\"risultato\" value=\"2\">
				<input type=\"hidden\" name=\"idPartita\" value=\"$idNumber\">
                <input type=\"hidden\" name=\"cavallo\" value=\"$nomeCavallo6Value\">
                <input type=\"hidden\" name=\"quota\" value=\"$quoteCavallo6_quota2Value\"> </form>
            </td>
            <td>
                <form method=\"post\" action=\"piazzaScommessa.php\"> 
                <button type=\"submit\" name=\"submit\" value=\"submit\" class=\"link-button\"> $quoteCavallo6_quota3Value </button>
				<input type=\"hidden\" name=\"category\" value=\"ippica\">
				  <input type=\"hidden\" name=\"numero\" value=\"6\">
				  <input type=\"hidden\" name=\"risultato\" value=\"3\">
				<input type=\"hidden\" name=\"idPartita\" value=\"$idNumber\">
                <input type=\"hidden\" name=\"cavallo\" value=\"$nomeCavallo6Value\">
                <input type=\"hidden\" name=\"quota\" value=\"$quoteCavallo6_quota3Value\"> </form>
            </td>
        </tr>\n

        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td>$nomeCavallo7Value</td>
            <td>$numeroCavallo7Value</td>
            <td> 
                <form method=\"post\" action=\"piazzaScommessa.php\"> 
                <button type=\"submit\" name=\"submit\" value=\"submit\" class=\"link-button\"> $quoteCavallo7_quota1Value </button>
				<input type=\"hidden\" name=\"category\" value=\"ippica\">
				  <input type=\"hidden\" name=\"numero\" value=\"7\">
				  <input type=\"hidden\" name=\"risultato\" value=\"1\">
				<input type=\"hidden\" name=\"idPartita\" value=\"$idNumber\">
                <input type=\"hidden\" name=\"cavallo\" value=\"$nomeCavallo7Value\">
                <input type=\"hidden\" name=\"quota\" value=\"$quoteCavallo7_quota1Value\"> </form>
            </td>
            <td>
                <form method=\"post\" action=\"piazzaScommessa.php\"> 
                <button type=\"submit\" name=\"submit\" value=\"submit\" class=\"link-button\"> $quoteCavallo7_quota2Value </button>
                <input type=\"hidden\" name=\"category\" value=\"ippica\">
				<input type=\"hidden\" name=\"numero\" value=\"7\">
				  <input type=\"hidden\" name=\"risultato\" value=\"2\">
				<input type=\"hidden\" name=\"idPartita\" value=\"$idNumber\">
                <input type=\"hidden\" name=\"cavallo\" value=\"$nomeCavallo7Value\">
                <input type=\"hidden\" name=\"quota\" value=\"$quoteCavallo7_quota2Value\"> </form>
            </td>
            <td>
                <form method=\"post\" action=\"piazzaScommessa.php\"> 
                <button type=\"submit\" name=\"submit\" value=\"submit\" class=\"link-button\"> $quoteCavallo7_quota3Value </button>
				<input type=\"hidden\" name=\"category\" value=\"ippica\">
				  <input type=\"hidden\" name=\"numero\" value=\"7\">
				  <input type=\"hidden\" name=\"risultato\" value=\"3\">
				<input type=\"hidden\" name=\"idPartita\" value=\"$idNumber\">
                <input type=\"hidden\" name=\"cavallo\" value=\"$nomeCavallo7Value\">
                <input type=\"hidden\" name=\"quota\" value=\"$quoteCavallo7_quota3Value\"> </form>
            </td>
        </tr>\n

        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td>$nomeCavallo8Value</td>
            <td>$numeroCavallo8Value</td>
            <td> 
                 <form method=\"post\" action=\"piazzaScommessa.php\"> 
                  <button type=\"submit\" name=\"submit\" value=\"submit\" class=\"link-button\"> $quoteCavallo8_quota1Value </button>
				  <input type=\"hidden\" name=\"category\" value=\"ippica\">
				  <input type=\"hidden\" name=\"numero\" value=\"8\">
				  <input type=\"hidden\" name=\"risultato\" value=\"1\">
				  <input type=\"hidden\" name=\"idPartita\" value=\"$idNumber\">
                  <input type=\"hidden\" name=\"cavallo\" value=\"$nomeCavallo8Value\">
                  <input type=\"hidden\" name=\"quota\" value=\"$quoteCavallo8_quota1Value\"> </form>
            </td>
            <td>
                <form method=\"post\" action=\"piazzaScommessa.php\"> 
                <button type=\"submit\" name=\"submit\" value=\"submit\" class=\"link-button\"> $quoteCavallo8_quota2Value </button>
				<input type=\"hidden\" name=\"category\" value=\"ippica\">
				  <input type=\"hidden\" name=\"numero\" value=\"8\">
				  <input type=\"hidden\" name=\"risultato\" value=\"2\">
				<input type=\"hidden\" name=\"idPartita\" value=\"$idNumber\">
                <input type=\"hidden\" name=\"cavallo\" value=\"$nomeCavallo8Value\">
                <input type=\"hidden\" name=\"quota\" value=\"$quoteCavallo8_quota2Value\"> </form>
            </td>
            <td>
                <form method=\"post\" action=\"piazzaScommessa.php\"> 
                <button type=\"submit\" name=\"submit\" value=\"submit\" class=\"link-button\"> $quoteCavallo8_quota3Value </button>
				<input type=\"hidden\" name=\"category\" value=\"ippica\">
				  <input type=\"hidden\" name=\"numero\" value=\"8\">
				  <input type=\"hidden\" name=\"risultato\" value=\"3\">
				<input type=\"hidden\" name=\"idPartita\" value=\"$idNumber\">
                <input type=\"hidden\" name=\"cavallo\" value=\"$nomeCavallo8Value\">
                <input type=\"hidden\" name=\"quota\" value=\"$quoteCavallo8_quota3Value\"> </form>
            </td>
        </tr>\n

        </tbody>
        </table>
        ";

        echo "$elenco";
}
}


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

   }
