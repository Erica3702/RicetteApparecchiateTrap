<?php
// configurazione del database
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $codISBN = $_POST['codISBN'];
    $titolo = $_POST['titolo'];
    $anno = $_POST['anno'];

    // Prima di inserire, controlla se esiste già un libro con questo ISBN
    $check_sql = "SELECT codISBN FROM Libro WHERE codISBN = ?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("s", $codISBN);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();

    if ($check_result->num_rows > 0) {
        // Se la query restituisce una o più righe, significa che il libro esiste già.
        // Reindirizza l'utente alla pagina di creazione con un messaggio di errore.
        header("Location: crea_libro.php?status=error_duplicate");
        exit(); 
    }
    
    $check_stmt->close();
   

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