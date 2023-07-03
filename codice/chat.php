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

            .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            }

            h1 {
            text-align: center;
            color: #333333;
            }
            
            p {
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

        <?php 
        // Se non e' stato fatto il login compare il bottone per farlo e anche il bottone per registrarsi
        if(!isset($_SESSION['userName'])){

        echo "<div style=\"float: right;\">";
        echo "<a href=\"loginPage.html\" class=\"login-btn\">Login</a>";
        echo "<a href=\"registrazione.php\" class=\"register-btn\">Registrati</a>";
        echo "</div>";
                
        }
        // Se e' stato fatto il login compare il bottone per fare il logout
        else{
        echo "<div style=\"float: right;\">";
        echo "<a href=\"logout.php\" class=\"register-btn\">Logout</a>";
        echo "</div>";
        }
        ?>

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

        <?php

        // Inserisce il menu' relativo al visitatore oppure all'uetnte loggato (scommettitore, admin oppure gestore)
        require("./menuConSwitch.php");

        ?>

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
            if ($row['username']!=$_SESSION['userName']) {

                echo "<tr style=\"background-color: white;\">";
                echo "<form method=\"post\" action=\"chatUtente.php\">";
                echo "<input type=\"hidden\" name=\"receiver\" value=\"$row[username]\">";
                echo "<td> <button class=\"link-button\" type=\"submit\">".$row['username']."</button> </td>";
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
