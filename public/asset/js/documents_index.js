$(document).ready(function() {
    // Search functionality
    $('#folderSearch').on('keyup', function() {
        var value = $(this).val().toLowerCase();
        var $items = $('#folderGrid .folder-item');
        var $noResults = $('#noResults');

        $items.each(function() {
            var isVisible = $(this).data('name').indexOf(value) > -1;
            $(this).toggle(isVisible);
        });

        // Show/Hide "No Results" state
        if ($items.filter(':visible').length === 0) {
            $noResults.fadeIn(300);
        } else {
            $noResults.hide();
        }
    });
});
