<?php

session_start();

$username = $_SESSION['userName'];

// Questo script viene eseguito quando un utente scommettitore ha vinto una scommessa e decide di ricevere l'importo vinto

if(isset($_POST['submit']) && $_POST['submit']=="submit") {

    // (1) query per l'aggiunta dei soldi vinti al conto dell'utente

    require_once('./connection.php');

    $denaro_vinto = $_POST['vincita'];

    // Aggiorno credito utente
    $sqlQuery = "UPDATE $DBuser_table
    SET credito = credito+$denaro_vinto
    WHERE username = \"$username\"";
    
    $resultQ = mysqli_query($mysqliConnection, $sqlQuery);
    
    if (!$resultQ) {
           printf("Oops! La query inviata non ha avuto successo!\n");
        exit();
    }

    // (2) modifica del file xml contenete le scommesse degli utenti aggiornando l'attributo "pagata" a 1
    $id_scommessa_form = $_POST['idScommessa'];
    $fileXML_to_update = "fileXML/scommesseUtenti/".$_POST['category'].".xml";

    # Lettura file xml
    $xmlString = "";
    foreach ( file($fileXML_to_update) as $node ) {
        $xmlString .= trim($node);
    }

    $doc = new DOMdocument();
    $doc->formatOutput = true;
    $doc->loadXML($xmlString);
    
    if (!$doc->loadXML($xmlString)) {
        die ("Error mentre si andava parsando il documento\n");
    }

    // Aggiorniamo l'attributo "pagata" da 0 a 1
    $id_scommessa_List = $doc->getElementsByTagName("idScommessa");
    foreach ($id_scommessa_List as $id_scommessa) {
        
        if ($id_scommessa->nodeValue == $id_scommessa_form) {

            $scommessa = $id_scommessa->parentNode;
            $scommessa->setAttribute("pagata", "1");

            break;
        }
    }

    // Save
    $doc->save($fileXML_to_update);

    echo("done");

    header('Location: riepilogoScommesseUtente.php');

}

echo ("Errore");

?>