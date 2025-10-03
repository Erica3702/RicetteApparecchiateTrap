</div> <footer class="main-footer">
        <p>&copy; 2025 - Tutti i diritti riservati</p>
        <p>1079489 Cattaneo Luca e 1081101 Locatelli Erica</p>
    </footer>

    <?php
    // Chiude la connessione al database se esiste
    if (isset($conn) && $conn) {
        $conn->close();
    }
    ?>

    <script>
        document.querySelectorAll('.has-submenu > a').forEach(menu => {
            menu.addEventListener('click', function(event) {
                event.preventDefault();
                document.querySelectorAll('.submenu').forEach(submenu => {
                    if (submenu !== this.nextElementSibling) {
                        submenu.style.display = 'none';
                    }
                });
                let submenu = this.nextElementSibling;
                if (submenu) {
                    submenu.style.display = submenu.style.display === 'block' ? 'none' : 'block';
                }
            });
        });
    </script>

</body>
</html>