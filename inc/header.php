<?php include_once 'inc/db.php'; ?>
<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta charset="utf-8" />
        <title>Big Bombs</title>
        <link href="style/style.css" rel="stylesheet" />
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
            <script src="js/jquery-1.9.1.min.js"></script>
            <script src="js/scripts.js"></script>
    </head>
    <body>
        <div id="wrapper"> 
            <header>
                <nav>
                    <ul><li <?php if ($_SERVER['PHP_SELF'] == '/index.php') echo 'class="current"'; ?>><a href="index.php">Rules</a>
                        </li><li <?php if ($_SERVER['PHP_SELF'] == '/attack.php') echo 'class="current"'; ?>><a href="attack.php">Attack</a>
                        </li><li <?php if ($_SERVER['PHP_SELF'] == '/defense.php') echo 'class="current"'; ?>><a href="defense.php">Defense</a>
                        </li><li <?php if ($_SERVER['PHP_SELF'] == '/multiplayer.php') echo 'class="current"'; ?>><a href="multiplayer.php">Multiplayer</a>
                        </li><li <?php if ($_SERVER['PHP_SELF'] == '/hall_of_fame.php') echo 'class="current"'; ?>><a href="hall_of_fame.php">Hall of Fame</a></li>
                    </ul>
                </nav>
            </header>
