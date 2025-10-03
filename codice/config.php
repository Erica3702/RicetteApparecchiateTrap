<?php
// File: config.php

// Credenziali per la connessione al database su AlterVista
$servername = "localhost"; // Per AlterVista, è sempre localhost
$username   = "ricetteapparecchiate"; // Il nome del tuo account AlterVista
$password   = "ceQMBdMKa9AH";   // La password che hai scelto per il database
$dbname     = "my_ricetteapparecchiate"; // Il nome del database, di solito my_username

// Creazione della connessione usando MySQLi
$conn = new mysqli($servername, $username, $password, $dbname);

// Controllo della connessione
if ($conn->connect_error) {
    // Se la connessione fallisce, mostra un errore e interrompi lo script
    die("Connessione al database fallita: " . $conn->connect_error);
}

// Imposta il set di caratteri a utf8 per supportare caratteri speciali e accentati
$conn->set_charset("utf8");

?>