<?php

session_start();

if(isset($_POST['submit']) && $_POST['submit']=='submit') {

    switch($_POST['category']) {

        case 'calcio':

            $pattern = "/^[0-9]{1,2}$/";

            if(preg_match($pattern, $_POST['risultato1'])!=1) {
                ?>
                <script>
                    alert("Errore nell'inserimento del primo risultato! Fai attenzione a matchare il pattern.");
                    window.location = 'inserisciRisultati.php';
                </script>
                <?php
                exit();
            }

            if(preg_match($pattern, $_POST['risultato2'])!=1) {
                ?>
                <script>
                    alert("Errore nell'inserimento del secondo risultato! Fai attenzione a matchare il pattern.");
                    window.location = 'inserisciRisultati.php';
                </script>
                <?php
                exit();
            }

            $idPartitaForm = $_POST['idPartita'];
            $risultato1 = $_POST['risultato1'];
            $risultato2 = $_POST['risultato2'];

            $goalSquadraCasa = $risultato1;
            $goalSquadraTrasferta = $risultato2;

            /////////////////////////////////////////////////////////////////////////
            # Lettura file "calcio.xml"
            $xmlString = "";
            foreach ( file("fileXML/scommesseDisponibili/calcio.xml") as $node ) {
                $xmlString .= trim($node);
            }

                $doc = new DOMdocument();
                $doc->formatOutput = true;
                $doc->loadXML($xmlString);
                
                if (!$doc->loadXML($xmlString)) {
                    die ("Error mentre si andava parsando il documento\n");
            }
            /////////////////////////////////////////////////////////////////////////

            $calcio = $doc-> documentElement-> childNodes;
            $lunghezza = $calcio->length;

            $scommesse = $doc->getElementsByTagName('scommessa');

            foreach ($scommesse as $scommessa) {
                $idPartita = $scommessa->firstChild;
                $idPartitaValue = $idPartita->textContent;

                if($idPartitaValue==$idPartitaForm) {
                    // Aggiorniamo il campo <risultato> dell'elemento xml con il risultato estratto dalla form
                    
                    $nome = $idPartita->nextSibling;
                    $quotaCalcio = $nome->nextSibling;
                    $ora = $quotaCalcio->nextSibling; 
                    $data = $ora->nextSibling;
                    $puntata = $data->nextSibling;
                    $risultato = $puntata->nextSibling;
                    $puntiSquadraCasa = $risultato->firstChild;
                    $puntiSquadraTrasferta = $risultato->lastChild;
                    
                    //Update
                    $puntiSquadraCasa->nodeValue = $goalSquadraCasa;
                    $puntiSquadraTrasferta->nodeValue = $goalSquadraTrasferta;

                    //Save
                    $doc->save("fileXML/scommesseDisponibili/calcio.xml");

                    // Exit from foreach
                    break;
                }
                
            }

            break;
    
        case 'basket':

            $pattern = "/^[0-9]{2,3}$/";
            if(preg_match($pattern, $_POST['risultato1'])!=1) {
                ?>
                <script>
                    alert("Errore nell'inserimento del primo risultato! Fai attenzione a matchare il pattern.");
                    window.location = 'inserisciRisultati.php';
                </script>
                <?php
                exit();
            };
            if(preg_match($pattern, $_POST['risultato2'])!=1) {
                ?>
                <script>
                    alert("Errore nell'inserimento del secondo risultato! Fai attenzione a matchare il pattern.");
                    window.location = 'inserisciRisultati.php';
                </script>
                <?php
                exit();
            };

            $idPartitaForm = $_POST['idPartita'];
            $risultato = $_POST['risultato'];

            $puntiSquadraCasaForm = $_POST['risultato1'];
            $puntiSquadraTrasfertaForm = $_POST['risultato2'];

            if($puntiSquadraCasaForm == $puntiSquadraTrasfertaForm) {
                ?>
                <script>
                    alert("Le partite di basket non possono finire in pareggio.");
                    window.location = 'inserisciRisultati.php';
                </script>
                <?php
                exit();
            }

            /////////////////////////////////////////////////////////////////////////
            # Lettura file "basket.xml"
            $xmlString = "";
            foreach ( file("fileXML/scommesseDisponibili/basket.xml") as $node ) {
                $xmlString .= trim($node);
            }

                $doc = new DOMdocument();
                $doc->formatOutput = true;
                $doc->loadXML($xmlString);
                
                if (!$doc->loadXML($xmlString)) {
                    die ("Error mentre si andava parsando il documento\n");
            }
            /////////////////////////////////////////////////////////////////////////

            $basket = $doc-> documentElement-> childNodes;
            $lunghezza = $basket->length;

            $scommesse = $doc->getElementsByTagName('scommessa');

            foreach ($scommesse as $scommessa) {
                $idPartita = $scommessa->firstChild;
                $idPartitaValue = $idPartita->textContent;

                if($idPartitaValue==$idPartitaForm) {
                    // Aggiorniamo il campo <risultato> dell'elemento xml con il risultato estratto dalla form
                    
                    $nome = $idPartita->nextSibling;
                    $quotaBasket = $nome->nextSibling;
                    $ora = $quotaBasket->nextSibling; 
                    $data = $ora->nextSibling;
                    $puntata = $data->nextSibling;
                    $risultato = $puntata->nextSibling;
                    $puntiSquadraCasa = $risultato->firstChild;
                    $puntiSquadraTrasferta = $risultato->lastChild;
                    
                    //Update
                    $puntiSquadraCasa->nodeValue = $puntiSquadraCasaForm;
                    $puntiSquadraTrasferta->nodeValue = $puntiSquadraTrasfertaForm;

                    //Save
                    $doc->save("fileXML/scommesseDisponibili/basket.xml");

                    // Exit from foreach
                    break;
                }
                
            }

            break;
    
        case 'tennis':

            $pattern = "/^[0-9]{1}$/";
            if(preg_match($pattern, $_POST['risultato1'])!=1) {
                ?>
                <script>
                    alert("Errore nell'inserimento del primo risultato! Fai attenzione a matchare il pattern.");
                    window.location = 'inserisciRisultati.php';
                </script>
                <?php
                exit();
            };

            if(preg_match($pattern, $_POST['risultato2'])!=1) {
                ?>
                <script>
                    alert("Errore nell'inserimento del secondo risultato! Fai attenzione a matchare il pattern.");
                    window.location = 'inserisciRisultati.php';
                </script>
                <?php
                exit();
            };

            $idPartitaForm = $_POST['idPartita'];
            $risultato = $_POST['risultato'];

            $puntiGiocatoreCasaForm = $_POST['risultato1'];
            $puntiGiocatoreTrasfertaForm = $_POST['risultato2'];

            if($puntiGiocatoreCasaForm == $puntiGiocatoreTrasfertaForm) {
                ?>
                <script>
                    alert("Le partite di tennis non possono finire in pareggio.");
                    window.location = 'inserisciRisultati.php';
                </script>
                <?php
                exit();
            }

            /////////////////////////////////////////////////////////////////////////
            # Lettura file "tenni.xml"
            $xmlString = "";
            foreach ( file("fileXML/scommesseDisponibili/tennis.xml") as $node ) {
                $xmlString .= trim($node);
            }

                $doc = new DOMdocument();
                $doc->formatOutput = true;
                $doc->loadXML($xmlString);
                
                if (!$doc->loadXML($xmlString)) {
                    die ("Error mentre si andava parsando il documento\n");
            }
            /////////////////////////////////////////////////////////////////////////

            $tennis = $doc-> documentElement-> childNodes;
            $lunghezza = $tennis->length;

            $scommesse = $doc->getElementsByTagName('scommessa');

            foreach ($scommesse as $scommessa) {
                $idPartita = $scommessa->firstChild;
                $idPartitaValue = $idPartita->textContent;

                if($idPartitaValue==$idPartitaForm) {
                    // Aggiorniamo il campo <risultato> dell'elemento xml con il risultato estratto dalla form
                    
                    $nome = $idPartita->nextSibling;
                    $quotaTennis = $nome->nextSibling;
                    $ora = $quotaTennis->nextSibling; 
                    $data = $ora->nextSibling;
                    $puntata = $data->nextSibling;
                    $risultato = $puntata->nextSibling;
                    $puntiGiocatoreCasa = $risultato->firstChild;
                    $puntiGiocatoreTrasferta = $risultato->lastChild;
                    
                    //Update
                    $puntiGiocatoreCasa->nodeValue = $puntiGiocatoreCasaForm;
                    $puntiGiocatoreTrasferta->nodeValue = $puntiGiocatoreTrasfertaForm;

                    //Save
                    $doc->save("fileXML/scommesseDisponibili/tennis.xml");

                    // Exit from foreach
                    break;
                }
                
            }

            break;
    
        case 'ippica':

            if(($_POST['cavallo1posto']==$_POST['cavallo2posto']) || ($_POST['cavallo2posto']==$_POST['cavallo3posto']) || ($_POST['cavallo1posto']==$_POST['cavallo3posto'])) {
                ?>
                <script>
                    alert("Errore nell'inserimento del risultato! Controllare che un cavallo non sia arrivato in diverse posizioni.");
                    window.location = 'inserisciRisultati.php';
                </script>
                <?php
                exit();
            }

            $idCorsaForm = $_POST['idCorsa'];
            $risultato = $_POST['risultato'];

            $primoForm = $_POST['cavallo1posto'];
            $secondoForm = $_POST['cavallo2posto'];
            $terzoForm = $_POST['cavallo3posto'];

            /////////////////////////////////////////////////////////////////////////
            # Lettura file "ippica.xml"
            $xmlString = "";
            foreach ( file("fileXML/scommesseDisponibili/ippica.xml") as $node ) {
                $xmlString .= trim($node);
            }

                $doc = new DOMdocument();
                $doc->formatOutput = true;
                $doc->loadXML($xmlString);
                
                if (!$doc->loadXML($xmlString)) {
                    die ("Error mentre si andava parsando il documento\n");
            }
            /////////////////////////////////////////////////////////////////////////

            $ippica = $doc-> documentElement-> childNodes;
            $lunghezza = $ippica->length;

            $scommesse = $doc->getElementsByTagName('scommessa');

            foreach ($scommesse as $scommessa) {
                $idCorsa = $scommessa->firstChild;
                $idCorsaValue = $idCorsa->textContent;

                if($idCorsaValue==$idCorsaForm) {
                    // Aggiorniamo il campo <risultato> dell'elemento xml con il risultato estratto dalla form
                    
                    $data = $idCorsa->nextSibling;
                    $ora = $data->nextSibling;
                    $cavalli = $ora->nextSibling;
                    $distanza = $cavalli->nextSibling;
                    $puntata = $distanza->nextSibling;
                    $risultato = $puntata->nextSibling;
                    $risultatoPrimo = $risultato->firstChild;
                    $risultatoSecondo = $risultatoPrimo->nextSibling;
                    $risultatoTerzo = $risultato->lastChild;
                    
                    //Update
                    $risultatoPrimo->nodeValue = $primoForm;
                    $risultatoSecondo->nodeValue = $secondoForm;
                    $risultatoTerzo->nodeValue = $terzoForm;
                    
                    //Save
                    $doc->save("fileXML/scommesseDisponibili/ippica.xml");

                    // Exit from foreach
                    break;
                }
                
            }

            break;
    }
    
    header('Location: inserisciRisultati.php');

}

echo ("Errore!");
echo "<a href=\"inserisciRisultati.php\" alt=\"Home\">Go Back</a>";
exit();

?>
