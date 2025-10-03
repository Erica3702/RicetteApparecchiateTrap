<?php

// Credenziali per la connessione al database su AlterVista
$servername = "localhost";
$username   = "ricetteapparecchiate";
$password   = "ceQMBdMKa9AH";
$dbname     = "my_ricetteapparecchiate";

// Creazione della connessione usando MySQLi
$conn = new mysqli($servername, $username, $password, $dbname);

// Controllo della connessione
if ($conn->connect_error) {
    die("Connessione al database fallita: " . $conn->connect_error);
}

// Imposta il set di caratteri a utf8
$conn->set_charset("utf8");
?>