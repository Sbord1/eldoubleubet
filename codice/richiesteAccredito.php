<?php

	session_start();
	$_SESSION['richieste'] = "no";	

	if (isset($_POST['accetta']) || (isset($_POST['rifiuta']))){
		
		//apro il file xml dedicato alle richieste di accredito
		$xmlString="";
		# Name of the output file
		$xml_file_name = 'fileXML/richiesteAccredito/richiesteAccredito.xml';
	
		foreach ( file("$xml_file_name") as $node ) {
		$xmlString .= trim($node);
	}
		
		$doc = new DOMdocument();
		$doc->loadXML($xmlString);
	

	   if (!$doc->loadXML($xmlString)) {
			die ("Error mentre si andava parsando il documento\n");
	}
		$richiesteAccredito = $doc->documentElement; //root
		$lunghezza = $richiesteAccredito->childNodes->length;  //lunghezza corrisponde a quante richieste ci sono
		
		////////////////////////////////////////////////////////////
		////////////////////////////////////////////////////////////
		
		//apro file della chat, questo per inviare la comunicazione all'utente
		$xmlString2="";
		# Name of the output file
		$xml_file_name2 = 'fileXML/chat/chat.xml';
	
		foreach ( file("$xml_file_name2") as $node ) {
		$xmlString2 .= trim($node);
	}
		
		$doc2 = new DOMdocument();
		$doc2->loadXML($xmlString2);
	

	   if (!$doc2->loadXML($xmlString2)) {
			die ("Error mentre si andava parsando il documento\n");
	}
		$chat = $doc2->documentElement; //root
		$lunghezza2 = $chat->childNodes->length;  //lunghezza corrisponde a quante richieste ci sono
		
		
		
		//Ottengo l'id dell'ultimo nodo (chat.xml), questo perchè il nuovo nodo deve avere id+1
		$last_id = $doc2->getElementsByTagName("id")[$lunghezza2-1]->nodeValue;
		$last_id = $last_id + 1;
		
		$date = date("Y-m-d");
    	$time = date("H:i:s");
		
		//Ottengo lista di nodi per richiesteAccredito
		$idList = $doc->getElementsByTagName("id");
	
	
		foreach($idList as $id) {
			//ottengo id del nodo desiderato
  			if ($id->nodeValue == $_POST['id']){
  				
  				if(isset($_POST['accetta'])){ //accetta la richiesta e aggiorna credito utente
  					$parent= $id->parentNode->setAttribute("status", "accettata");
  					
  					
  					require_once("./connection.php");
					
					//aggiorno credito utente
  					$sqlQuery = "UPDATE $DBuser_table
					set credito= credito + $_POST[somma]
					where username = \"$_POST[username]\"";
					
					
					$resultQ = mysqli_query($mysqliConnection, $sqlQuery);
					
					if (!$resultQ) {
   						printf("Oops! La query inviata non ha avuto successo!\n");
						exit();
					}
					
					//invio comunicazione
					$newRecord = $doc2->createElement("message");
					$newId = $doc2->createElement("id", $last_id);
					$newSender = $doc2->createElement("sender", $_SESSION['userName']);
					$newReceiver = $doc2->createElement("receiver", $_POST['username']);
					$newText = $doc2->createElement("text","Richiesta ricarica accettata $_POST[somma] euro");
					$newData = $doc2->createElement("data", $date);
					$newOra = $doc2->createElement("ora", $time);

					$newRecord->appendChild($newId);
					$newRecord->appendChild($newSender);
					$newRecord->appendChild($newReceiver);
					$newRecord->appendChild($newText);
					$newRecord->appendChild($newData);
					$newRecord->appendChild($newOra);

					$chat->appendChild($newRecord);
					$doc2->save("$xml_file_name2");

					
					
				}

  				else if(isset($_POST['rifiuta'])){ //rifiuta la richiesta
  					$parent= $id->parentNode->setAttribute("status", "rifiutata");
  					
  					
  					//invio comunicazione
					$newRecord = $doc2->createElement("message");
					$newId = $doc2->createElement("id", $last_id);
					$newSender = $doc2->createElement("sender", $_SESSION['userName']);
					$newReceiver = $doc2->createElement("receiver", $_POST['username']);
					$newText = $doc2->createElement("text","Richiesta ricarica rifiutata");
					$newData = $doc2->createElement("data", $date);
					$newOra = $doc2->createElement("ora", $time);

					$newRecord->appendChild($newId);
					$newRecord->appendChild($newSender);
					$newRecord->appendChild($newReceiver);
					$newRecord->appendChild($newText);
					$newRecord->appendChild($newData);
					$newRecord->appendChild($newOra);

					$chat->appendChild($newRecord);
					$doc2->save("$xml_file_name2");


  				}
  			}
  		
		} //fine foreach
		
		
	
		# Salvataggio del file XML
		$doc->save($xml_file_name);

	}

?>

<?xml version="1.0" encoding="ISO-8859-1"?>
<!DOCTYPE movies SYSTEM "movies.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
 
	<head>
		<title> Richiesta accredito </title>
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
                        <tr>
                            <td><img src="loghi/logo.png" alt="Logo del sito" width="128px" height="auto" /></td>
                            <td><h1 style="color: white;">ELDOUBLEUBET</h1></td>
                        </tr>
                    </tbody>
                </table>
              </div> 
              <?php require_once("./menuConSwitch.php"); ?>           
        </header>
	
	<h3 style="text-align: center">Lista richieste di accredito</h3>
    <table border="1" cellpadding="5" style="border-color: black; margin-left: auto; margin-right: auto;">
    	<tbody>
<?php 
	

$xmlString = "";
foreach ( file("fileXML/richiesteAccredito/richiesteAccredito.xml") as $node ) {
	$xmlString .= trim($node);
}

    $doc = new DOMdocument();
  	$doc->loadXML($xmlString);
    
    if (!$doc->loadXML($xmlString)) {
  		die ("Error mentre si andava parsando il documento\n");
}

    
    $richiesteAccredito = $doc-> documentElement-> childNodes;
    $lunghezza = $richiesteAccredito->length;
   	


	$elenco = "<tr style=\"background-color: lightgreen\"> 
					<th> ID </th>
					<th> Richiedente </th>
					<th> Somma </th>
					<th> Status </th>
					<th> Azione </th>
					
					</tr>\n";


	//ciclo per ottenere info su tutti i film di una stessa categoria
   for ($i=0; $i<$lunghezza; $i++) {
	
		$richiesta = $richiesteAccredito->item($i); // uno dei record
		$status = $richiesta->getAttribute("status");
	
		$id = $richiesta->firstChild; //id primo child
		$idNumber = $id->textContent;
		
		
		$richiedente = $id->nextSibling;  //richiedente secondo child
		$richiedenteValue = $richiedente->textContent;
	
		$somma = $richiesta->lastChild; //somma ultimo child
		$sommaValue = $somma->textContent;
	


		$elenco.="\n<tr style=\"background-color: white;\">
						<td> $idNumber </td>
						<td> $richiedenteValue </td>
						<td> $sommaValue </td>
						<td> $status </td>";
						
		if ($status=='in-sospeso'){
			$elenco.="<form method=\"post\" action=\"\">
					<input type=\"hidden\" name=\"id\" value=\"$idNumber\">
					<input type=\"hidden\" name=\"somma\" value=\"$sommaValue\">
					<input type=\"hidden\" name=\"username\" value=\"$richiedenteValue\">
					<td> <button type=\"submit\" name=\"accetta\" value=\"submit\" class=\"link-button\"> Accetta </button> 
				    <button type=\"submit\" name=\"rifiuta\" value=\"submit\" class=\"link-button\"> Rifiuta </button> </td> </form>";
	}
			$elenco.="</tr>";
}

	echo "$elenco";
	echo "</tbody>\n</table>";
?> 	
		<h3 style="text-align: center;">
            <a href="inizio.php" alt="Home">Homepage</a>
        </h3>
	</body>
</html>
