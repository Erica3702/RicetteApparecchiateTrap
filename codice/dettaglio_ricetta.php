<?php
include 'config.php';
include 'header.php';
include 'sidebar.php';

// Recupera e valida l'ID della ricetta dall'URL
$ricetta_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($ricetta_id === 0) {
    die("ID della ricetta non valido.");
}

// Recupera i dettagli principali della ricetta (per mostrare il titolo)
$sql_ricetta = "SELECT titolo FROM Ricetta WHERE numero = ?";
$stmt_ricetta = $conn->prepare($sql_ricetta);
$stmt_ricetta->bind_param("i", $ricetta_id);
$stmt_ricetta->execute();
$result_ricetta = $stmt_ricetta->get_result();
$ricetta = $result_ricetta->fetch_assoc();

if (!$ricetta) {
    die("Ricetta non trovata.");
}

//Recupera l'elenco degli ingredienti per quella ricetta
$sql_ingredienti = "SELECT ingrediente, quantità FROM Ingrediente WHERE numeroRicetta = ? ORDER BY numero ASC";
$stmt_ingredienti = $conn->prepare($sql_ingredienti);
$stmt_ingredienti->bind_param("i", $ricetta_id);
$stmt_ingredienti->execute();
$result_ingredienti = $stmt_ingredienti->get_result();

?>

<main class="content">
    
    <h2>Dettagli per: <?php echo htmlspecialchars($ricetta['titolo']); ?></h2>

    <div class="dettaglio-container">
        <h3>Ingredienti</h3>
        
        <?php if ($result_ingredienti->num_rows > 0): ?>
            <div class="ingredienti-lista">
                <ul>
                    <?php while ($ingrediente = $result_ingredienti->fetch_assoc()): ?>
                        <li>
                            <span class="nome-ingrediente"><?php echo htmlspecialchars($ingrediente['ingrediente']); ?></span>
                            <span class="quantita-ingrediente"><?php echo htmlspecialchars($ingrediente['quantità']); ?></span>
                        </li>
                    <?php endwhile; ?>
                </ul>
            </div>
        <?php else: ?>
            <p>Nessun ingrediente trovato per questa ricetta.</p>
        <?php endif; ?>
    </div>

    <a href="elenco_ricette.php" class="button-secondary" style="margin-top: 20px;">Torna all'elenco</a>

</main>

<aside class="right-column"></aside>

<?php
include 'footer.php';
?>