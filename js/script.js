$(document).ready(function() {
    // Inisialisasi DataTables
    $('#data-table').DataTable({
        "language": {
            "url": "https://cdn.datatables.net/plug-ins/2.0.8/i18n/id.json"
        }
    });

    // Sidebar toggle functionality
    $('#sidebarCollapse').on('click', function () {
        $('#sidebar').toggleClass('toggled');
    });

    // SweetAlert2 untuk konfirmasi hapus
    $(document).on('click', '.btn-delete', function(e) {
        e.preventDefault(); 
        const deleteUrl = $(this).attr('href'); 

        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Data yang dihapus tidak dapat dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = deleteUrl;
            }
        });
    });

    // Password Toggle untuk form biasa (seperti di halaman profil)
    $(".toggle-password-icon-form").click(function () {
        $(this).find("i").toggleClass("bi-eye bi-eye-slash");
        var input = $(this).prev("input[type='password'], input[type='text']");
        if (input.attr("type") === "password") {
            input.attr("type", "text");
        } else {
            input.attr("type", "password");
        }
    });
});
