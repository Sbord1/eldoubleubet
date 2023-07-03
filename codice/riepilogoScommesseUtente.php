<?php

    session_start();

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

        <h2 style="text-align: center;">Lista scommesse giocate suddivise per sport</h2>

        <?php

        $username = $_SESSION['userName'];

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
                            <td class=\"head\">Scommettitore</td>
                            <td class=\"head\">Risultato giocato</td>
                            <td class=\"head\">Puntata</td>
                            <td class=\"head\">Quota</td>
                            <td class=\"head\">Potenziale Vincita</td>
                            <td class=\"head\">Terminata</td>
                            <td class=\"head\">Esito</td>
					    </tr>\n";

        for ($i=0; $i<$lunghezza; $i++) {

			$scommessa = $scommesseCalcio->item($i);

			$id = $scommessa->firstChild;
            $idValue = $id->textContent;

			$scommettitore = $id->nextSibling;
			$scommettitoreValue = $scommettitore->textContent;

            if ($scommettitoreValue==$username) {

                $risultato = $scommettitore->nextSibling;
                $risultatoValue = $risultato->textContent;

                $puntata = $risultato->nextSibling;
                $puntataValue = $puntata->textContent;

				$quota = $puntata->nextSibling;
				$quotaValue = $quota->textContent;

				$vincita = $quota->nextSibling;
				$vincitaValue = $vincita->textContent;

                $elenco.=
                "\n<tr>
                    <td>$idValue</td>
                    <td>$scommettitoreValue</td>
                    <td>$risultatoValue</td>
                    <td>$puntataValue</td>
                    <td>$quotaValue</td>
                    <td>$vincitaValue</td>
                    <td></td>
                    <td></td>
                </tr>\n
                ";
            }
        }

        $elenco.="</tbody>\n</table>\n";

		echo "<hr />";
		echo "<h2>CALCIO</h2>";
        echo "$elenco";
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
                            <td class=\"head\">Scommettitore</td>
                            <td class=\"head\">Risultato giocato</td>
                            <td class=\"head\">Puntata</td>
                            <td class=\"head\">Quota</td>
                            <td class=\"head\">Potenziale Vincita</td>
                            <td class=\"head\">Terminata</td>
                            <td class=\"head\">Esito</td>
					    </tr>\n";

        for ($i=0; $i<$lunghezza; $i++) {

			$scommessa = $scommesseBasket->item($i);

			$id = $scommessa->firstChild;
            $idValue = $id->textContent;

			$scommettitore = $id->nextSibling;
			$scommettitoreValue = $scommettitore->textContent;

            if ($scommettitoreValue==$username) {

                $risultato = $scommettitore->nextSibling;
                $risultatoValue = $risultato->textContent;

                $puntata = $risultato->nextSibling;
                $puntataValue = $puntata->textContent;

				$quota = $puntata->nextSibling;
				$quotaValue = $quota->textContent;

				$vincita = $quota->nextSibling;
				$vincitaValue = $vincita->textContent;

                $elenco.=
                "\n<tr>
                    <td>$idValue</td>
                    <td>$scommettitoreValue</td>
                    <td>$risultatoValue</td>
                    <td>$puntataValue</td>
                    <td>$quotaValue</td>
                    <td>$vincitaValue</td>
                    <td></td>
                    <td></td>
                </tr>\n
                ";
            }
        }

        $elenco.="</tbody>\n</table>\n";

		echo "<h2>BASKET</h2>";
        echo "$elenco";
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
                            <td class=\"head\">Scommettitore</td>
                            <td class=\"head\">Risultato giocato</td>
                            <td class=\"head\">Puntata</td>
                            <td class=\"head\">Quota</td>
                            <td class=\"head\">Potenziale Vincita</td>
                            <td class=\"head\">Terminata</td>
                            <td class=\"head\">Esito</td>
					    </tr>\n";

        for ($i=0; $i<$lunghezza; $i++) {

			$scommessa = $scommesseTennis->item($i);

			$id = $scommessa->firstChild;
            $idValue = $id->textContent;

			$scommettitore = $id->nextSibling;
			$scommettitoreValue = $scommettitore->textContent;

            if ($scommettitoreValue==$username) {

                $risultato = $scommettitore->nextSibling;
                $risultatoValue = $risultato->textContent;

                $puntata = $risultato->nextSibling;
                $puntataValue = $puntata->textContent;

				$quota = $puntata->nextSibling;
				$quotaValue = $quota->textContent;

				$vincita = $quota->nextSibling;
				$vincitaValue = $vincita->textContent;

                $elenco.=
                "\n<tr>
                    <td>$idValue</td>
                    <td>$scommettitoreValue</td>
                    <td>$risultatoValue</td>
                    <td>$puntataValue</td>
                    <td>$quotaValue</td>
					<td>$vincitaValue</td>
                    <td></td>
                    <td></td>
                </tr>\n
                ";
            }
        }

        $elenco.="</tbody>\n</table>\n";

		echo "<h2>TENNIS</h2>";
        echo "$elenco";
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
            die ("Error mentre si andava parsando il documento\n");
        }

        $scommesseIppica = $doc->documentElement->childNodes;
        $lunghezza = $scommesseIppica->length;

        $elenco = "<table class=\"tablecenter\">
    	            <tbody>
                        <tr> 	
                            <td class=\"head\">ID Corsa</td>
                            <td class=\"head\">Scommettitore</td>
                            <td class=\"head\">Risultato giocato</td>
                            <td class=\"head\">Puntata</td>
                            <td class=\"head\">Quota</td>
                            <td class=\"head\">Potenziale Vincita</td>
                            <td class=\"head\">Terminata</td>
                            <td class=\"head\">Esito</td>
					    </tr>\n";

        for ($i=0; $i<$lunghezza; $i++) {

			$scommessa = $scommesseIppica->item($i);

			$id = $scommessa->firstChild;
            $idValue = $id->textContent;

			$scommettitore = $id->nextSibling;
			$scommettitoreValue = $scommettitore->textContent;

            if ($scommettitoreValue==$username) {

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

                $elenco.=
                "\n<tr>
                    <td>$idValue</td>
                    <td>$scommettitoreValue</td>
                    <td>$risultatoValue</td>
                    <td>$puntataValue</td>
                    <td>$quotaValue</td>
                    <td>$vincitaValue</td>
                    <td></td>
                    <td></td>
                </tr>\n
                ";
            }
        }

        $elenco.="</tbody>\n</table>\n";

		echo "<h2>IPPICA</h2>";
        echo "$elenco";
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
