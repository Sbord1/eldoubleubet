<?php

	session_start();

	// Se non e' stato eseguito il login si viene reindirizzati alla pagina di login
	if (!isset($_SESSION['accessoPermesso'])) header('Location: loginPage.html');

// variabili scommessa
	$squadraCasa=$_POST['squadraCasa'];
	$squadraTrasferta=$_POST['squadraTrasferta'];
	$quota=$_POST['quota'];


    //creo output table
    
    $output_table="<p style=\" position: absolute; font-size: 21px; color: white; margin-top:5%; left:30%\"> Gentile signore";
	$output_table.=",\n vuoi piazziare una scommessa?\n <br /> <br />";
	$output_table.="$squadraCasa - $squadraTrasferta\n <br />";
	$output_table.="Quota: $quota\n <br />";
	$output_table.="Importo: ";
	$output_table.="<input type=\"number\" name=\"puntata\" value=\"1\" min=\"1\" max=\"9999\" size=\"10\">";
	$output_table.="&euro;";

	$output_table.="</tr>\n";                 
	$output_table.="</table>\n";
 



?>

<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE html
PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<title>Informazioni film</title>
	</head>

	<body style= "background-color: #34495E" >

		<hr />

	
		<?php
			echo ($output_table);
			
		?>
	<br /> <br />
	
	<p style="position: absolute; bottom:40%; left: 30%; font-size: 25px; color: white">
		 <a href="calcio.php" style="color:#FDEBD0">Home</a></p>

	</body>
</html>
