<?php
// 1. Includi la configurazione del database
include 'config.php';

// 2. Includi l'inizio della pagina HTML (header, sidebar, etc.)
include 'header.php';

// 3. Includi la sidebar
include 'sidebar.php';
?>

<main class="content">
    <section class="results-section">
        <h2>Le Ricette più Pubblicate</h2>
        <div class="ricette-container">
            <article class="recipe-card">
                <img src="immagini/lasagna.webp" alt="Immagine Lasagne alla Bolognese">
                <h3>Lasagne alla Bolognese</h3>
            </article>
            <article class="recipe-card">
                <img src="immagini/tiramisu1.jpg" alt="Immagine Tiramisù">
                <h3>Tiramisù</h3>
            </article>
            <article class="recipe-card">
                <img src="immagini/carbonara.jpg" alt="Immagine Spaghetti alla Carbonara">
                <h3>Spaghetti alla Carbonara</h3>
            </article>
        </div>
    </section>

    <section class="stats-section">
        <h2>Statistiche Veloci</h2>
        <div class="statistiche-container">
            <?php
            // === Blocco PHP per mostrare le statistiche dinamiche ===
            // (Il tuo codice per le query va qui, è già corretto)
            $sql_libri_count = "SELECT COUNT(*) AS total_libri FROM libri";
            $result_libri_count = $conn->query($sql_libri_count);
            $total_libri = ($result_libri_count && $result_libri_count->num_rows > 0) ? $result_libri_count->fetch_assoc()['total_libri'] : 0;
            echo '<div class="stat-card"><h3>Libri Totali</h3><p>' . $total_libri . '</p></div>';

            $sql_ricette_count = "SELECT COUNT(*) AS total_ricette FROM ricette";
            $result_ricette_count = $conn->query($sql_ricette_count);
            $total_ricette = ($result_ricette_count && $result_ricette_count->num_rows > 0) ? $result_ricette_count->fetch_assoc()['total_ricette'] : 0;
            echo '<div class="stat-card"><h3>Ricette Totali</h3><p>' . $total_ricette . '</p></div>';

            echo '<div class="stat-card"><h3>Altra Statistica</h3><p>Dato X</p></div>';
            ?>
        </div>
    </section>
</main>
<?php
// 4. Includi la fine della pagina HTML (footer, script, etc.)
include 'footer.php';
?>