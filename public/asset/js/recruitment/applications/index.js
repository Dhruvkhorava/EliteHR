$(document).ready(function() {
    // 1. Initialize Dragula for all stage columns
    const containers = Array.from(document.querySelectorAll('.kanban-cards-wrapper'));
    const drake = dragula(containers, {
        moves: function (el, source, handle, nextSibling) {
            return true; // Elements are always draggable
        },
        accepts: function (el, target, source, sibling) {
            return true; // Elements can be dropped in any stage
        },
        direction: 'vertical'
    });

    // 2. Handle the 'drop' event
    drake.on('drop', function (el, target, source, sibling) {
        const appId = $(el).data('id');
        const newStatus = $(target).data('stage');
        const oldStatus = $(source).data('stage');

        if (newStatus === oldStatus) return; // Dropped in the same column

        updateApplicationStatus(appId, newStatus);
        updateCounts(newStatus, oldStatus);
    });

    function updateApplicationStatus(appId, status) {
        const baseUrl = window.location.origin;
        const url = `${baseUrl}/dashboard/recruitment/applications/${appId}/update-status`;

        $.ajax({
            url: url,
            type: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                status: status
            },
            success: function(response) {
                if (response.success) {
                    Snackbar.show({
                        text: `Candidate moved to ${status}`,
                        pos: 'top-right',
                        actionTextColor: '#fff',
                        backgroundColor: '#4361ee'
                    });
                }
            },
            error: function(xhr) {
                drake.cancel(true); // Revert drag if server fails
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: xhr.responseJSON ? xhr.responseJSON.message : 'Error updating status',
                    padding: '2em',
                    customClass: 'sweet-alerts',
                });
            }
        });
    }

    function updateCounts(newStatus, oldStatus) {
        // Simple slugify helper
        const slugify = (text) => text.toLowerCase().replace(/ /g, '-').replace(/[^\w-]+/g, '');

        const newCountEl = document.getElementById(`count-${slugify(newStatus)}`);
        const oldCountEl = document.getElementById(`count-${slugify(oldStatus)}`);

        if (newCountEl) newCountEl.innerText = parseInt(newCountEl.innerText) + 1;
        if (oldCountEl) oldCountEl.innerText = parseInt(oldCountEl.innerText) - 1;
    }
});
