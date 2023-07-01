<?php
	
	require_once("./connection.php");
	session_start();
	
	//se cliccato bottone per attivare account, attivalo e imposta credito a 20
	if (isset($_POST['attiva'])){
		$sqlQuery = "UPDATE $DBuser_table
					set account=\"attivo\", credito=\"20\"
					where id = $_POST[id]";
					
		$resultQ = mysqli_query($mysqliConnection, $sqlQuery);
		if (!$resultQ) {
   			printf("Oops! La query inviata non ha avuto successo!\n");
			exit();
		}
	}
	//se cliccato bottone per disattivare account, disattivalo e imposta credito a 0
		if (isset($_POST['disattiva'])){
		$sqlQuery = "UPDATE $DBuser_table
					set account=\"disattivo\", credito=\"0\"
					where id = $_POST[id]";
					
		$resultQ = mysqli_query($mysqliConnection, $sqlQuery);
		if (!$resultQ) {
   			printf("Oops! La query inviata non ha avuto successo!\n");
			exit();
		}
	}

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
        <title>Lista Utenti</title>
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
    <style>
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

        <hr />

        <h3 style="text-align: center">Lista utenti registrati nel database</h3>

        <table border="1" cellpadding="5" style="border-color: black; margin-left: auto; margin-right: auto;">
            <tbody>
                <tr style="background-color: lightgreen">
                    <th>id</th>
                    <th>Nome</th>
                    <th>Cognome</th>
                    <th>Data di Nascita</th>
                    <th>Username</th>
                    <th>Password</th>
                    <th>Credito</th>
                    <th>Tipologia</th>
                    <th>Stato account</th>
                </tr>

<?php

// Per ogni utente presente nella tabella VOuser stampa una riga con le informazioni di quell'utente.
// mysqli_fetch_array() estrae una riga dal risultato e restituisce un array associativo con i valori della riga selezionata
while ($row = mysqli_fetch_array($resultQ)) {

    echo "<tr style=\"background-color: white;\">";

    echo "<td>".$row['id']."</td>";
    echo "<td>".$row['nome']."</td>";
    echo "<td>".$row['cognome']."</td>";
	echo "<td>".$row['dataNascita']."</td>";
	echo "<td>".$row['username']."</td>";
	echo "<td>".$row['password']."</td>";
	echo "<td>".$row['credito']."</td>";
	echo "<td>".$row['tipologia']."</td>";
	echo "<td>".$row['account']."</td>";
	echo "<form method=\"post\" action=\"\">";
	echo "<input type=\"hidden\" name=\"id\" value=\"$row[id]\">";
	if ($row['account']=='disattivo'){
		echo "<td> <button type=\"submit\" name=\"attiva\" value=\"submit\" class=\"link-button\">  Attiva account</button> </td>";
	}
	else if ($row['account']=='attivo'){
		echo "<td> <button type=\"submit\" name=\"disattiva\" value=\"submit\" class=\"link-button\">  Disattiva account </button> </td>";
	}
	echo "</form>";
    echo "</tr>";
    

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
