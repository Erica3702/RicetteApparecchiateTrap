<?php
include 'config.php';
include 'header.php';
include 'sidebar.php';

// 1. Controlla se l'ID del libro è stato passato tramite URL
if (!isset($_GET['id'])) {
    echo "ID del libro non specificato.";
    exit(); // Interrompe lo script se non c'è un ID
}

$codISBN = $_GET['id'];

// 2. Recupera i dati attuali del libro dal database
$sql = "SELECT titolo, anno FROM Libro WHERE codISBN = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $codISBN);
$stmt->execute();
$result = $stmt->get_result();
$libro = $result->fetch_assoc();

// Se non viene trovato nessun libro con quell'ID, mostra un errore
if (!$libro) {
    echo "Libro non trovato.";
    exit();
}

$stmt->close();
?>

<main class="content">
    <h2>Modifica Libro</h2>
    
    <form action="aggiorna_libro.php" method="POST" class="form-crud">
        
        <input type="hidden" name="codISBN_originale" value="<?php echo htmlspecialchars($codISBN); ?>">

        <div class="form-group">
            <label for="codISBN">Codice ISBN (non modificabile)</label>
            <input type="text" id="codISBN" name="codISBN" value="<?php echo htmlspecialchars($codISBN); ?>" readonly>
        </div>

        <div class="form-group">
            <label for="titolo">Titolo</label>
            <input type="text" id="titolo" name="titolo" value="<?php echo htmlspecialchars($libro['titolo']); ?>" required>
        </div>

        <div class="form-group">
            <label for="anno">Anno di Pubblicazione</label>
            <input type="number" id="anno" name="anno" min="1000" max="2099" value="<?php echo htmlspecialchars($libro['anno']); ?>" required>
        </div>

        <button type="submit" class="button-primary">Aggiorna Libro</button>
    </form>
</main>

<aside class="right-column"></aside>

<?php
include 'footer.php';
?>