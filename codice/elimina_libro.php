<?php
// 1. Includi il file di configurazione per la connessione al database
include 'config.php';

// 2. Controlla se l'ID del libro è stato passato tramite l'URL
if (isset($_GET['id'])) {
    $codISBN = $_GET['id'];

    // 3. Prepara la query SQL in modo sicuro usando i Prepared Statements
    // NOTA: Usa 'Libro' con la L maiuscola, come nella tua tabella
    $sql = "DELETE FROM Libro WHERE codISBN = ?";
    
    $stmt = $conn->prepare($sql);

    // Collega il parametro codISBN (s = stringa)
    $stmt->bind_param("s", $codISBN);

    // 4. Esegui la query
    if ($stmt->execute()) {
        // Se l'eliminazione ha successo, torna all'elenco con un messaggio
        header("Location: elenco_libri.php?status=deleted");
        exit();
    } else {
        // Se c'è un errore, mostralo
        echo "Errore durante l'eliminazione del libro: " . $stmt->error;
    }

    // 5. Chiudi lo statement
    $stmt->close();

} else {
    // Se non è stato fornito un ID, mostra un messaggio di errore
    echo "ID del libro non specificato.";
}

// 6. Chiudi la connessione
$conn->close();
?>