<?php
include 'config.php';
include 'header.php';

// Determina l'azione in base al parametro GET nell'URL
$pageTitle = "Elenco dei Libri"; // Titolo di default
if (isset($_GET['action'])) {
    if ($_GET['action'] == 'delete') {
        $pageTitle = "Seleziona un Libro da Eliminare";
    } elseif ($_GET['action'] == 'edit') {
        $pageTitle = "Seleziona un Libro da Modificare";
    }
}
?>

<?php include 'sidebar.php'; ?>

<main class="content">
    <h2><?php echo $pageTitle; ?></h2> <?php
    // Gestione messaggi di successo
    if (isset($_GET['status'])) {
        if ($_GET['status'] == 'success') {
            echo '<p class="success-message">Libro salvato con successo!</p>';
        } elseif ($_GET['status'] == 'deleted') {
            echo '<p class="success-message">Libro eliminato con successo!</p>';
        }
    }
    ?>

    <table class="table-crud">
        <thead>
            <tr>
                <th>ISBN</th>
                <th>Titolo</th>
                <th>Anno</th>
                <th>Azioni</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = "SELECT codISBN, titolo, anno FROM Libro ORDER BY titolo ASC";
            $result = $conn->query($sql);

            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['codISBN']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['titolo']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['anno']) . "</td>";
                    echo '<td class="actions">';
                    echo '  <div class="button-container">'; // <-- Questo contenitore è fondamentale
                    echo '      <a href="modifica_libro_form.php?id=' . urlencode($row['codISBN']) . '" class="button-edit">Modifica</a>';
                    echo '      <a href="elimina_libro.php?id=' . urlencode($row['codISBN']) . '" class="button-delete" onclick="return confirm(\'Sei sicuro?\');">Elimina</a>';
                    echo '  </div>';
                    echo '</td>';
                    echo "</tr>";
                }
            } else {
                echo '<tr><td colspan="4">Nessun libro trovato nel database.</td></tr>';
            }
            ?>
        </tbody>
    </table>
</main>

<aside class="right-column"></aside>

<?php
include 'footer.php';
?>