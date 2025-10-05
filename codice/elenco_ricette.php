<?php
include 'config.php';
include 'header.php';
include 'sidebar.php';

$filtro_libro_attivo = !empty($_GET['filtro_libro']);


$sql = "SELECT R.numero, R.titolo, R.tipo, GROUP_CONCAT(RG.nome SEPARATOR ', ') AS regioni,
               RP.numeroPagina, L.titolo AS titolo_libro
        FROM Ricetta R
        LEFT JOIN ricettaRegionale RR ON R.numero = RR.ricetta
        LEFT JOIN Regione RG ON RR.regione = RG.codice
        LEFT JOIN ricettaPubblicata RP ON R.numero = RP.numeroRicetta
        LEFT JOIN Libro L ON RP.libro = L.codISBN
        WHERE 1=1";

$params = [];
$types = "";

// GESTIONE DEI FILTRI 
if (!empty($_GET['filtro_nome'])) {
    $sql .= " AND R.titolo LIKE ?";
    $params[] = "%" . $_GET['filtro_nome'] . "%";
    $types .= "s";
}
if (!empty($_GET['filtro_categoria'])) {
    $sql .= " AND R.tipo = ?";
    $params[] = $_GET['filtro_categoria'];
    $types .= "s";
}
if (!empty($_GET['filtro_regione'])) {
    $sql .= " AND R.numero IN (SELECT ricetta FROM ricettaRegionale WHERE regione = ?)";
    $params[] = $_GET['filtro_regione'];
    $types .= "s";
}

if (!empty($_GET['filtro_libro'])) {
    $sql .= " AND L.codISBN = ?";
    $params[] = $_GET['filtro_libro'];
    $types .= "s";
}


$sql .= " GROUP BY R.numero, R.titolo, R.tipo, RP.numeroPagina, L.titolo ORDER BY R.titolo ASC";

$stmt = $conn->prepare($sql);

if ($stmt === false) {
    die("Errore nella preparazione della query: " . $conn->error);
}

if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}

$stmt->execute();
$result = $stmt->get_result();
?>

<main class="content" id="risultati">
    <h2>Elenco Ricette (clicca il nome per i dettagli)</h2>

    <table class="table-crud">
        <thead>
            <tr>
                <th>Titolo Ricetta</th>
                <th>Categoria</th>
                <th>Regione/i</th>
                <?php if (!$filtro_libro_attivo): ?>
                    <th>Libro</th>
                <?php endif; ?>
                <th>Numero Pagina</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo '<td><a href="dettaglio_ricetta.php?id=' . $row['numero'] . '">' . htmlspecialchars($row['titolo']) . '</a></td>';
                    echo "<td>" . htmlspecialchars($row['titolo']) . "</td>";
                    echo "<td>" . ($row['regioni'] ? htmlspecialchars($row['regioni']) : '<em>-</em>') . "</td>";
                    
                    if (!$filtro_libro_attivo) { 
                        echo "<td>" . ($row['titolo_libro'] ? htmlspecialchars($row['titolo_libro']) : '<em>-</em>') . "</td>";
                    }

                    echo "<td>" . ($row['numeroPagina'] ? htmlspecialchars($row['numeroPagina']) : '<em>-</em>') . "</td>";
                    
                    echo "</tr>";
                }
            } else {
                $colspan = $filtro_libro_attivo ? 4 : 5;
                echo '<tr><td colspan="' . $colspan . '">Nessuna ricetta trovata con i criteri specificati.</td></tr>';
            }
            ?>
        </tbody>
    </table>
</main>

<aside class="right-column"></aside>

<?php
include 'footer.php';
?>