<?php

	require_once("./connection.php");
	
//print_r($_POST);

	if (isset($_POST['invio']) && $_POST['invio']=="Aggiungi" && $_POST['nome'] && $_POST['password']) {
		
		
		$dataNascita = strtotime($_POST['dataNascita']);		
		$now= time(); //data di oggi

		$maggiorenne = strtotime('-18 years', $now); //data di 18 anni fa
		
		if ($dataNascita > $maggiorenne){
			echo ("non sei maggiorenne");
			}
			
			//ho calcolato l'eta ma devo capire come non inserire in tabella
			
		
	

			

    // Query per l'aggiunta dell' utente
    $sql= "INSERT INTO $DBuser_table
	(nome, cognome, dataNascita, username, password, credito, tipologia, account)
	VALUES
	('{$_POST['nome']}', '{$_POST['cognome']}', '{$_POST['dataNascita']}','{$_POST['username']}','{$_POST['password']}', \"0\", \"scommettitore\", \"disattivo\")
	";

    // Il risultato della query va in $resultQ
    if (!$resultQ = mysqli_query($mysqliConnection, $sql)) {
        printf("Can't execute query.\n");
    exit();
    }

    
    $_POST['invio']="j";
}

// Chiudiamo la connessione, tanto il db non serve piu' in questo script
	$mysqliConnection->close();

?>


<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

    <head> 
    	<title>Registrazione</title>
    </head>

    <body style="background-color: lightyellow;">

        <table style="margin-left: auto; margin-right: auto;">
            <tbody>
                <tr>
                    <td>
                        <a href="index.php".php">
                            <img src="loghi/movieCamera.png" alt="camera logo" height="80"/>
                        </a>
                    </td>
                    <td> 
                        <h1>Eldoubleubet</h1>
                    </td>
                </tr>
            </tbody>
        </table>

        <hr />

        <h3 style="text-align: center;">Registrazione</h3>

		<form action="registrazione.php" method="post">
    

            <p style="text-align: center;">
                Nome: <input type="text" name="nome" size="30" required>
            </p>
			
			<p style="text-align: center;">
                Cognome: <input type="text" name="cognome" size="30" required>
            </p>
            
            <p style="text-align: center;">
                Data di Nascita: <input type="text" name="dataNascita" size="30" value="gg-mm-aaaa">
            </p>
            
            <p style="text-align: center;">
                Username: <input type="text" name="username" size="30" required>
            </p>
            
            <p style="text-align: center;">
                Password: <input type="password" name="password" size="30" required>
            </p>
            
            <div style="text-align: center; padding: 10px">
                <input type="reset" value="Annulla le scelte">
                <input type="submit" name="invio" value="Aggiungi">
            </div>

            <hr />

            <h3 style="text-align: center;">
                <a href="index.php" alt="Home">Homepage</a>
            </h3>

		</form>



    </body>
<html>
