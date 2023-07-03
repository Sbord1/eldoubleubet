<?php

	require_once("./connection.php");

  // Una volta che siamo nel db, verifichiamo cosa e' stato passato come username e pwd e facciamo una query per controllare
  if (isset($_POST['invio'])) // abbiamo appena inviato dati attraverso la form di login

    if (empty($_POST['userName']) || empty($_POST['password'])) {
      echo "<p>Dati mancanti! Inserire username o password.</p>";
    }

    else {                             
      // CONTROLLO DATI: controlliamo se username e password ricevuti corrispondono a quelli presenti nella tabella VOuser
      // questa e' la query di controolo
      $sqlQuery = "SELECT * FROM $DBuser_table
                  WHERE username = \"{$_POST['userName']}\"
                  AND
                  password =\"{$_POST['password']}\"
                  ";
      // mysqli_query() esegue sul db, cui siamo connessi, la query passata.
      // Il risultato e' un array php, contenente le righe della tabella che sono state selezionate
      // Il risultato ("result set") della query va in $resultQ
      if (!$resultQ = mysqli_query($mysqliConnection, $sqlQuery)) {
          printf("Oops! La query inviata non ha avuto successo!\n");
      exit();
      }

      // prendiamo una riga dal risultato (in questo caso il risultato ha una sola
      // riga perche' c'e' un solo utente, se c'e', corrsipondente ai dati, ma in
      // altre occasioni il risultato potrebbe essere un insieme di righe distinte
      // della tabella ...
      // la funzione restituisce un array (anche associativo per default)
      // con i valori della riga selezionata, oppure NULL - se non c'e' la riga
      $row = mysqli_fetch_array($resultQ);

      if ($row) {   // utente esiste valido --> Accesso permesso!
        // Session creation
        session_start();
        // In PHP le variabili di sessione sono rese disponibili nell'array $_SESSION
        $_SESSION['userName']=$_POST['userName']; //registrazione e assegnazione di una variabile di sessione
        $_SESSION['dataLogin']=time();
        $_SESSION['numeroUtente']=$row['id'];
        // Consentiremo all'utente di scommettere solo se il suo account e' attivo
        $_SESSION['status']=$row['account'];
        $_SESSION['accessoPermesso']=1000;
        // Utilizziamo la query per estrarre il valore di tipologia
        $_SESSION['tipologia']=$row['tipologia'];
        // N.B. userId, userName, password, sommeSpese e tipologia sono tutte colonne della tabella VOuser creata nel file mysql.VO1.php
        // --> per questo motivo l'array $row ha questi indici.
        // Ridirezionamento alla pagina iniziale index.php
        header('Location: inizio.php');
        exit();
      }
      else
      echo "<p>Accesso negato!</p>";
    }

?>
