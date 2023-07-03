<?php
session_start();

?>

<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Proponi scommessa</title>
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

    .forum-btn {
      display: inline-block;
      margin-left: 5px;
      padding: 5px 10px;
      background-color: #007bff;
      color: #ffffff;
      border-radius: 4px;
    }

    .forum-btn:hover {
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

    <hr />

    <h3 style="text-align: center; color: white;">Seleziona una categoria dal men&ugrave; in basso per proporre la relativa scommessa.</h3>

    <nav>
      <ul>
        <li>
            <form method="post" action="proposteScommessaCalcio.php">
                <button type="submit" name="category" value="calcio" class="forum-btn">Calcio</button>
            </form>
        </li>
        |
        <li>
            <form method="post" action="proposteScommessaBasket.php">
                <button type="submit" name="category" value="basket" class="forum-btn">Basket</button>
            </form>
        </li>
        |
        <li>
            <form method="post" action="proposteScommessaTennis.php">
                <button type="submit" name="category" value="tennis" class="forum-btn">Tennis</button>
            </form>
        </li>
        |
        <li>
            <form method="post" action="proposteScommessaIppica.php">
                <button type="submit" name="category" value="ippica" class="forum-btn">Ippica</button>
            </form>
        </li>
      </ul>
    </nav>

    </header>



        <h3 style="text-align: center;">
            <a href="inizio.php" alt="Home">Homepage</a>
        </h3>

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
