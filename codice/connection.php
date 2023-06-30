<?php

  ini_set('display_errors', 1);
  error_reporting(E_ALL);

  // dati sul database e le tabelle (magari messi in un file a parte ...)
  $db_name = "Eldoubleubet";
  $DBuser_table = "DBuser";
  
  // mysqli: oggetto la cui creazione corrisponde all'effettuazione della connessione al database
  // localhost e' l'host su cui gira il dbms MySQL;
  // riccardo, con password password e' un esempio di utente mysql (registrato sul dbms con la possibilita' di accedere ad alcune basi di dati).
  $mysqliConnection = new mysqli("localhost", "riccardo", "password", $db_name);

  // Controllo della connessione
  // mysqli_errno() and mysqli_error() restituiscono codici e messaggi relativi all'ultimo errore
  if (mysqli_connect_errno()) {
      printf("Errore! Problemi con la connessione al db: %s\n", mysqli_connect_error());
      exit();
  }

?>