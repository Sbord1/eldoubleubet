<?php

	/*
	In questo script:
	- Verifichiamo che il conto dell'utente scommettitore sia maggiore dell'importo che l'utente vuole giocare sulla scommessa
	- Aggiorniamo il conto dell'utente, detraendo l'importo giocato, nel caso di verifica positiva
	- Modifichiamo il file xml (relativo allo sport su cui si e' scommesso) contenente le scommesse giocate dagli utenti scommettitori
	  aggiungendo la nuova scommessa appena piazzata dall'utente
	*/

	session_start();

    if(isset($_POST['invio']) && $_POST['invio']=="Scommetti") {

        require_once("./connection.php");

        // Verifichiamo, accedendo al database, che l'utente abbia abbastanza denaro per scommettere l'importo selezionato
        $username = $_SESSION['userName'];
        $puntata = $_POST['puntata'];

        $sqlQuery = "SELECT credito FROM $DBuser_table WHERE username=\"$username\"";

        // mysqli_query() esegue sul db, cui siamo connessi, la query passata
        // Il risultato e' un array php, contenente le righe della tabella che sono state selezionate
            $resultQ = mysqli_query($mysqliConnection, $sqlQuery);

            if (!$resultQ) {
                printf("Oops! La query inviata non ha avuto successo!\n");
            exit();
        }

        $row = mysqli_fetch_array($resultQ);

        $credito_utente = $row['credito'];

        // Verifichiamo che il credito dell'utente non sia insufficiente
        if ($credito_utente < $puntata) {
            $error_message = "Errore: denaro insufficiente!!! Ricarica il conto e poi torna a piazzare la scommessa.";
            echo "<script>
                alert('$error_message');
                window.location = 'conto.php';
                </script>";
            exit();
        }

        // Nel caso in cui il credito sia sufficiente detraiamo i soldi dal conto dell'utente e aggiungiamo la scommessa nel file xml adeguato

        //Aggiorniamo il credito dell'utente
  		$sqlQuery = "UPDATE $DBuser_table
                    SET credito = credito - $puntata
                    WHERE username=\"$username\"";

        $resultQ = mysqli_query($mysqliConnection, $sqlQuery);

        if (!$resultQ) {
            printf("Oops! La query inviata non ha avuto successo!\n");
        exit();
        }

        // Determiniamo quale file xml deve essere modificato
        switch($_POST['category']) {

            case 'calcio':
                $category= "calcio";
                // Modifichiamo il file fileXML/scommesseUtenti/scommesseCalcio.xml
                $id_partita = $_POST['idPartita'];
                $scommettitore = $username;
                $risultato = $_POST['risultato'];
                $puntata = $_POST['puntata'];
                $quota = $_POST['quota'];
                $vincita = $quota * $puntata;

                $doc = new DOMDocument();
                $doc->formatOutput = true;
                $doc->load("fileXML/scommesseUtenti/scommesseCalcio.xml");


                $root = $doc->documentElement;
                $lunghezza = $root->childNodes->length;

                // Calcolo nuovo id_scommessa
                $idList = $doc->getElementsByTagName("idScommessa");
                $last_id = count($idList);
                $nuovo_id_scommessa = $last_id + 1;

                $newRecord = $doc->createElement("scommessa");
                $newRecord->setAttribute("eliminato", "0");
                $newRecord->setAttribute("pagata", "0");
                $newIdPartita = $doc->createElement("idPartita", $id_partita);
                $newIdScommessa = $doc->createElement("idScommessa", $nuovo_id_scommessa);
                $newScommettitore = $doc->createElement("scommettitore", $scommettitore);
                $newRisultato = $doc->createElement("risultato", $risultato);
                $newPuntata = $doc->createElement("puntata", $puntata);
                $newQuota = $doc->createElement("quota", $quota);
                $newVincita = $doc->createElement("vincita", $vincita);


                

                $newRecord->appendChild($newIdPartita);
                $newRecord->appendChild($newIdScommessa);
                $newRecord->appendChild($newScommettitore);
                $newRecord->appendChild($newRisultato);
                $newRecord->appendChild($newPuntata);
                $newRecord->appendChild($newQuota);
                $newRecord->appendChild($newVincita);



                $root->appendChild($newRecord);
                $doc->save('fileXML/scommesseUtenti/scommesseCalcio.xml');

                break;
                

            case 'basket':
                $category= "basket";
                // Modifichiamo il file fileXML/scommesseUtenti/scommesseBasket.xml
                $id_partita = $_POST['idPartita'];
                $scommettitore = $username;
                $risultato = $_POST['risultato'];
                $puntata = $_POST['puntata'];
                $quota = $_POST['quota'];
                $vincita = $quota * $puntata;

                $doc = new DOMDocument();
                $doc->formatOutput = true;
                $doc->load("fileXML/scommesseUtenti/scommesseBasket.xml");


                $root = $doc->documentElement;
                $elementi = $root->childNodes;

                // Calcolo nuovo id_scommessa
                $idList = $doc->getElementsByTagName("idScommessa");
                $last_id = count($idList);
                $nuovo_id_scommessa = $last_id + 1;


                $newRecord = $doc->createElement("scommessa");
                $newRecord->setAttribute("eliminato", "0");
                $newRecord->setAttribute("pagata", "0");
                $newIdPartita = $doc->createElement("idPartita", $id_partita);
                $newIdScommessa = $doc->createElement("idScommessa", $nuovo_id_scommessa);
                $newScommettitore = $doc->createElement("scommettitore", $scommettitore);
                $newRisultato = $doc->createElement("risultato", $risultato);
                $newPuntata = $doc->createElement("puntata", $puntata);
                $newQuota = $doc->createElement("quota", $quota);
                $newVincita = $doc->createElement("vincita", $vincita);
                

                $newRecord->appendChild($newIdPartita);
                $newRecord->appendChild($newIdScommessa);
                $newRecord->appendChild($newScommettitore);
                $newRecord->appendChild($newRisultato);
                $newRecord->appendChild($newPuntata);
                $newRecord->appendChild($newQuota);
                $newRecord->appendChild($newVincita);


                $root->appendChild($newRecord);
                $doc->save('fileXML/scommesseUtenti/scommesseBasket.xml');

                break;
                

            case 'tennis':
                $category= "tennis";
                // Modifichiamo il file fileXML/scommesseUtenti/scommesseTennis.xml
                $id_partita = $_POST['idPartita'];
                $scommettitore = $username;
                $risultato = $_POST['risultato'];
                $puntata = $_POST['puntata'];
                $quota = $_POST['quota'];
                $vincita = $quota * $puntata;

                $doc = new DOMDocument();
                $doc->formatOutput = true;
                $doc->load("fileXML/scommesseUtenti/scommesseTennis.xml");


                $root = $doc->documentElement;
                $elementi = $root->childNodes;

                // Calcolo nuovo id_scommessa
                $idList = $doc->getElementsByTagName("idScommessa");
                $last_id = count($idList);
                $nuovo_id_scommessa = $last_id + 1;


                $newRecord = $doc->createElement("scommessa");
                $newRecord->setAttribute("eliminato", "0");
                $newRecord->setAttribute("pagata", "0");
                $newIdPartita = $doc->createElement("idPartita", $id_partita);
                $newIdScommessa = $doc->createElement("idScommessa", $nuovo_id_scommessa);
                $newScommettitore = $doc->createElement("scommettitore", $scommettitore);
                $newRisultato = $doc->createElement("risultato", $risultato);
                $newPuntata = $doc->createElement("puntata", $puntata);
                $newQuota = $doc->createElement("quota", $quota);
                $newVincita = $doc->createElement("vincita", $vincita);
                

                $newRecord->appendChild($newIdPartita);
                $newRecord->appendChild($newIdScommessa);
                $newRecord->appendChild($newScommettitore);
                $newRecord->appendChild($newRisultato);
                $newRecord->appendChild($newPuntata);
                $newRecord->appendChild($newQuota);
                $newRecord->appendChild($newVincita);


                $root->appendChild($newRecord);
                $doc->save('fileXML/scommesseUtenti/scommesseTennis.xml');
                
                break;
                

            case 'ippica':
                $category= "ippica";
                // Modifichiamo il file fileXML/scommesseUtenti/scommesseIppica.xml
                $id_partita = $_POST['idPartita'];
                $scommettitore = $username;
                $numeroCavallo = $_POST['numero'];
                // $risultato puo' essere solo 1 (primo posto), 2 (secondo posto) o 3 (terzo posto)
                $risultato = $_POST['risultato'];
                $puntata = $_POST['puntata'];
                $quota = $_POST['quota'];
                $vincita = $quota * $puntata;

                $doc = new DOMDocument();
                $doc->formatOutput = true;
                $doc->load("fileXML/scommesseUtenti/scommesseIppica.xml");


                $root = $doc->documentElement;
                $elementi = $root->childNodes;

                // Calcolo nuovo id_scommessa
                $idList = $doc->getElementsByTagName("idScommessa");
                $last_id = count($idList);
                $nuovo_id_scommessa = $last_id + 1;

                $newRecord = $doc->createElement("scommessa");
                $newRecord->setAttribute("eliminato", "0");
                $newRecord->setAttribute("pagata", "0");
                $newIdPartita = $doc->createElement("idPartita", $id_partita);
                $newIdScommessa = $doc->createElement("idScommessa", $nuovo_id_scommessa);
                $newScommettitore = $doc->createElement("scommettitore", $scommettitore);

                if ($risultato=="1") {
                    $primo=$numeroCavallo;
                    $secondo=" ";
                    $terzo=" ";
                }
                elseif ($risultato=="2") {
                    $primo=" ";
                    $secondo=$numeroCavallo;
                    $terzo=" ";
                }
                else {
                    $primo=" ";
                    $secondo=" ";
                    $terzo=$numeroCavallo;
                }

                $newRisultato = $doc->createElement("risultato");
                $newPrimo = $doc->createElement("primo", $primo);
                $newSecondo = $doc->createElement("secondo", $secondo);
                $newTerzo = $doc->createElement("terzo", $terzo);

                $newPuntata = $doc->createElement("puntata", $puntata);
                $newQuota = $doc->createElement("quota", $quota);
                $newVincita = $doc->createElement("vincita", $vincita);
                

                $newRecord->appendChild($newIdPartita);
                $newRecord->appendChild($newIdScommessa);
                $newRecord->appendChild($newScommettitore);

                $newRecord->appendChild($newRisultato);
                $newRisultato->appendChild($newPrimo);
                $newRisultato->appendChild($newSecondo);
                $newRisultato->appendChild($newTerzo);

                $newRecord->appendChild($newPuntata);
                $newRecord->appendChild($newQuota);
                $newRecord->appendChild($newVincita);


                $root->appendChild($newRecord);
                $doc->save('fileXML/scommesseUtenti/scommesseIppica.xml');
                
                break;
        }

?>

<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

	<head>
		<title>Pagamento</title>
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
		border: 5px outset red;
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

		h4 {
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

	</header>

        <?php
        echo "<h1>Scommessa piazzata con successo!</h1>";
        echo "<h2><a href=".$category.".php alt=\"back\">Go Back</a></h2>";
        exit();
        ?>

    </body>

</html>

<?php


    }

    echo ("Errore!");
    echo "<a href=\"inizio.php\" alt=\"Home\">Homepage</a>";
    exit();

?>
