<?php

	session_start();
	if (!isset($_SESSION['accessoPermesso'])) header('Location: loginPage.html');

	
	
?>
<?php
	if (isset($_POST['ricarica'])){

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
		
		//Ottengo l'id dell'ultimo nodo, questo perchè il nuovo nodo deve avere id+1
		$h1 = $doc->getElementsByTagName("id")[$lunghezza-1]->nodeValue;
		$h1 = $h1 + 1;
		
		
		//Inserisco alla fine la nuova richiesta
		$richiesta = $doc->createElement("richiesta");
		$richiesta->setAttribute("status","in-sospeso");
	
		$id = $doc->createElement("id","$h1");
		$richiesta->appendChild($id);
		
		$richiedente = $doc->createElement("richiedente", $_SESSION['userName']);
		$richiesta->appendChild($richiedente);

		$somma = $doc->createElement("somma",$_POST['somma']);
		$richiesta->appendChild($somma);
		
		$richiesteAccredito->appendChild($richiesta);
	

	
		# Salvataggio del file XML
		$doc->save($xml_file_name);
		
	}

?>


<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

    <head>
        <title>Ricarica Conto</title>
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

    <body>
    <style>
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

        <hr />

        <h3 style="text-align: center">Inserisci la somma che vorresti ricaricare nel tuo conto</h3>
	    <p style="text-align: center">
        	<?php
			require_once("./connection.php");
					
			//mostro credito utente
			$sqlQuery = "SELECT credito from $DBuser_table
			where username = \"$_SESSION[userName]\"";
			
	
	
	
			$resultQ = mysqli_query($mysqliConnection, $sqlQuery);
			
			if (!$resultQ) {
				printf("Oops! La query inviata non ha avuto successo!\n");
				exit();
			}
			$row=mysqli_fetch_array($resultQ);
			echo ("Attualmente hai a disposizione: $row[0] &euro;")
			?>
		</p>
		<p style="text-align: center">
			<form style="text-align:center" method="post" action="">
			 <input style="width: 5%" type="number" name="somma" value="10" min="10" max="9999" size="10">
			 &euro;
			 <button type="submit" name="ricarica" value="submit"> Invia richiesta  </button>
			 </form>
		</p>
    
		
		<h3 style="text-align: center;">
            <a href="inizio.php" alt="Home">Homepage</a>
        </h3>
    </body>
</html>




