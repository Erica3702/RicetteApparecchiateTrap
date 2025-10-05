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
 
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // Cerca tutti i link che hanno la classe 'button-delete'
        const deleteLinks = document.querySelectorAll('.button-delete');

        // Per ogni link trovato, aggiungi un event listener
        deleteLinks.forEach(link => {
            link.addEventListener('click', function(event) {
           
                event.preventDefault();

                const deleteUrl = this.href;

                // Mostra il pop-up 
                Swal.fire({
                    title: 'Sei sicuro?',
                    text: "Questa azione è irreversibile!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#c0392b', 
                    cancelButtonColor: '#666',
                    confirmButtonText: 'Sì, elimina!',
                    cancelButtonText: 'Annulla'
                }).then((result) => {
                   
                    if (result.isConfirmed) {
                        window.location.href = deleteUrl;
                    }
                });
            });
        });
    </script>

</body>
</html>