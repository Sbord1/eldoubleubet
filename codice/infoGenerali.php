<?php
	ini_set('display_errors', 1);
	error_reporting(E_ALL);

	session_start();
?>

<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

    <head>
        <title>Eldoubleubet</title>  
    </head>
<?php
// Controlliamo se e' stato effettuato il login per salvare in $str il nome dell'utente loggato
	if(isset($_SESSION['userName']))
   		$str="Utente ".$_SESSION['userName'];
	else
    	$str='Fai il login';
    	$str2='Registrati ';
?>


        <p style="float: right;">
            <!-- Stampiamo il nome dell'utente se ha effettuato il login altrimenti comparira' "Fai il login". -->
            <b><?php echo $str."---> "; ?></b>
           
            
            <?php 
            // Se non e' stato fatto il login compare il logo per farlo
            if(!isset($_SESSION['userName'])){
                echo "<a href=\"loginPage.html\">
                        <img src=\"loghi/userLogin.jpg\" alt=\"userLogo\" title=\"Login\" style=\"float: right; height: 30px;\"/>
                      </a>";
                      
                }
            // Se e' stato fatto il login compare il logo per fare il logout
            else{
                echo "<a href=\"logout.php\">
                        <img src=\"loghi/logout.png\" alt=\"logoutLogo\" title=\"Logout\" style=\"float: right; height: 30px;\"/>
                      </a>";
            }
            ?>
            
            <!-- Stampiamo la possibilita' di registrarsi nel caso in cui l'utente non sia registrato nel database --> 
          
          <?php  
            if(!isset($_SESSION['userName'])){
             echo "<b>";
             echo "<br />  <br />" .$str2. "---> ";
             echo "</b>";
             
                echo "<a href=\"registrazione.php\">
                        <img src=\"loghi/userLogin.jpg\" alt=\"userLogo\" title=\"Login\" style=\"float: right; height: 30px;\"/>
                      </a>";
                      }
            ?>
        </p>
        
    <body style="background-color: lightyellow;">
		
		<table style="margin-left: auto; margin-right: auto;">
            <tbody>
                <tr>
                    <td>
                        <a href="index.php">
                            <img src="loghi/movieCamera.png" alt="camera logo" height="80"/>
                        </a>
                    </td>
                    <td> 
                        <h1>Eldoubleubet</h1>
                    </td>
                </tr>
            </tbody>
        </table>
        
        <?php

        // Inserisce la tabella con le categorie di film ed eventualmente anche il carrello se e' stato effettuato l'accesso
        require("./menuConSwitch.php");

        ?>


        <p>

        <table width="1000" cellpadding="10" style="margin-left: auto; margin-right: auto;">
            <tbody>
                <tr>
                    <td width="1000" style="background-color: white;">
                        <p>


                        </p>
                        <hr />
                        <h4>Chi siamo</h4>
                        <p> Eldoubleubet è un sito di scommesse online realizzato come progetto universitario da Sbordone F. e Tuzzolino R.</p>
                        <h4>Come registrarsi </h4>
                        <p> Per giocare con Eldoubleubet è necessario aprire un conto di gioco, aver compiuto 18 anni di età. 
							Il cliente deve quindi compilare il contratto nell'apposita sezione "Registrati".
							L'account dovrà essere poi attivato da un gestore del sito web. </p>
						<h4>Come ricaricare il conto </h4>
						<p> Per ricaricare il proprio conto bisogna inviare una richiesta formale nell'apposita sezione "Conto".
							La richiesta di accredito dovrà essere poi accettata da un gestore del sito web</p>
						<h4>Come giocare </h4>
						<p> Per piazzare una scommessa cliccare sulla sezione dello sport su cui si ha interesse.
							Il palinsesto comprende diversi sport quali: calcio, basket, tennis e Ippica.</p>
                        <hr />
                    </td>
                </tr>
            </tbody>
        </table>


    

        <p style="background-color: lightyellow; text-align: center;">
            <a href="">Italiano</a>
            |
            <a href="">English</a>
        </p>
        
        <footer style="background-color: lightgrey; text-align: center; height: 40px; padding: 20px;">
            Authors: Francesco Sbordone, Riccardo Tuzzolino
            <br />
            <em><a href="">webmaster@example.com</a></em>
        </footer>

        <footer style="background-color: grey; text-align: center; height: 20px; padding: 10px;">
            &copy; Copyright 2022 - 2023. All rights reserved.
        </footer>
        



    </body>

</html>
