document.addEventListener('DOMContentLoaded', function() {
    // Handle Filter Button States
    const filterButtons = document.querySelectorAll('.btn-filter');
    filterButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            // Find brother buttons and remove active
            this.parentElement.querySelectorAll('.btn-filter').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
        });
    });

    // Tab Switching Logic (Bootstrap already handles this, but ensuring UI consistency)
    const triggerTabList = [].slice.call(document.querySelectorAll('#pills-tab button'));
    triggerTabList.forEach(function (triggerEl) {
        if (typeof bootstrap !== 'undefined' && bootstrap.Tab) {
            const tabTrigger = new bootstrap.Tab(triggerEl);
            triggerEl.addEventListener('click', function (event) {
                event.preventDefault();
                tabTrigger.show();
            });
        }
    });

    // Initialize Bootstrap Tooltips
    if (typeof bootstrap !== 'undefined' && bootstrap.Tooltip) {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });
    }
});
