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
		$xml_file_name = 'fileXML/proposte/proposteScommessaIppica.xml';
	
		foreach ( file("$xml_file_name") as $node ) {
		$xmlString .= trim($node);
	}
		
		$doc = new DOMdocument();
		$doc->loadXML($xmlString);
	

	   if (!$doc->loadXML($xmlString)) {
			die ("Error mentre si andava parsando il documento\n");
	}
		$proposteScommessaIppica = $doc->documentElement; //root
		$lunghezza = $proposteScommessaIppica->childNodes->length;  //lunghezza corrisponde a quante richieste ci sono
	
		//Ottengo l'id dell'ultimo nodo, questo perchè il nuovo nodo deve avere id+1
		$h1 = $doc->getElementsByTagName("id")[$lunghezza-1]->nodeValue;
		$h1 = $h1 + 1;
		
		
		//Inserisco alla fine la nuova richiesta
		$propostaScommessa = $doc->createElement("propostaScommessa");
	
		$id = $doc->createElement("id","$h1"); //creo elemento id
		$propostaScommessa->appendChild($id);
		
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
		$propostaScommessa->appendChild($data);
		
			
		$ora = $doc->createElement("ora"); //creo elemento ora
		$oraInizio = $doc->createElement("oraInizio",$_POST['oraInizio']);
		$ora->appendChild($oraInizio);
		$oraFine = $doc->createElement("oraFine",$_POST['oraFine']);
		$ora->appendChild($oraFine);
		$propostaScommessa->appendChild($ora);
	
	
		$cavalli = $doc->createElement("cavalli"); //creo elemento cavalli
		
			$cavalloPrimo = $doc->CreateElement("cavallo"); //primo cavallo
				$nomePrimo = $doc->createElement("nome",$_POST['nomePrimo']);
				$cavalloPrimo->appendChild($nomePrimo);
				$numeroPrimo = $doc->createElement("numero",$_POST['numeroPrimo']);
				$cavalloPrimo->appendChild($numeroPrimo);
				$quotePrimo = $doc->createElement("quote");
					$quotaPrimo1 = $doc->createElement("quota1",$_POST['quotaPrimo1']);
					$quotePrimo->appendChild($quotaPrimo1);
					$quotaPrimo2 = $doc->createElement("quota2",$_POST['quotaPrimo2']);
					$quotePrimo->appendChild($quotaPrimo2);
					$quotaPrimo3 = $doc->createElement("quota3",$_POST['quotaPrimo3']);
					$quotePrimo->appendChild($quotaPrimo3);
				$cavalloPrimo->appendChild($quotePrimo);
			$cavalli->appendChild($cavalloPrimo);

			
			$cavalloSecondo = $doc->CreateElement("cavallo"); //secondo cavallo
				$nomeSecondo = $doc->createElement("nome",$_POST['nomeSecondo']);
				$cavalloSecondo->appendChild($nomeSecondo);
				$numeroSecondo = $doc->createElement("numero",$_POST['numeroSecondo']);
				$cavalloSecondo->appendChild($numeroSecondo);				
				$quoteSecondo = $doc->createElement("quote");
					$quotaSecondo1 = $doc->createElement("quota1",$_POST['quotaSecondo1']);
					$quoteSecondo->appendChild($quotaSecondo1);
					$quotaSecondo2 = $doc->createElement("quota2",$_POST['quotaSecondo2']);
					$quoteSecondo->appendChild($quotaSecondo2);
					$quotaSecondo3 = $doc->createElement("quota3",$_POST['quotaSecondo3']);
					$quoteSecondo->appendChild($quotaSecondo3);
				$cavalloSecondo->appendChild($quoteSecondo);
			$cavalli->appendChild($cavalloSecondo);
			
			$cavalloTerzo = $doc->CreateElement("cavallo"); //terzo cavallo
				$nomeTerzo = $doc->createElement("nome",$_POST['nomeTerzo']);
				$cavalloTerzo->appendChild($nomeTerzo);
				$numeroTerzo = $doc->createElement("numero",$_POST['numeroTerzo']);
				$cavalloTerzo->appendChild($numeroTerzo);
				$quoteTerzo = $doc->createElement("quote");
					$quotaTerzo1 = $doc->createElement("quota1",$_POST['quotaTerzo1']);
					$quoteTerzo->appendChild($quotaTerzo1);
					$quotaTerzo2 = $doc->createElement("quota2",$_POST['quotaTerzo2']);
					$quoteTerzo->appendChild($quotaTerzo2);
					$quotaTerzo3 = $doc->createElement("quota3",$_POST['quotaTerzo3']);
					$quoteTerzo->appendChild($quotaTerzo3);
				$cavalloTerzo->appendChild($quoteTerzo);
			$cavalli->appendChild($cavalloTerzo);
			
			$cavalloQuarto = $doc->CreateElement("cavallo"); //quarto cavallo
				$nomeQuarto = $doc->createElement("nome",$_POST['nomeQuarto']);
				$cavalloQuarto->appendChild($nomeQuarto);
				$numeroQuarto = $doc->createElement("numero",$_POST['numeroQuarto']);
				$cavalloQuarto->appendChild($numeroQuarto);
				$quoteQuarto = $doc->createElement("quote");
					$quotaQuarto1 = $doc->createElement("quota1",$_POST['quotaQuarto1']);
					$quoteQuarto->appendChild($quotaQuarto1);
					$quotaQuarto2 = $doc->createElement("quota2",$_POST['quotaQuarto2']);
					$quoteQuarto->appendChild($quotaQuarto2);
					$quotaQuarto3 = $doc->createElement("quota3",$_POST['quotaQuarto3']);
					$quoteQuarto->appendChild($quotaQuarto3);
				$cavalloQuarto->appendChild($quoteQuarto);
			$cavalli->appendChild($cavalloQuarto);
			
			$cavalloQuinto = $doc->CreateElement("cavallo"); //quinto cavallo
				$nomeQuinto = $doc->createElement("nome",$_POST['nomeQuinto']);
				$cavalloQuinto->appendChild($nomeQuinto);
				$numeroQuinto = $doc->createElement("numero",$_POST['numeroQuinto']);
				$cavalloQuinto->appendChild($numeroQuinto);
				$quoteQuinto = $doc->createElement("quote");
					$quotaQuinto1 = $doc->createElement("quota1",$_POST['quotaQuinto1']);
					$quoteQuinto->appendChild($quotaQuinto1);
					$quotaQuinto2 = $doc->createElement("quota2",$_POST['quotaQuinto2']);
					$quoteQuinto->appendChild($quotaQuinto2);
					$quotaQuinto3 = $doc->createElement("quota3",$_POST['quotaQuinto3']);
					$quoteQuinto->appendChild($quotaQuinto3);
				$cavalloQuinto->appendChild($quoteQuinto);
			$cavalli->appendChild($cavalloQuinto);
			
			$cavalloSesto = $doc->CreateElement("cavallo"); //sesto cavallo
				$nomeSesto = $doc->createElement("nome",$_POST['nomeSesto']);
				$cavalloSesto->appendChild($nomeSesto);
				$numeroSesto = $doc->createElement("numero",$_POST['numeroSesto']);
				$cavalloSesto->appendChild($numeroSesto);
				$quoteSesto = $doc->createElement("quote");
					$quotaSesto1 = $doc->createElement("quota1",$_POST['quotaSesto1']);
					$quoteSesto->appendChild($quotaSesto1);
					$quotaSesto2 = $doc->createElement("quota2",$_POST['quotaSesto2']);
					$quoteSesto->appendChild($quotaSesto2);
					$quotaSesto3 = $doc->createElement("quota3",$_POST['quotaSesto3']);
					$quoteSesto->appendChild($quotaSesto3);
				$cavalloSesto->appendChild($quoteSesto);
			$cavalli->appendChild($cavalloSesto);
			
			$cavalloSettimo = $doc->CreateElement("cavallo"); //settimo cavallo
				$nomeSettimo = $doc->createElement("nome",$_POST['nomeSettimo']);
				$cavalloSettimo->appendChild($nomeSettimo);
				$numeroSettimo = $doc->createElement("numero",$_POST['numeroSettimo']);
				$cavalloSettimo->appendChild($numeroSettimo);
				$quoteSettimo = $doc->createElement("quote");
					$quotaSettimo1 = $doc->createElement("quota1",$_POST['quotaSettimo1']);
					$quoteSettimo->appendChild($quotaSettimo1);
					$quotaSettimo2 = $doc->createElement("quota2",$_POST['quotaSettimo2']);
					$quoteSettimo->appendChild($quotaSettimo2);
					$quotaSettimo3 = $doc->createElement("quota3",$_POST['quotaSettimo3']);
					$quoteSettimo->appendChild($quotaSettimo3);
				$cavalloSettimo->appendChild($quoteSettimo);
			$cavalli->appendChild($cavalloSettimo);
			
			$cavalloOttavo = $doc->CreateElement("cavallo"); //ottavo cavallo
				$nomeOttavo = $doc->createElement("nome",$_POST['nomeOttavo']);
				$cavalloOttavo->appendChild($nomeOttavo);
				$numeroOttavo = $doc->createElement("numero",$_POST['numeroOttavo']);
				$cavalloOttavo->appendChild($numeroOttavo);
				$quoteOttavo = $doc->createElement("quote");
					$quotaOttavo1 = $doc->createElement("quota1",$_POST['quotaOttavo1']);
					$quoteOttavo->appendChild($quotaOttavo1);
					$quotaOttavo2 = $doc->createElement("quota2",$_POST['quotaOttavo2']);
					$quoteOttavo->appendChild($quotaOttavo2);
					$quotaOttavo3 = $doc->createElement("quota3",$_POST['quotaOttavo3']);
					$quoteOttavo->appendChild($quotaOttavo3);
				$cavalloOttavo->appendChild($quoteOttavo);
			$cavalli->appendChild($cavalloOttavo);
		$propostaScommessa->appendChild($cavalli);
	
	
		$distanza = $doc->createElement("distanza",$_POST['distanza']); //creo elemento distanza
		$propostaScommessa->appendChild($distanza);
				

		$puntata = $doc->createElement("puntata"); //creo elemento puntata
		$minima = $doc->createElement("minima","1");
		$puntata->appendChild($minima);
		$massima = $doc->createElement("puntata","9999");
		$puntata->appendChild($massima);
		$propostaScommessa->appendChild($puntata);
	
			
	
		$utente = $doc->createElement("utente",$_SESSION['userName']); //creo elemento utente
		$propostaScommessa->appendChild($utente);
		
		
				
		$proposteScommessaIppica->appendChild($propostaScommessa);
	

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
  <title>Proponi scommessa Ippica</title>
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
              <?php 
            	$today = date('Y-m-d');
                echo ("Data: <input type=\"date\" size=\"30\" name=\"data\" min= $today required>");
            ?>
            </p>
            
			<p style="position: relative; left: 35%;">
                Ora inizio: <input type="time" name="oraInizio" size="10" required>
                Ora fine: <input type="time" name="oraFine" size="10" required>
            </p>
            
            <p style="text-align: center;">
                Distanza: <input type="number" size="30" name="distanza" min="100" required> (m)
            </p>
            
            <h3 style="text-align: center;"> Primo cavallo    </h3>
                
            <p style="text-align: center">
				Nome: <input type="text" name="nomePrimo" size="30" required> <br /> <br />
				Numero: <input type="number" style="width: 40px" name="numeroPrimo" min="1" max="8" step="1" required> <br /> <br />
				Quota Prima posizione: <input type="number" style="width: 50px" name="quotaPrimo1" min="1.01" max="255" step=".01" required> <br /> <br />
				Quota Seconda posizione: <input type="number" style="width: 50px" name="quotaPrimo2" min="1.01" max="255" step=".01" required> <br /> <br />
				Quota Terza posizione: <input type="number" style="width: 50px" name="quotaPrimo3" min="1.01" max="255" step=".01" required> <br /> <br />
			</p>
            
             <h3 style="text-align: center;"> Secondo cavallo    </h3>
                
            <p style="text-align: center">
				Nome: <input type="text" name="nomeSecondo" size="30" required> <br /> <br />
				Numero: <input type="number" style="width: 40px" name="numeroSecondo" min="1" max="8" step="1" required> <br /> <br />
				Quota Prima posizione: <input type="number" style="width: 50px" name="quotaSecondo1" min="1.01" max="255" step=".01" required> <br /> <br />
				Quota Seconda posizione: <input type="number" style="width: 50px" name="quotaSecondo2" min="1.01" max="255" step=".01" required> <br /> <br />
				Quota Terza posizione: <input type="number" style="width: 50px" name="quotaSecondo3" min="1.01" max="255" step=".01" required> <br /> <br />
			</p>
			
			 <h3 style="text-align: center;"> Terzo cavallo    </h3>
                
            <p style="text-align: center">
				Nome: <input type="text" name="nomeTerzo" size="30" required> <br /> <br />
				Numero: <input type="number" style="width: 40px" name="numeroTerzo" min="1" max="8" step="1" required> <br /> <br />
				Quota Prima posizione: <input type="number" style="width: 50px" name="quotaTerzo1" min="1.01" max="255" step=".01" required> <br /> <br />
				Quota Seconda posizione: <input type="number" style="width: 50px" name="quotaTerzo2" min="1.01" max="255" step=".01" required> <br /> <br />
				Quota Terza posizione: <input type="number" style="width: 50px" name="quotaTerzo3" min="1.01" max="255" step=".01" required> <br /> <br />
			</p>
			
			 <h3 style="text-align: center;"> Quarto cavallo    </h3>
                
            <p style="text-align: center">
				Nome: <input type="text" name="nomeQuarto" size="30" required> <br /> <br />
				Numero: <input type="number" style="width: 40px" name="numeroQuarto" min="1" max="8" step="1" required> <br /> <br />
				Quota Prima posizione: <input type="number" style="width: 50px" name="quotaQuarto1" min="1.01" max="255" step=".01" required> <br /> <br />
				Quota Seconda posizione: <input type="number" style="width: 50px" name="quotaQuarto2" min="1.01" max="255" step=".01" required> <br /> <br />
				Quota Terza posizione: <input type="number" style="width: 50px" name="quotaQuarto3" min="1.01" max="255" step=".01" required> <br /> <br />
			</p>
			
			 <h3 style="text-align: center;"> Quinto cavallo    </h3>
                
            <p style="text-align: center">
				Nome: <input type="text" name="nomeQuinto" size="30" required> <br /> <br />
				Numero: <input type="number" style="width: 40px" name="numeroQuinto" min="1" max="8" step="1" required> <br /> <br />
				Quota Prima posizione: <input type="number" style="width: 50px" name="quotaQuinto1" min="1.01" max="255" step=".01" required> <br /> <br />
				Quota Seconda posizione: <input type="number" style="width: 50px" name="quotaQuinto2" min="1.01" max="255" step=".01" required> <br /> <br />
				Quota Terza posizione: <input type="number" style="width: 50px" name="quotaQuinto3" min="1.01" max="255" step=".01" required> <br /> <br />
			</p>
			
			 <h3 style="text-align: center;"> Sesto cavallo    </h3>
                
            <p style="text-align: center">
				Nome: <input type="text" name="nomeSesto" size="30" required> <br /> <br />
				Numero: <input type="number" style="width: 40px" name="numeroSesto" min="1" max="8" step="1" required> <br /> <br />
				Quota Prima posizione: <input type="number" style="width: 50px" name="quotaSesto1" min="1.01" max="255" step=".01" required> <br /> <br />
				Quota Seconda posizione: <input type="number" style="width: 50px" name="quotaSesto2" min="1.01" max="255" step=".01" required> <br /> <br />
				Quota Terza posizione: <input type="number" style="width: 50px" name="quotaSesto3" min="1.01" max="255" step=".01" required> <br /> <br />
			</p>
			
			 <h3 style="text-align: center;"> Settimo cavallo    </h3>
                
            <p style="text-align: center">
				Nome: <input type="text" name="nomeSettimo" size="30" required> <br /> <br />
				Numero: <input type="number" style="width: 40px" name="numeroSettimo" min="1" max="8" step="1" required> <br /> <br />
				Quota Prima posizione: <input type="number" style="width: 50px" name="quotaSettimo1" min="1.01" max="255" step=".01" required> <br /> <br />
				Quota Seconda posizione: <input type="number" style="width: 50px" name="quotaSettimo2" min="1.01" max="255" step=".01" required> <br /> <br />
				Quota Terza posizione: <input type="number" style="width: 50px" name="quotaSettimo3" min="1.01" max="255" step=".01" required> <br /> <br />
			</p>
			
			 <h3 style="text-align: center;"> Ottavo cavallo    </h3>
                
            <p style="text-align: center">
				Nome: <input type="text" name="nomeOttavo" size="30" required> <br /> <br />
				Numero: <input type="number" style="width: 40px" name="numeroOttavo" min="1" max="8" step="1" required> <br /> <br />
				Quota Prima posizione: <input type="number" style="width: 50px" name="quotaOttavo1" min="1.01" max="255" step=".01" required> <br /> <br />
				Quota Seconda posizione: <input type="number" style="width: 50px" name="quotaOttavo2" min="1.01" max="255" step=".01" required> <br /> <br />
				Quota Terza posizione: <input type="number" style="width: 50px" name="quotaOttavo3" min="1.01" max="255" step=".01" required> <br /> <br />
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
