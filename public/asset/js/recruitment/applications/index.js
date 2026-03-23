$(document).ready(function() {
    $('.update-status').on('click', function() {
        const appId = $(this).data('id');
        const status = $(this).data('status');
        const baseUrl = window.location.origin;
        const url = `${baseUrl}/recruitment/applications/${appId}/update-status`;

        $.ajax({
            url: url,
            type: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                status: status
            },
            success: function(response) {
                if (response.success) {
                    location.reload();
                }
            },
            error: function(xhr) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Error updating status',
                    padding: '2em',
                    customClass: 'sweet-alerts',
                });
            }
        });
    });
});
