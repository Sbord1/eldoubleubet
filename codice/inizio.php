<?php
	ini_set('display_errors', 1);
	error_reporting(E_ALL);

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
  
  <div class="container">
    <h1>Benvenuto nel sito di scommesse ELDOUBLEUBET!</h1>
    <p>Inizia subito a scommettere su eventi sportivi.</p>
  </div>

  <table width="1000" cellpadding="10" style="margin-left: auto; margin-right: auto; padding-bottom: 30px;">
    <tbody>
        <tr>
            <td width="1000" style="background-color: white;">
                <p>
                <?php 
                // Se non e' stato fatto il login stampiamo "Benvenuto visitatore!"
                if(!isset($_SESSION['userName']))
                    echo "Benvenuto visitatore!";
                // Altrimenti stampiamo il nome dell'utente e l'ora a cui si e' collegato
                else {
                    echo "Benvenuto <b>".$_SESSION['userName']."</b>! ";
                    echo "Ti sei collegato alle <b>".date('g:i a', $_SESSION['dataLogin'])."</b>.";
                }
                ?> 
                </p>
                <p>In questo sito troverai una lista di possibili scommesse, suddivise per sport.</p>
                <hr />
                <p>Per ogni sport, cliccando sulla categoria, potrai piazzare una scommessa.</p>
                <hr />
                <p>Per saperne di pi&ugrave; su come funziona il sito web, dirigiti nella sezione "Info Generali" nel men&ugrave; in alto.</p>
                <hr />
                <p>Gioca responsabilmente!</p>
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
  
  <?php
 
	if (isset($_SESSION['warning']) && $_SESSION['warning'] == 1){
  		
  		echo("
        	<script type=\"text/javascript\">
      			alert(\"You must be 18 years old or over to start betting!\");
  			</script>"
  			);
  		$_SESSION['warning'] = 0;
		}
	?>
</body>
</html>
