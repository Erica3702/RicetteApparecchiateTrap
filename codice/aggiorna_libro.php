<?php
// 1. Includi la configurazione del database
include 'config.php';

// 2. Controlla che il form sia stato inviato con il metodo POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // 3. Recupera i dati inviati dal form
    $codISBN_originale = $_POST['codISBN_originale'];
    $titolo = $_POST['titolo'];
    $anno = $_POST['anno'];

    // 4. Prepara la query SQL di UPDATE in modo sicuro
    $sql = "UPDATE Libro SET titolo = ?, anno = ? WHERE codISBN = ?";
    
    $stmt = $conn->prepare($sql);
    
    // Collega i parametri (s = stringa, i = intero)
    $stmt->bind_param("sis", $titolo, $anno, $codISBN_originale);

    // 5. Esegui la query
    if ($stmt->execute()) {
        // Se l'aggiornamento ha successo, reindirizza all'elenco dei libri con un messaggio
        header("Location: elenco_libri.php?status=success_update");
        exit();
    } else {
        // Altrimenti, mostra un messaggio di errore
        echo "Errore durante l'aggiornamento del libro: " . $stmt->error;
    }

    // 6. Chiudi lo statement
    $stmt->close();

} else {
    // Se qualcuno cerca di accedere a questo file direttamente, mostra un errore
    echo "Metodo di richiesta non valido.";
}

// 7. Chiudi la connessione
$conn->close();
?>