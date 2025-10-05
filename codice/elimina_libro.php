<?php
// file di configurazione per la connessione al database
include 'config.php';

// Controlla se l'ID del libro è stato passato tramite l'URL
if (isset($_GET['id'])) {
    $codISBN = $_GET['id'];
    $sql = "DELETE FROM Libro WHERE codISBN = ?";
    
    $stmt = $conn->prepare($sql);

    // Collega il parametro codISBN (s = stringa)
    $stmt->bind_param("s", $codISBN);

    if ($stmt->execute()) {
        // Se l'eliminazione ha successo, torna all'elenco con un messaggio
        header("Location: elenco_libri.php?status=deleted");
        exit();
    } else {
        echo "Errore durante l'eliminazione del libro: " . $stmt->error;
    }

    $stmt->close();

} else {
    // Se non è stato fornito un ID, mostra messaggio
    echo "ID del libro non specificato.";
}

$conn->close();
?>