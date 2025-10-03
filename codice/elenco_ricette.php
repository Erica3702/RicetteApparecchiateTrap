<?php
include 'config.php';
include 'header.php';
include 'sidebar.php';

// QUERY DI BASE
$sql = "SELECT R.titolo, R.tipo, GROUP_CONCAT(RG.nome SEPARATOR ', ') AS regioni
        FROM Ricetta R
        LEFT JOIN ricettaRegionale RR ON R.numero = RR.ricetta
        LEFT JOIN Regione RG ON RR.regione = RG.codice
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

$sql .= " GROUP BY R.numero, R.titolo, R.tipo ORDER BY R.titolo ASC";

// ESECUZIONE DELLA QUERY
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


<main class="content">
    <h2>Elenco Ricette</h2>

    <table class="table-crud">
        <thead>
            <tr>
                <th>Titolo Ricetta</th>
                <th>Categoria</th>
                <th>Regione/i</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['titolo']) . "</td>";
                    echo "<td>" . htmlspecialchars(ucfirst($row['tipo'])) . "</td>";
                    echo "<td>" . ($row['regioni'] ? htmlspecialchars($row['regioni']) : '<em>Nessuna</em>') . "</td>";
                    echo "</tr>";
                }
            } else {
                echo '<tr><td colspan="3">Nessuna ricetta trovata con i criteri specificati.</td></tr>';
            }
            ?>
        </tbody>
    </table>
</main>

<aside class="right-column"></aside>

<?php
include 'footer.php';
?>