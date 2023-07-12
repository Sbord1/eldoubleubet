<?php

session_start();

// In questo script andiamo a leggere il file "chat.xml" e riportiamo la chat tra il sender e il receiver

$sender = $_SESSION['userName'];



// Recuperato dall'hidden field nella tabella degli utenti scommettitori (in "chat.php") con cui poter chattare
$receiver = $_POST['receiver'];


/* 
qui stiamo costruendo una stringa con il contenuto del file;
facciamo in modo che la stringa contenga il file "appiattito", cioe' privo di qualsiasi contenuto testuale
che non sia correlato al contenuto effettivo del documento XML - ad esempio senza gli spazi tra un elemento e il predecessore o successore
*/
$xmlString = "";
foreach ( file("fileXML/chat/chat.xml") as $node ) {
	$xmlString .= trim($node);
}

$doc = new DOMDocument();
if (!$doc->loadXML($xmlString)) {
  die ("Error mentre si andava parsando il documento\n");
}

$root = $doc->documentElement;
$elementi = $root->childNodes;

// Sara' un array multidimensionale (array di array) in cui salviamo il sender (indice 0), il receiver (indice 1), il text (indice 2) e la data (indice 3)
$multiArray = array();

// leggiamo tutti i messaggi presenti nel file "chat.xml"
for ($i=0; $i<$elementi->length; $i++) {

    // Estraiamo il nome del mittente e il nome del destinatario
    $elemento = $elementi->item($i);
    $mittente = $elemento->firstChild->nextSibling;
    $nomeMittente = $mittente->textContent;
    $destinatario = $mittente->nextSibling;
    $nomeDestinatario = $destinatario->textContent;

    // La chat tra 2 utenti e' composta dai messaggi dell'utente A all'utente B e dai messaggi dell'utente B all'utente A
    if (($nomeMittente==$sender && $nomeDestinatario==$receiver) || ($nomeMittente==$receiver && $nomeDestinatario==$sender)) {

        $text = $destinatario->nextSibling;
        $textCont = $text->textContent;
        $data = $text->nextSibling;
        $dataContent = $data->textContent;
        $ora = $data->nextSibling;
        $oraContent = $ora->textContent;

        // "aaaa-mm-gg hh:mm"
        $datetime = $dataContent." ".$oraContent;

        // Define the array to push into the multidimensional array
        $newArray = array($nomeMittente, $nomeDestinatario, $textCont, $datetime);
        array_push($multiArray, $newArray);

    }

}

// Comparison function per ordinare i messaggi in ordine cronologico
function date_compare($element1, $element2) {
    // We use strtotime to convert given time string to a timestamp object. Once we have timestamps, we subtract them to decide greater.
    // Il quarto elemento e' datetime
    $datetime1 = strtotime($element1[3]);
    $datetime2 = strtotime($element2[3]);
    return $datetime1 - $datetime2;
} 
  

// Sort the array 
usort($multiArray, 'date_compare');
  
// Print the ordered array
//print_r($multiArray);

?>

<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

    <head>
        <title>Chat</title>
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
        </style> 
    </head>

    <body>
        
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
        </header>

        <h3 style="text-align: center">Chat con <?php echo "$receiver"; ?></h3>

        <table border="1" cellpadding="5" style="border-color: black; margin-left: auto; margin-right: auto;">

            <tbdoy>

                <tr style="background-color: lightgreen">
                    <th>sender</th>
                    <th>message</th>
                    <th>data</th>
                </tr>
                
                <?php 

                for ($i=0; $i<count($multiArray); $i++) {
                    echo "<tr>";
                    echo "<td>".$multiArray[$i][0]."</td>";
                    echo "<td>".$multiArray[$i][2]."</td>";
                    echo "<td>".$multiArray[$i][3]."</td>";
                    echo "</tr>";
                }
                
                ?>

            </tbdoy>

        </table>

        <!-- form per inviare un messaggio al receiver (il messaggio verra' aggiunto nel file chat.xml) -->
        <form action="aggiuntaMessaggio.php" method="post">
            <p style="text-align: center;">
                Invia un nuovo messaggio a <?php echo "$receiver"; ?>:
            </p>
            <div style="text-align: center; padding: 10px">
                <input type="text" name="messaggio" size="30">
                <?php
                echo "<input type=\"hidden\" name=\"receiver\" value=\"$receiver\">";
                echo "<input type=\"hidden\" name=\"sender\" value=\"$sender\">";
                ?>
                <input type="submit" name="invio" value="Invia">
            </div>
        </form>

        <h3 style="text-align: center;">
            <a href="chat.php" alt="Home">Go back</a>
        </h3>

    </body>

</html>
