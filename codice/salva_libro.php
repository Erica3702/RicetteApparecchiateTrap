<?php
// 1. Includi la configurazione del database
include 'config.php';

// 2. Controlla che il form sia stato inviato
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $codISBN = $_POST['codISBN'];
    $titolo = $_POST['titolo'];
    $anno = $_POST['anno'];

    $sql = "INSERT INTO Libro (codISBN, titolo, anno) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $codISBN, $titolo, $anno);

    // 5. Esegui la query
    if ($stmt->execute()) {
        // LA MODIFICA È QUI: reindirizza a index.php con un messaggio di successo
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