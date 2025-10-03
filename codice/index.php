<?php
// configurazione del database
include 'config.php';

// Include l'inizio della pagina HTML 
include 'header.php';

include 'sidebar.php';
?>


<main class="content">
 <?php
    if (isset($_GET['status']) && $_GET['status'] == 'success_create') {
        echo '<p class="success-message">Libro salvato con successo!</p>';
    }
    ?>    

<section class="results-section">
        <h2>Le Ricette più Apprezzate</h2>
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
            // Blocco PHP per mostrare le statistiche dinamiche 
            $sql_libri_count = "SELECT COUNT(*) AS total_libri FROM Libro";
            
            $result_libri_count = $conn->query($sql_libri_count);
            
            $total_libri = ($result_libri_count && $result_libri_count->num_rows > 0) ? $result_libri_count->fetch_assoc()['total_libri'] : 0;
            echo '<div class="stat-card"><h3>Ricettari totali</h3><p class="stat-number">' . $total_libri . '</p></div>';
            $sql_ricette_count = "SELECT COUNT(*) AS total_ricette FROM Ricetta";
            $result_ricette_count = $conn->query($sql_ricette_count);
            $total_ricette = ($result_ricette_count && $result_ricette_count->num_rows > 0) ? $result_ricette_count->fetch_assoc()['total_ricette'] : 0;
            echo '<div class="stat-card"><h3>Ricette totali</h3><p class="stat-number">' . $total_ricette . '</p></div>';
            
            
            $sql_ingredienti = "SELECT COUNT(*) AS total FROM Ingrediente";
            $result_ingredienti = $conn->query($sql_ingredienti);
            $total_ingredienti = ($result_ingredienti && $result_ingredienti->num_rows > 0) ? $result_ingredienti->fetch_assoc()['total'] : 0;
            echo '<div class="stat-card"><h3>Ingredienti unici</h3><p class="stat-number">'. $total_ingredienti . '</p></div>';
           ?>
        </div>
    </section>
</main>

<aside class="right-column"></aside>

<?php
//Include la fine della pagina HTML 
include 'footer.php';
?>