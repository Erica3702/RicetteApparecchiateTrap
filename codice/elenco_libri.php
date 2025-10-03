<?php
// Includiamo i file di base per mantenere il layout della pagina
include 'config.php';
include 'header.php';
?>

<?php include 'sidebar.php'; ?>

<main class="content">
    <h2>Elenco dei Libri</h2>

    <?php
    // Mostra un messaggio di successo se un'operazione è andata a buon fine
    if (isset($_GET['status']) && $_GET['status'] == 'success') {
        echo '<p class="success-message">Operazione completata con successo!</p>';
    }
    ?>

    <table class="table-crud">
        <thead>
            <tr>
                <th>ISBN</th>
                <th>Titolo</th>
                <th>Anno</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // 1. Prepara ed esegui la query per selezionare tutti i libri
            $sql = "SELECT codISBN, titolo, anno FROM Libro ORDER BY titolo ASC";
            $result = $conn->query($sql);

            // 2. Controlla se ci sono risultati
            if ($result && $result->num_rows > 0) {
                // 3. Itera sui risultati e stampa una riga per ogni libro
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['codISBN']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['titolo']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['anno']) . "</td>";
                    echo "</tr>";
                }
            } else {
                // Se non ci sono libri, mostra un messaggio (colspan="3" perché ora ci sono 3 colonne)
                echo '<tr><td colspan="3">Nessun libro trovato nel database.</td></tr>';
            }
            ?>
        </tbody>
    </table>

</main>

<aside class="right-column"></aside>

<?php
// Includi il footer per chiudere la pagina
include 'footer.php';
?>