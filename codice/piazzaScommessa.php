<?php

	/*
	Per permettere ad un utente scommettitore di piazzare una scommessa dobbiamo:
	- Verificare che il conto dell'utente scommettitore sia maggiore dell'importo che l'utente vuole giocare sulla scommessa
	- Aggiornare il conto dell'utente, detraendo l'importo giocato, nel caso di verifica positiva
	- Modificare il file xml (relativo allo sport su cui si e' scommesso) contenente le scommesse giocate dagli utenti scommettitori
	  aggiungendo la nuova scommessa appena piazzata dall'utente
	*/

	session_start();

	// Se non e' stato eseguito il login si viene reindirizzati alla pagina di login
	if (!isset($_SESSION['accessoPermesso'])) header('Location: loginPage.html');

?>

<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

	<head>
		<title>Piazza scommessa</title>
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
		border: 5px outset red;
		}
		
		h1 {
		text-align: center;
		color: #333333;
		}

		h2 {
		text-align: center;
		color: #333333;
		}
		
		p {
		text-align: center;
		color: #666666;
		}

		h4 {
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

		tr {
			background-color: rgb(228, 240, 245);
			height: 30px;
			text-align:center;
		}

  		td.head{
  		 	background-color: #FDEBD0;
			text-align: center;
  		}

		.tablecenter{
			padding: 10px;
			margin-right: auto;
			margin-left: auto;
			width: 75%;
			padding-bottom: 15px;	
		}

		.link-button {
			background: none;
			border: none;
			color: black;
			cursor: pointer;
			text-decoration: underline;
			font-size: 1em;
			font-family: serif;
		}
		</style>

	</head>

	<body>

	<header>

		<div>
		<table style="margin-left: auto; margin-right: auto;">
			<tbody>
				<tr style="background-color: transparent;">
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

	</header>

		<?php

		$username = $_SESSION['userName'];

		// Sfruttiamo l'hidden field inserito nelle quote per stabilire di quale sport si tratta e quindi conoscere le variabili disponibili
		// Infatti, in base allo sport, abbiamo a  disposizione variabili differenti ma utilizziamo un unico script php per piazzare le scommesse

		switch($_POST['category']) {

			case "calcio":
				// variabili disponibili
				$squadraCasa = $_POST['squadraCasa'];
				$squadraTrasferta = $_POST['squadraTrasferta'];
				$quota = $_POST['quota'];
				$risultato = $_POST['risultato'];
				$idPartita = $_POST['idPartita'];

				echo "<h2 style=\"text-align: center;\">Inserisci l'importo per piazzare la scommessa:</h2>";

				echo "<hr />";

				echo "
				<div class=\"container\">

					<h1>ID partita: $idPartita</h1>\n

					<h2>$squadraCasa - $squadraTrasferta</h2>\n

					<h4>Risultato: $risultato</h4>\n

					<h4>Quota: $quota</h4>\n

					<form action=\"pagaScommessa.php\" method=\"post\">
						<h4 style=\"text-align: center;\">
							Importo: <input type=\"number\" name=\"puntata\" value=\"1\" min=\"1\" max=\"9999\" size=\"10\"> &euro;
						</h4>
						<div style=\"text-align: center; padding: 10px\">
							<input type=\"hidden\" name=\"idPartita\" value=\"$idPartita\">
							<input type=\"hidden\" name=\"quota\" value=\"$quota\">
							<input type=\"hidden\" name=\"risultato\" value=\"$risultato\">
							<input type=\"hidden\" name=\"category\" value=\"calcio\">
							<input type=\"submit\" name=\"invio\" value=\"Scommetti\">
						</div>
					</form>

				</div>";

				echo "<hr />";

				echo "
					<p style=\"text-align: center;\">
						<a href=\"calcio.php\">Go Back</a>
					</p>
				";

				break;

			case "basket":
				// variabili disponibili
				$squadraCasa = $_POST['squadraCasa'];
				$squadraTrasferta = $_POST['squadraTrasferta'];
				$quota = $_POST['quota'];
				$risultato = $_POST['risultato'];
				$idPartita = $_POST['idPartita'];

				echo "<h2 style=\"text-align: center;\">Inserisci l'importo per piazzare la scommessa:</h2>";

				echo "<hr />";

				echo "
				<div class=\"container\">

					<h1>ID partita: $idPartita</h1>\n

					<h2>$squadraCasa - $squadraTrasferta</h2>\n

					<h4>Risultato: $risultato</h4>\n

					<h4>Quota: $quota</h4>\n

					<form action=\"pagaScommessa.php\" method=\"post\">
						<h4 style=\"text-align: center;\">
							Importo: <input type=\"number\" name=\"puntata\" value=\"1\" min=\"1\" max=\"9999\" size=\"10\"> &euro;
						</h4>
						<div style=\"text-align: center; padding: 10px\">
							<input type=\"hidden\" name=\"idPartita\" value=\"$idPartita\">
							<input type=\"hidden\" name=\"quota\" value=\"$quota\">
							<input type=\"hidden\" name=\"risultato\" value=\"$risultato\">
							<input type=\"hidden\" name=\"category\" value=\"basket\">
							<input type=\"submit\" name=\"invio\" value=\"Scommetti\">
						</div>
					</form>

				</div>";

				echo "<hr />";

				echo "
					<p style=\"text-align: center;\">
						<a href=\"basket.php\">Go Back</a>
					</p>
				";
				break;

			case "tennis":
				// variabili disponibili
				$giocatoreCasa = $_POST['giocatoreCasa'];
				$giocatoreTrasferta = $_POST['giocatoreTrasferta'];
				$quota = $_POST['quota'];
				$risultato = $_POST['risultato'];
				$idPartita = $_POST['idPartita'];

				echo "<h2 style=\"text-align: center;\">Inserisci l'importo per piazzare la scommessa:</h2>";

				echo "<hr />";

				echo "
				<div class=\"container\">

					<h1>ID partita: $idPartita</h1>\n

					<h2>$giocatoreCasa - $giocatoreTrasferta</h2>\n

					<h4>Risultato: $risultato</h4>\n

					<h4>Quota: $quota</h4>\n

					<form action=\"pagaScommessa.php\" method=\"post\">
						<h4 style=\"text-align: center;\">
							Importo: <input type=\"number\" name=\"puntata\" value=\"1\" min=\"1\" max=\"9999\" size=\"10\"> &euro;
						</h4>
						<div style=\"text-align: center; padding: 10px\">
							<input type=\"hidden\" name=\"idPartita\" value=\"$idPartita\">
							<input type=\"hidden\" name=\"quota\" value=\"$quota\">
							<input type=\"hidden\" name=\"risultato\" value=\"$risultato\">
							<input type=\"hidden\" name=\"category\" value=\"tennis\">
							<input type=\"submit\" name=\"invio\" value=\"Scommetti\">
						</div>
					</form>

				</div>";

				echo "<hr />";

				echo "
					<p style=\"text-align: center;\">
						<a href=\"tennis.php\">Go Back</a>
					</p>
				";
				break;

			case "ippica":
				// variabili disponibili
				$idPartita = $_POST['idPartita'];
				$nomeCavallo = $_POST['cavallo'];
				$quota = $_POST['quota'];
				$numeroCavallo = $_POST['numero'];
				$risultato = $_POST['risultato'];

				echo "<h2 style=\"text-align: center;\">Inserisci l'importo per piazzare la scommessa:</h2>";

				echo "<hr />";

				echo "
				<div class=\"container\">

					<h1>ID corsa: $idPartita</h1>\n

					<h4>Risultato: cavallo #$numeroCavallo arriva $risultato&deg;</h4>\n

					<h4>Quota: $quota</h4>\n

					<form action=\"pagaScommessa.php\" method=\"post\">
						<h4 style=\"text-align: center;\">
							Importo: <input type=\"number\" name=\"puntata\" value=\"1\" min=\"1\" max=\"9999\" size=\"10\"> &euro;
						</h4>
						<div style=\"text-align: center; padding: 10px\">
							<input type=\"hidden\" name=\"idPartita\" value=\"$idPartita\">
							<input type=\"hidden\" name=\"quota\" value=\"$quota\">
							<input type=\"hidden\" name=\"numero\" value=\"$numeroCavallo\">
							<input type=\"hidden\" name=\"risultato\" value=\"$risultato\">
							<input type=\"hidden\" name=\"category\" value=\"ippica\">
							<input type=\"submit\" name=\"invio\" value=\"Scommetti\">
						</div>
					</form>

				</div>";

				echo "<hr />";

				echo "
					<p style=\"text-align: center;\">
						<a href=\"ippica.php\">Go Back</a>
					</p>
				";


				break;

			default:
				echo "Errore!";
				exit();
		}


		?>


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
