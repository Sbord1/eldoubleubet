<?php
	ini_set('display_errors', 1);
	error_reporting(E_ALL);

	session_start();
?>

<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

    <head>
        <title>Eldoubleubet - Info Generali</title>  
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

            footer {
            background-color: #333;
            color: #fff;
            padding: 10px;
            text-align: center;
            }
        </style>
    </head>
        
    <body style="background-color: lightyellow;">

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

            <?php

                // Inserisce il menu' relativo al visitatore oppure all'uetnte loggato (scommettitore, admin oppure gestore)
                require("./menuConSwitch.php");

            ?>
        </header>


        <p>

        <table width="1000" cellpadding="10" style="margin-left: auto; margin-right: auto; padding-bottom: 15px;">
            <tbody>
                <tr>
                    <td width="1000" style="background-color: white;">
                        <hr />
                        <h4>Chi siamo</h4>
                        <p> Eldoubleubet &egrave; un sito di scommesse online realizzato come progetto universitario da Sbordone F. e Tuzzolino R.</p>
                        <h4>Come registrarsi </h4>
                        <p> Per giocare con Eldoubleubet &egrave; necessario aprire un conto di gioco ed aver compiuto 18 anni di et&agrave;. 
							Il cliente deve quindi compilare il contratto nell'apposita sezione "Registrati" in alto a destra.
							L'account dovr&agrave; essere poi attivato da un gestore del sito web. </p>
						<h4>Come ricaricare il conto </h4>
						<p> Per ricaricare il proprio conto bisogna inviare una richiesta formale nell'apposita sezione "Conto".
							La richiesta di accredito dovr&agrave; essere poi accettata da un gestore del sito web</p>
						<h4>Come giocare </h4>
						<p> Per piazzare una scommessa cliccare sulla sezione dello sport di interesse.
							Il palinsesto comprende diversi sport quali: calcio, basket, tennis e ippica.</p>
                        <hr />
                    </td>
                </tr>
            </tbody>
        </table>

        
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
