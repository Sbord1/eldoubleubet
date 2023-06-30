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
    </head>

    <body style="background-color: lightyellow;">

        <table style="margin-left: auto; margin-right: auto;">
            <tbody>
                <tr>
                    <td>
                        <img src="loghi/soccer.png" alt="logo" height="80"/>
                    </td>
                    <td> 
                        <h1>Eldoubleubet</h1>
                    </td>
                </tr>
            </tbody>
        </table>

        <h3 style="text-align: center;">
            <hr />
            Grazie della visita! Torna a trovarci.
            <hr />
            <a href="index.php" alt="Home">Homepage</a>
        </h3>

    </body>

</html>
