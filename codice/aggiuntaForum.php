<?php

session_start();

if (isset($_POST['invio']) && $_POST['invio']=="Invia" && $_POST['commento']) {

    $_SESSION['category']=$_POST['category'];

    $doc = new DOMDocument();
    $doc->load("fileXML/forum/forum.xml");


    $root = $doc->documentElement;

    // Aggiungiamo il commento appena scritto nel file "forum.xml"
    $category = $_POST['category'];
    $sender = $_SESSION['userName'];
    $text = $_POST['commento'];
    $date = date("Y-m-d");
    $time = date("H:i:s");

    $newRecord = $doc->createElement("message");
    $newRecord->setAttribute("category", $category);
    $newSender = $doc->createElement("sender", $sender);
    $newText = $doc->createElement("text", $text);
    $newDate = $doc->createElement("data", $date);
    $newTime = $doc->createElement("ora", $time);

    $newRecord->appendChild($newSender);
    $newRecord->appendChild($newText);
    $newRecord->appendChild($newDate);
    $newRecord->appendChild($newTime);

    $root->appendChild($newRecord);
    $doc->save('fileXML/forum/forum.xml');

    header('Location: forum.php');

}

echo ("Errore!");
echo "<a href=\"inizio.php\" alt=\"Home\">Homepage</a>";
exit();

?>
