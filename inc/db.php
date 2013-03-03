<?php
session_start();
$db_username = "polivane_bombs";
$db_password = "bombs1734";
try {
    $db = new PDO('mysql:host=localhost;dbname=polivane_bombs', $db_username, $db_password);
} catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
}
try {
    $db_second = new PDO('mysql:host=localhost;dbname=polivane_bombs', $db_username, $db_password);
} catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
}
?>