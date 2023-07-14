<?php
session_start();
$_SESSION['richiestaPropostaInviata'] = 0;
if (!isset($_SESSION['accessoPermesso'])) header('Location: loginPage.html');
?>

<?php
	
// Se richiedo di ricaricare inserisco la richiesta all'interno del file xml dedicato
	if (isset($_POST['invio'])){
		$_SESSION['richiestaPropostaInviata'] = 1;
		
		$xmlString="";
		# Name of the output file
		$xml_file_name = 'fileXML/proposte/proposteScommessaCalcio.xml';
	
		foreach ( file("$xml_file_name") as $node ) {
		$xmlString .= trim($node);
	}
		
		$doc = new DOMdocument();
		$doc->loadXML($xmlString);
	

	   if (!$doc->loadXML($xmlString)) {
			die ("Error mentre si andava parsando il documento\n");
	}
		$proposteScommessaCalcio = $doc->documentElement; //root
		$lunghezza = $proposteScommessaCalcio->childNodes->length;  //lunghezza corrisponde a quante richieste ci sono
		
		//Ottengo l'id dell'ultimo nodo, questo perchè il nuovo nodo deve avere id+1
		$h1 = $doc->getElementsByTagName("id")[$lunghezza-1]->nodeValue;
		$h1 = $h1 + 1;
		
		
		//Inserisco alla fine la nuova richiesta
		$proposteScommessa = $doc->createElement("proposteScommessa");
	
		$id = $doc->createElement("id","$h1"); //creo elemento id
		$proposteScommessa->appendChild($id);
		
		
		$nome = $doc->createElement("nome");  //creo elemento nome
		$squadraCasa = $doc->createElement("squadraCasa", $_POST['squadraCasa']);  
		$nome->appendChild($squadraCasa);
		$squadraTrasferta = $doc->createElement("squadraTrasfera",$_POST['squadraTrasferta']);  
		$nome->appendChild($squadraTrasferta);
		$proposteScommessa->appendChild($nome);
		
		
		
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
		$proposteScommessa->appendChild($quotaCalcio);
	
	
			
		$ora = $doc->createElement("ora"); //creo elemento ora
		$oraInizio = $doc->createElement("oraInizio",$_POST['oraInizio']);
		$ora->appendChild($oraInizio);
		$oraFine = $doc->createElement("oraFine",$_POST['oraFine']);
		$ora->appendChild($oraFine);
		$proposteScommessa->appendChild($ora);
	
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
		$proposteScommessa->appendChild($data);
		
	
	
		$puntata = $doc->createElement("puntata"); //creo elemento puntata
		$minima = $doc->createElement("minima","1");
		$puntata->appendChild($minima);
		$massima = $doc->createElement("puntata","9999");
		$puntata->appendChild($massima);
		$proposteScommessa->appendChild($puntata);
	
			
	
		$utente = $doc->createElement("utente",$_SESSION['userName']); //creo elemento utente
		$proposteScommessa->appendChild($utente);
		
		
				
		$proposteScommessaCalcio->appendChild($proposteScommessa);
	

		# Salvataggio del file XML
		$doc->save($xml_file_name);
		
	}


?>

<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Proponi scommessa Calcio</title>
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

    .forum-btn {
      display: inline-block;
      margin-left: 5px;
      padding: 5px 10px;
      background-color: #007bff;
      color: #ffffff;
      border-radius: 4px;
    }

    .forum-btn:hover {
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

    <header>

    <div>
        <table style="margin-left: auto; margin-right: auto;">
            <tbody>
                <tr>
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
            if($_SESSION['richiestaPropostaInviata']==1) {
                echo "<h2 style=\"text-align: center; color: red;\">Proposta inviata!</h2>";
            }
        ?>

    <hr />

    <h3 style="text-align: center; color: white;">Compila il form per proporre la tua scommessa.</h3>

    </header>
    
		<form action="" method="post">
    

            <p style="text-align: center;">
                Nome squadra in Casa: <input type="text" name="squadraCasa" size="30" required>
            </p>
			
			<p style="text-align: center;">
                Nome squadra in Trasferta: <input type="text" name="squadraTrasferta" size="30" required>
            </p>
            
            <p style="text-align: center;">
                Quota 1: <input type="number" size="30" name="quota1" min="1.01" max="250.00" step=".01" required>
            </p>
            
            <p style="text-align: center;">
                Quota X: <input type="number" size="30" name="quotax" min="1.01" max="250.00" step=".01"  required>
            </p>
            
            <p style="text-align: center;">
                Quota 2: <input type="number" size="30" name="quota2" min="1.01" max="250.00" step=".01"  required>
            </p>
            
            <p style="text-align: center;">
                Quota Under: <input type="number" size="30" name="quotaUnder" min="1.01" max="250.00" step=".01"  required>
            </p>
            
            <p style="text-align: center;">
                Quota Over: <input type="number" size="30" name="quotaOver" min="1.01" max="250.00" step=".01"  required>
            </p>
            
            <p style="text-align: center;">
                Quota GG: <input type="number" size="30" name="quotaGG" min="1.01" max="250.00" step=".01"  required>
            </p>
            
            <p style="text-align: center;">
                Quota NG: <input type="number" size="30" name="quotaNG" min="1.01" max="250.00" step=".01"  required>
            </p>
            
            <p style="position: relative; left: 35%;">
                Ora inizio: <input type="time" name="oraInizio" size="10" required>
                Ora fine: <input type="time" name="oraFine" size="10" required>
            </p>
            
            <p style="text-align: center;">
            <?php 
            	$today = date('Y-m-d');
                echo ("Data: <input type=\"date\" size=\"30\" name=\"data\" min= $today required>");
            ?>
            </p>
            
            <div style="text-align: center; padding: 10px">
                <input type="reset" value="Annulla le scelte">
                <input type="submit" name="invio" value="Invio">
            </div>

            <hr />

		</form>



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
