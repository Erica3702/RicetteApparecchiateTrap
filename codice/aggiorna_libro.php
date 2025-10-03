<?php
// configurazione del database
include 'config.php';

// inviato con il metodo POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    //  Recupera i dati
    $codISBN_originale = $_POST['codISBN_originale'];
    $titolo = $_POST['titolo'];
    $anno = $_POST['anno'];

    // query SQL di UPDATE 
    $sql = "UPDATE Libro SET titolo = ?, anno = ? WHERE codISBN = ?";
    
    $stmt = $conn->prepare($sql);
    
    // Collega i parametri (s = stringa, i = intero)
    $stmt->bind_param("sis", $titolo, $anno, $codISBN_originale);

   
    if ($stmt->execute()) {
        // Se l'aggiornamento ha successo, reindirizza all'elenco dei libri con un messaggio
        header("Location: elenco_libri.php?status=success_update");
        exit();
    } else {
        // Altrimenti, mostra un messaggio di errore
        echo "Errore durante l'aggiornamento del libro: " . $stmt->error;
    }

    $stmt->close();

} else {
    // Se qualcuno cerca di accedere a questo file direttamente, mostra un errore
    echo "Metodo di richiesta non valido.";
}

$conn->close();
?>