<!-- Bootstrap 5.3 JS Bundle (termasuk Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/2.0.8/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.0.8/js/dataTables.bootstrap5.js"></script>

    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>

    <!-- Custom JS -->
    <script src="js/script.js"></script>
    

    <?php
    // Logika untuk menampilkan notifikasi SweetAlert dari session
    if (isset($_SESSION['message'])) {
        $message = $_SESSION['message'];
        $message_type = isset($_SESSION['message_type']) ? $_SESSION['message_type'] : 'success';
        echo "
        <script>
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: '{$message_type}',
                title: '{$message}',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true
            });
        </script>
        ";
        unset($_SESSION['message']);
        unset($_SESSION['message_type']);
    }
    ?>
</body>
</html>
