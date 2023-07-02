<?php
session_start();

?>

<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sito di scommesse - Benvenuto</title>
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

    <hr />

    <h3 style="text-align: center; color: white;">Seleziona una categoria dal men&ugrave; in basso per visualizzarne il relativo forum.</h3>

    <nav>
      <ul>
        <li>
            <form method="post" action="forum.php">
                <button type="submit" name="category" value="calcio" class="forum-btn">Calcio</button>
            </form>
        </li>
        |
        <li>
            <form method="post" action="forum.php">
                <button type="submit" name="category" value="basket" class="forum-btn">Basket</button>
            </form>
        </li>
        |
        <li>
            <form method="post" action="forum.php">
                <button type="submit" name="category" value="tennis" class="forum-btn">Tennis</button>
            </form>
        </li>
        |
        <li>
            <form method="post" action="forum.php">
                <button type="submit" name="category" value="ippica" class="forum-btn">Ippica</button>
            </form>
        </li>
      </ul>
    </nav>

    </header>

    <?php
    
    // Recuperato dall'hidden field nel menu'
    if (isset($_POST['category'])) {
        $chosen_category = $_POST['category'];
    }
    else {
        // Veniamo da "aggiuntaForum.php" in cui abbiamo definito la variabile $_SESSION['catgeory']
        if (isset($_SESSION['category']))
        $chosen_category = $_SESSION['category'];
    }

    // Dato che conosciamo la categoria, mostriamo tutti i messaggi relativi a quello sport estraendoli dal file "forum.xml"
    if(isset($chosen_category)) {

        ///////////////////////////////////////////////////////////////

        # Lettura file "forum.xml"

        $xmlString = "";
        foreach ( file("fileXML/forum/forum.xml") as $node ) {
          $xmlString .= trim($node);
        }

        $doc = new DOMDocument();
        if (!$doc->loadXML($xmlString)) {
          die ("Error mentre si andava parsando il documento\n");
        }

        $root = $doc->documentElement;
        $elementi = $root->childNodes;
        ////////////////////////////////////////////////////////////////

        $multiArray = array();

        // Leggiamo tutti i messaggi presenti nel file "chat.xml" e li filtriamo per categoria
        for ($i=0; $i<$elementi->length; $i++) {

            $elemento = $elementi->item($i);
            // Estraiamo l'attributo "category" dall'elemento "message" per sapere a quale sport si riferisce il messaggio
            $read_category = $elemento->getAttribute("category");

            // Se il messaggio si riferisce alla categoria selezionata allora lo aggiungiamo ad un array multidimensionale (in cui salviamo anche il testo e la data) che stamperemo alla fine
            if ($read_category == $chosen_category) {

                $sender = $elemento->firstChild;
                $senderContent = $sender->textContent;

                $text = $sender->nextSibling;
                $textContent = $text->textContent;

                $data = $text->nextSibling;
                $dataContent = $data->textContent;

                $ora = $data->nextSibling;
                $oraContent = $ora->textContent;

                // "aaaa-mm-gg hh:mm"
                $datetime = $dataContent." ".$oraContent;

                // Define the array to push into the multidimensional array
                $newArray = array($senderContent, $textContent, $datetime);
                array_push($multiArray, $newArray);

            }

        }

        // Ordiniamo cronologicamente l'array multidimensionale

        // Comparison function per ordinare i messaggi in ordine cronologico
        function date_compare($element1, $element2) {
            // We use strtotime to convert given time string to a timestamp object. Once we have timestamps, we subtract them to decide greater.
            // Il terzo elemento e' datetime
            $datetime1 = strtotime($element1[2]);
            $datetime2 = strtotime($element2[2]);
            return $datetime1 - $datetime2;
        } 
  
        // Sort the array 
        usort($multiArray, 'date_compare');

    ?>

    <h2 style="text-align: center">Forum di <?php echo "$chosen_category";?></h2>

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
            echo "<td>".$multiArray[$i][1]."</td>";
            echo "<td>".$multiArray[$i][2]."</td>";
            echo "</tr>";
        }
        
        ?>

    </tbdoy>
    </table>

    <!-- form per scrivere un commento nel forum (il commento verra' aggiunto nel file forum.xml) -->
    <form action="aggiuntaForum.php" method="post">
            <p style="text-align: center;">
                Scrivi un nuovo commento nel forum:
            </p>
            <div style="text-align: center; padding: 10px">
                <input type="text" name="commento" size="30">
                <?php
                echo "<input type=\"hidden\" name=\"category\" value=\"$chosen_category\">";
                ?>
                <input type="submit" name="invio" value="Invia">
            </div>
    </form>

<?php
    } // chiusura if(isset($chosen_category))
?>

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
