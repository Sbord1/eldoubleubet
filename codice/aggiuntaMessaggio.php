<?php

session_start();

if (isset($_POST['invio']) && $_POST['invio']=="Invia" && $_POST['messaggio']) {



    $doc = new DOMDocument();
    $doc->load("fileXML/chat/chat.xml");


    $root = $doc->documentElement;
    $elementi = $root->childNodes;
    $num_records = $elementi->length;

    // Aggiungiamo il messaggio appena inviato nel file "chat.xml"
    $id = $num_records+1;
    $sender = $_POST['sender'];
    $receiver = $_POST['receiver'];
    $message = $_POST['messaggio'];
    $date = date("Y-m-d");
    $time = date("H:i:s");

    $newRecord = $doc->createElement("message");
    $newId = $doc->createElement("id", $id);
    $newSender = $doc->createElement("sender", $sender);
    $newReceiver = $doc->createElement("receiver", $receiver);
    $newText = $doc->createElement("text", $message);
    $newData = $doc->createElement("data", $date);
    $newOra = $doc->createElement("ora", $time);

    $newRecord->appendChild($newId);
    $newRecord->appendChild($newSender);
    $newRecord->appendChild($newReceiver);
    $newRecord->appendChild($newText);
    $newRecord->appendChild($newData);
    $newRecord->appendChild($newOra);

    $root->appendChild($newRecord);
    $doc->save('fileXML/chat/chat.xml');

    header('Location: chat.php');

}

echo ("Errore!");
echo "<a href=\"inizio.php\" alt=\"Home\">Homepage</a>";
exit();

?>
