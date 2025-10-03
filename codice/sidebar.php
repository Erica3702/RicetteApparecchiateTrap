<aside class="sidebar">
    <nav class="main-nav">
        <ul>
            <li><a href="index.php">HOME</a></li>
            
            <li class="has-submenu">
                <a href="#">GESTIONE LIBRI</a>
                <ul class="submenu">
                    <li><a href="crea_libro.php">NUOVO LIBRO</a></li>
                    <li><a href="elenco_libri.php">GESTISCI LIBRI</a></li>
                </ul>
            </li>
            <li class="has-submenu">
                <a href="#">GESTIONE ARCHIVIO</a>
                <ul class="submenu">
                    <li><a href="elenco_ricette.php">VISUALIZZA RICETTE</a></li>
                </ul>
            </li>
        </ul>
    </nav>

    <?php

    if (basename($_SERVER['PHP_SELF']) == 'elenco_ricette.php') {
        include 'filtro_ricette.php';
    }
    ?>
</aside>