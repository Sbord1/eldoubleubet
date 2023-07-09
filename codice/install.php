<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head><title>Creazione e Popolamento Eldoubleubet</title></head>

<body>
<h3>Creazione e Popolamento Eldoubleubet</h3>

<?php			
error_reporting(E_ALL &~E_NOTICE);

 // dati sul database e le tabelle (magari messi in un file a parte ...)
 $db_name = "Eldoubleubet";
 $DBuser_table = "DBuser";
 
///////////////////////////////////////////////////////////////////////////////
// effettuazione della connessione al database

$mysqliConnection = new mysqli("localhost", "riccardo", "password");

// controllo della connessione
if (mysqli_connect_errno()) {
    printf("Oops! Problemi con la connessione al db: %s\n", mysqli_connect_error());
    exit();
}
///////////////////////////////////////////////////////////////////////////////
// creazione del database

$queryCreazioneDatabase = "CREATE DATABASE IF NOT EXISTS $db_name";
// il risultato della query va in $resultQ
$resultQ = mysqli_query($mysqliConnection, $queryCreazioneDatabase);
if ($resultQ) {
    printf("Database %s creato!\n", $db_name);
}
else {
    printf("Whoops! Niente creazione del db!\n");
    exit();
}

// Adesso chiudiamo la connessione
$mysqliConnection->close();
///////////////////////////////////////////////////////////////////////////////

///////////////////////////////////////////////////////////////////////////////
// e la riapriamo con il collegamento alla base di dati
require_once("./connection.php");

// Creazione tabella utenti
$sqlQuery = "CREATE TABLE if not exists $DBuser_table (";
$sqlQuery.= "id int NOT NULL auto_increment, primary key (id), ";
$sqlQuery.= "nome varchar (50) NOT NULL, ";
$sqlQuery.= "cognome varchar (50) NOT NULL, ";
$sqlQuery.= "dataNascita varchar (50) NOT NULL, ";
$sqlQuery.= "username varchar (50) NOT NULL UNIQUE, ";
$sqlQuery.= "password varchar (32) NOT NULL, ";
$sqlQuery.= "credito float NOT NULL, ";
$sqlQuery.= "tipologia varchar(20) NOT NULL,";// scommettitore, gestore o admin
$sqlQuery.= "account varchar (15) NOT NULL, "; 
$sqlQuery.= "indirizzo varchar (100) NOT NULL, ";
$sqlQuery.= "telefono varchar (50) NOT NULL, ";
$sqlQuery.= "email varchar (100) NOT NULL, ";
$sqlQuery.= "codiceFiscale varchar (50) NOT NULL UNIQUE";    
$sqlQuery.= ");";

echo "<P>$sqlQuery</P>";

$resultQ = mysqli_query($mysqliConnection, $sqlQuery);
if ($resultQ)
    printf("Tabella Utenti creata!\n");
else {
    printf("Whoops! Niente creazione Tabella Utenti!\n");
  exit();
}


///////////////////////////////////////////////////////////////////////////////
// popolamento Tabella VOuser (NB tre campi: userId gestito automaticamente)

// Inserimento admin
$sql = "INSERT INTO $DBuser_table
	(nome, cognome, dataNascita, username, password, credito, tipologia, account, indirizzo, telefono, email, codiceFiscale)
	VALUES
	(\"Francesco\", \"Sbordone\", \"20/03/2001\", \"sbord1\", \"sbord1\", \"99999\", \"admin\", \"attivo\", \"via delle prate\", \"3234507689\", \"sbord1@gmail.com\", \"SBRFNC01C20D810E\")
	";
echo "<P>$sql</P>";

if ($resultQ = mysqli_query($mysqliConnection, $sql))
    printf("Utente inserito!\n");
else {
    printf("Whoops! Couldn't populate VOuser table.\n");
  exit();
}

// Inserimento admin
$sql = "INSERT INTO $DBuser_table
	(nome, cognome, dataNascita, username, password, credito, tipologia, account, indirizzo, telefono, email, codiceFiscale)
	VALUES
	(\"Riccardo\", \"Tuzzolino\", \"18/01/2002\", \"tuzzo18\", \"tuzzo18\", \"99999\", \"admin\", \"attivo\", \"via delle rose\", \"3210021246\", \"tuzzo18@gmail.com\", \"TZLRCR01D18B412P\")
	";
echo "<P>$sql</P>";

if ($resultQ = mysqli_query($mysqliConnection, $sql))
    printf("Utente inserito!\n");
else {
    printf("Whoops! Couldn't populate VOuser table.\n");
  exit();
}

// Inserimento gestore
$sql = "INSERT INTO $DBuser_table
	(nome, cognome, dataNascita, username, password, credito, tipologia, account, indirizzo, telefono, email, codiceFiscale)
	VALUES
	(\"Tizio\", \"Gracco\", \"30/05/1995\", \"tizio\", \"tizio\", \"99999\", \"gestore\", \"attivo\", \"via torrente\", \"3322578382\", \"tizio@gmail.com\", \"EMRSTC02D10D710E\")
	";
echo "<P>$sql</P>";

if ($resultQ = mysqli_query($mysqliConnection, $sql))
    printf("Utente inserito!\n");
else {
    printf("Whoops! Couldn't populate VOuser table.\n");
  exit();
}

// Inserimento gestore
$sql = "INSERT INTO $DBuser_table
	(nome, cognome, dataNascita, username, password, credito, tipologia, account, indirizzo, telefono, email, codiceFiscale)
	VALUES
	(\"Caio\", \"Gracco\", \"30/05/1995\", \"caio\", \"caio\", \"99999\", \"gestore\", \"attivo\", \"via aristotele\", \"3358457689\", \"caio@gmail.com\", \"CGRCFC11C10D560E\")
	";
echo "<P>$sql</P>";

if ($resultQ = mysqli_query($mysqliConnection, $sql))
    printf("Utente inserito!\n");
else {
    printf("Whoops! Couldn't populate VOuser table.\n");
  exit();
}

// Inserimento scommettitore
$sql = "INSERT INTO $DBuser_table
	(nome, cognome, dataNascita, username, password, credito, tipologia, account, indirizzo, telefono, email, codiceFiscale)
	VALUES
	(\"Mario\", \"Rossi\", \"09/03/2001\", \"mario\", \"mario\", \"50\", \"scommettitore\", \"attivo\", \"via aldo moro\", \"3652477689\", \"mario@gmail.com\", \"MRRRPS02C10D421R\")
	";
echo "<P>$sql</P>";

if ($resultQ = mysqli_query($mysqliConnection, $sql))
    printf("Utente inserito!\n");
else {
    printf("Whoops! Couldn't populate VOuser table.\n");
  exit();
}

// Inserimento scommettitore
$sql = "INSERT INTO $DBuser_table
	(nome, cognome, dataNascita, username, password, credito, tipologia, account, indirizzo, telefono, email, codiceFiscale)
	VALUES
	(\"Ciro\", \"Esposito\", \"28/02/1999\", \"ciruzzo\", \"ciruzzo\", \"250\", \"scommettitore\", \"attivo\", \"via tufetti\", \"3212457689\", \"ciruzzo@gmail.com\", \"CRZSPS02W20E810E\")
	";
echo "<P>$sql</P>";

if ($resultQ = mysqli_query($mysqliConnection, $sql))
    printf("Utente inserito!\n");
else {
    printf("Whoops! Couldn't populate VOuser table.\n");
  exit();
}
// altro modo di chiudere la connessione al db
mysqli_close($mysqliConnection);


?>

</body>
</html>
