<!-- jQuery -->
<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- SweetAlert2 -->
<script src="{{ asset('plugins/sweetalert2/sweetalert2.min.js') }}"></script>
<!-- Toastr -->
<script src="{{ asset('plugins/toastr/toastr.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('dist/js/adminlte.min.js') }}"></script>


<script>
    // prevent auto-execution of scripts when no explicit dataType was provided (See gh-2432)
    jQuery.ajaxPrefilter(function(s) {
        if (s.crossDomain) {
            s.contents.script = false;
        }
    });

    const Toast = Swal.mixin({
        toast: true,
        position: "top-end",
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.onmouseenter = Swal.stopTimer;
            toast.onmouseleave = Swal.resumeTimer;
        }
    });

    @if (session()->has('success'))
        toastr.success("{{ session('success') }}");
    @endif

    @if (session()->has('error'))
        toastr.error("{{ session('error') }}");
    @endif

    $(function() {
        let form = $("#add-data-form");
        form.submit(function(e) {
            // submit button disable
            $("#form-submit-button").attr("disabled", true);
            $("#form-back-button").attr("disabled", true);

            // spinner submit button
            $("#form-submit-button").html(`
                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                <span class="ml-3">Menyimpan...</span>
            `);
        });

        let buttonLogout = $("#form-logout-button");

        buttonLogout.click(function(e) {
            e.preventDefault();
            Swal.fire({
                title: "Logout",
                text: "Apakah Anda yakin ingin keluar?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Logout",
            }).then((result) => {
                if (result.isConfirmed) {
                    // closest form
                    $(this).closest("form").submit();
                }
            });
        });
    });
</script>
