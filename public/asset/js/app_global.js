$(document).ready(function() {
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    });

    if (window.appData) {
        if (window.appData.success) {
            Toast.fire({
                icon: 'success',
                title: window.appData.success
            });
        }

        if (window.appData.error) {
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: window.appData.error,
                padding: '2em',
                customClass: 'sweet-alerts',
            });
        }

        if (window.appData.warning) {
            Toast.fire({
                icon: 'warning',
                title: window.appData.warning
            });
        }

        if (window.appData.info) {
            Toast.fire({
                icon: 'info',
                title: window.appData.info
            });
        }

        if (window.appData.errors && window.appData.errors.length > 0) {
            let errorList = '<ul class="text-start">';
            window.appData.errors.forEach(error => {
                errorList += `<li>${error}</li>`;
            });
            errorList += '</ul>';
            
            Swal.fire({
                icon: 'error',
                title: 'Validation Error',
                html: errorList,
                padding: '2em',
                customClass: 'sweet-alerts',
            });
        }
    }

    // Global Confirmation for Delete Actions
    $(document).on('click', '.confirm-delete', function(e) {
        e.preventDefault();
        let form = $(this).closest('form');
        Swal.fire({
            title: 'Are you sure?',
            text: "This action cannot be undone!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!',
            padding: '2em',
            customClass: 'sweet-alerts',
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });
});
