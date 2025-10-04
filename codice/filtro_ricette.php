<?php


// Recupera tutte le regioni per popolare il menu a tendina
$sql_regioni = "SELECT codice, nome FROM Regione ORDER BY nome ASC";
$result_regioni = $conn->query($sql_regioni);

// Recupera tutti i libri per popolare il menu a tendina
$sql_libri = "SELECT codISBN, titolo FROM Libro ORDER BY titolo ASC"; 
$result_libri = $conn->query($sql_libri);

// Recupera i valori dei filtri attuali dall'URL per pre-selezionare le opzioni
$filtro_nome_attuale = isset($_GET['filtro_nome']) ? htmlspecialchars($_GET['filtro_nome']) : '';
$filtro_categoria_attuale = isset($_GET['filtro_categoria']) ? $_GET['filtro_categoria'] : '';
$filtro_regione_attuale = isset($_GET['filtro_regione']) ? $_GET['filtro_regione'] : '';
$filtro_libro_attuale = isset($_GET['filtro_libro']) ? $_GET['filtro_libro'] : '';
?>

<div class="filter-container">
    <h4>Filtra Ricette</h4>
    <form action="elenco_ricette.php" method="GET" class="filter-form">
        <div class="form-group">
            <label for="filtro_nome">Nome Ricetta</label>
            <input type="text" id="filtro_nome" name="filtro_nome" value="<?php echo $filtro_nome_attuale; ?>">
        </div>

        <div class="form-group">
            <label for="filtro_categoria">Categoria</label>
            <select id="filtro_categoria" name="filtro_categoria">
                <option value="">Tutte</option>
                <option value="antipasto" <?php if ($filtro_categoria_attuale == 'antipasto') echo 'selected'; ?>>Antipasto</option>
                <option value="primo" <?php if ($filtro_categoria_attuale == 'primo') echo 'selected'; ?>>Primo</option>
                <option value="secondo" <?php if ($filtro_categoria_attuale == 'secondo') echo 'selected'; ?>>Secondo</option>
                <option value="contorno" <?php if ($filtro_categoria_attuale == 'contorno') echo 'selected'; ?>>Contorno</option>
                <option value="dessert" <?php if ($filtro_categoria_attuale == 'dessert') echo 'selected'; ?>>Dessert</option>
            </select>
        </div>

        <div class="form-group">
            <label for="filtro_regione">Regione</label>
            <select id="filtro_regione" name="filtro_regione">
                <option value="">Tutte</option>
                <?php
                if ($result_regioni->num_rows > 0) {
                    while ($regione = $result_regioni->fetch_assoc()) {
                        $selected = ($filtro_regione_attuale == $regione['codice']) ? 'selected' : '';
                        echo '<option value="' . $regione['codice'] . '" ' . $selected . '>' . htmlspecialchars($regione['nome']) . '</option>';
                    }
                }
                ?>
            </select>
        </div>

        <div class="form-group">
            <label for="filtro_libro">Ricettario</label>
            <select id="filtro_libro" name="filtro_libro">
                <option value="">Tutti</option>
                <?php
                if ($result_libri->num_rows > 0) {
                    while ($libro = $result_libri->fetch_assoc()) {
                        // Controlla se questo libro è quello attualmente selezionato
                        $selected = ($filtro_libro_attuale == $libro['codISBN']) ? 'selected' : '';
                        echo '<option value="' . htmlspecialchars($libro['codISBN']) . '" ' . $selected . '>' . htmlspecialchars($libro['titolo']) . '</option>';
                    }
                }
                ?>
            </select>
        </div>
        
        
        <div class="button-group">
            <button type="submit" class="button-primary">Filtra</button>
            <a href="elenco_ricette.php" class="button-secondary">Reset</a>
        </div>
    </form>
</div>