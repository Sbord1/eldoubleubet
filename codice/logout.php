<?php
    ini_set('display_errors', 1);
    error_reporting(E_ALL);

    // Session deletion
    session_start();
    // Cancellazione delle variabili in $_SESSION
    unset($_SESSION);
    // Rimozione dal server
    session_destroy();
?>

<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

    <head>
        <title>Logout - Eldoubleubet</title>
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

        <h3 style="text-align: center;">
            <hr />
            Grazie della visita! Torna a trovarci.
            <hr />
            <a href="inizio.php" alt="Home">Homepage</a>
        </h3>

    </body>

</html>
