<?php

	require_once("./connection.php");
	
    $_SESSION['telefonoErrato'] = 0;
    $_SESSION['codiceFiscaleErrato'] = 0;
    $_SESSION['utenteInserito'] = 0;

	if (isset($_POST['invio']) && $_POST['invio']=="Aggiungi" && $_POST['nome'] && $_POST['password']) {

        $dataNascita = strtotime($_POST['dataNascita']);		
		$now= time(); //data di oggi

		$maggiorenne = strtotime('-18 years', $now); //data di 18 anni fa
		
		if ($dataNascita > $maggiorenne){
			?>
            <script>
                alert("Non sei maggiorenne! Non puoi registrarti su questo sito.");
                window.location = 'inizio.php';
            </script>
            <?php
            exit();
			}

        $patternTelefono="^[0-9]{10}$^";
		if(preg_match($patternTelefono, $_POST['telefono'])!=1) {
            $_SESSION['telefonoErrato'] = 1;
            ?>
            <script>
                alert("Errore nell'inserimento del telefono! Fai attenzione a matchare il pattern.");
            </script>
            <?php
            };
		
		$patternCod="^[A-Z]{6}[0-9]{2}[A-Z][0-9]{2}[A-Z][0-9]{3}[A-Z]$^";
		if(preg_match($patternCod, $_POST['codiceFiscale'])!=1) {
            $_SESSION['codiceFiscaleErrato'] = 1;
            ?>
            <script>
                alert("Errore nell'inserimento del codice fiscale! Fai attenzione a matchare il pattern.");
            </script>
            <?php
            };
            
        if((preg_match($patternTelefono, $_POST['telefono'])==1) && (preg_match($patternCod, $_POST['codiceFiscale'])==1)) {
            // Query per l'aggiunta dell' utente
            $sql= "INSERT INTO $DBuser_table
            (nome, cognome, dataNascita, username, password, credito, tipologia, account, indirizzo, telefono, email, codiceFiscale)
            VALUES
            ('{$_POST['nome']}', '{$_POST['cognome']}', '{$_POST['dataNascita']}','{$_POST['username']}','{$_POST['password']}', \"0\", \"scommettitore\", \"disattivo\", '{$_POST['indirizzo']}', '{$_POST['telefono']}', '{$_POST['email']}', '{$_POST['codiceFiscale']}')
            ";

            // Il risultato della query va in $resultQ
            try{
                $resultQ = mysqli_query($mysqliConnection, $sql);
                $_SESSION['utenteInserito'] = 1;
            }
                catch (mysqli_sql_exception $e){
                    $error = $e->getMessage();
                    echo ("<dialog open> $error </dialog>");
                    }
                
            $_POST['invio']="j";
		}

    }


// Chiudiamo la connessione, tanto il db non serve piu' in questo script
	$mysqliConnection->close();

?>



<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

    <head> 
    	<title>Registrazione</title>
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
                            <td><img src="loghi/logo.png" alt="Logo del sito" width="128px" height="auto" /></td>
                            <td><h1 style="color: white;">ELDOUBLEUBET</h1></td>
                        </tr>
                    </tbody>
                </table>
              </div>            
        </header>

        <?php
        if ($_SESSION['utenteInserito']==1) {
            echo "<h2 style=\"text-align: center; color: red;\">Utente inserito con successo!</h2>";
        }
        ?>

        <hr />

        <h3 style="text-align: center;">Registrazione</h3>

		<form action="registrazione.php" method="post">
    

            <p style="text-align: center;">
                <!-- Display the data in the name field if $_POST['name'] is set, otherwise leave it empty -->
                Nome: <input type="text" name="nome"
                value="<?php 
                if(isset($_POST['nome']) && $_SESSION['utenteInserito']==0) {
                    echo $_POST['nome'];
                }
                else {
                    echo '';
                }
                ?>"
                size="30" required>
            </p>
			
			<p style="text-align: center;">
                Cognome: <input type="text" name="cognome"
                value="<?php 
                if(isset($_POST['cognome']) && $_SESSION['utenteInserito']==0) {
                    echo $_POST['cognome'];
                }
                else {
                    echo '';
                }
                ?>"
                size="30" required>
            </p>
            
            <p style="text-align: center;">
                Data di Nascita: <input type="date" size="30" name="dataNascita"
                value="<?php 
                if(isset($_POST['dataNascita']) && $_SESSION['utenteInserito']==0) {
                    echo $_POST['dataNascita'];
                }
                else {
                    echo '';
                }
                ?>"
                required>
            </p>
            
            <p style="text-align: center;">
                Indirizzo: <input type="text" size="30" name="indirizzo"
                value="<?php 
                if(isset($_POST['indirizzo']) && $_SESSION['utenteInserito']==0) {
                    echo $_POST['indirizzo'];
                }
                else {
                    echo '';
                }
                ?>"
                required>
            </p>
            
            <?php 
                if($_SESSION['telefonoErrato'] == 1) {
                    echo "<p style=\"color: red; text-align: center;\">Errore nel numero di telefono!</p>";
                }
            ?>
            <p style="text-align: center;">
                Telefono: <input type="text" size="30" name="telefono"
                value="<?php 
                if(isset($_POST['telefono']) && $_SESSION['utenteInserito']==0) {
                    echo $_POST['telefono'];
                }
                else {
                    echo '';
                }
                ?>"
                required>
            </p>
            
            <p style="text-align: center;">
                Email: <input type="text" size="30" name="email"
                value="<?php 
                if(isset($_POST['email']) && $_SESSION['utenteInserito']==0) {
                    echo $_POST['email'];
                }
                else {
                    echo '';
                }
                ?>"
                required>
            </p>
            
            <?php 
                if($_SESSION['codiceFiscaleErrato'] == 1) {
                    echo "<p style=\"color: red; text-align: center;\">Errore nel codice fiscale!</p>";
                }
            ?>
            <p style="text-align: center;">
                Codice Fiscale: <input type="text" size="30" name="codiceFiscale"
                value="<?php 
                if(isset($_POST['codiceFiscale']) && $_SESSION['utenteInserito']==0) {
                    echo $_POST['codiceFiscale'];
                }
                else {
                    echo '';
                }
                ?>"
                required>
            </p>
            
            <p style="text-align: center;">
                Username: <input type="text" name="username"
                value="<?php 
                if(isset($_POST['username']) && $_SESSION['utenteInserito']==0) {
                    echo $_POST['username'];
                }
                else {
                    echo '';
                }
                ?>"
                size="30" required>
            </p>
            
            <p style="text-align: center;">
                Password: <input type="password" name="password"
                value="<?php 
                if(isset($_POST['password']) && $_SESSION['utenteInserito']==0) {
                    echo $_POST['password'];
                }
                else {
                    echo '';
                }
                ?>"
                size="30" required>
            </p>
            
            <div style="text-align: center; padding: 10px">
                <input type="reset" value="Annulla le scelte">
                <input type="submit" name="invio" value="Aggiungi">
            </div>

            <hr />

            <h3 style="text-align: center;">
                <a href="inizio.php" alt="Home">Homepage</a>
            </h3>

		</form>

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
<html>
