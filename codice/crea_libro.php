<?php
include 'config.php';
include 'header.php';
include 'sidebar.php';
?>

<main class="content">
    <h2>Aggiungi un Nuovo Libro</h2>
     <?php
    // BLOCCO MESSAGGI DI ERRORE
    if (isset($_GET['status']) && $_GET['status'] == 'error_duplicate') {
        echo '<p class="error-message2">Esiste già un libro con questo codice ISBN. Inseriscine uno diverso.</p>';
    }
   
    ?>
    <form action="salva_libro.php" method="POST" class="form-crud">
        
        <div class="form-group">
            <label for="codISBN">Codice ISBN</label>
            <input type="text" id="codISBN" name="codISBN" required>
        </div>

        <div class="form-group">
            <label for="titolo">Titolo</label>
            <input type="text" id="titolo" name="titolo" required>
        </div>

        <div class="form-group">
            <label for="anno">Anno di Pubblicazione</label>
            <input type="number" id="anno" name="anno" min="1000" max="2099" required>
        </div>

        <button type="submit" class="button-primary">Salva Libro</button>
    </form>
</main>

<aside class="right-column"></aside>

<?php
include 'footer.php';
?>