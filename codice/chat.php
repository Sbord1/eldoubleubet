<?php

require_once("./connection.php");
session_start();

// Selezioniamo tutti gli utenti dalla tabella DBuser
$sqlQuery = "SELECT * FROM $DBuser_table";

// mysqli_query() esegue sul db, cui siamo connessi, la query passata
// Il risultato e' un array php, contenente le righe della tabella che sono state selezionate
	$resultQ = mysqli_query($mysqliConnection, $sqlQuery);

	if (!$resultQ) {
   		printf("Oops! La query inviata non ha avuto successo!\n");
	exit();
}


?>



<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

    <head>
        <title>Chat utenti</title>
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

        <h3 style="text-align: center">Lista utenti scommettitori con cui poter chattare:</h3>

        <table border="1" cellpadding="5" style="border-color: black; margin-left: auto; margin-right: auto;">
            <tbody style="text-align: center;">
                <tr style="background-color: lightgreen">
                    <th>Username</th>
                </tr>
		  
        <?php
        // Per ogni utente presente nella tabella VOuser stampa una riga con le informazioni di quell'utente.
        // mysqli_fetch_array() estrae una riga dal risultato e restituisce un array associativo con i valori della riga selezionata
        while ($row = mysqli_fetch_array($resultQ)) {

            // Un utente scommettitote puo' chattare solo con un altro utente scommettitote che non sia se' stesso
            if ($row['tipologia']=='scommettitore' && $row['username']!=$_SESSION['userName']) {

                echo "<tr style=\"background-color: white;\">";
                echo "<form method=\"post\" action=\"chatUtente.php\">";
                echo "<input type=\"hidden\" name=\"receiver\" value=\"$row[username]\">";
                echo "<td> <button type=\"submit\">".$row['username']."</button> </td>";
                echo "</form>";
                echo "</tr>";
            }
        }
        ?>

            </tbody>
	    </table>
		
		<h3 style="text-align: center;">
            <a href="inizio.php" alt="Home">Homepage</a>
        </h3>
    </body>
</html>

<?php

$mysqliConnection->close();

?>