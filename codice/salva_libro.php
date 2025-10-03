<?php
// configurazione del database
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $codISBN = $_POST['codISBN'];
    $titolo = $_POST['titolo'];
    $anno = $_POST['anno'];

    $sql = "INSERT INTO Libro (codISBN, titolo, anno) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $codISBN, $titolo, $anno);

    //Esegue la query
    if ($stmt->execute()) {
        header("Location: index.php?status=success_create");
        exit();
    } else {
        // Altrimenti, mostra un errore
        echo "Errore: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>