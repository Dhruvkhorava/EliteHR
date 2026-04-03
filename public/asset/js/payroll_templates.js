document.addEventListener('DOMContentLoaded', function() {
    if (window.payrollData && window.payrollData.componentCount !== undefined) {
        initSalaryTemplate(window.payrollData.componentCount);
    }
});

function initSalaryTemplate(count) {
    let rowCount = count > 0 ? count : 1; // Initialize rowCount based on provided count or default to 1

    const container = document.getElementById('component-container');
    const addButton = document.getElementById('add-component');

    if (addButton && container) {
        // If initial count is greater than 1, add the necessary rows
        for (let i = 1; i < rowCount; i++) {
            const firstRow = container.querySelector('.component-row');
            if (!firstRow) break; // No row to clone

            const newRow = firstRow.cloneNode(true);
            newRow.querySelectorAll('select, input').forEach(input => {
                const name = input.getAttribute('name');
                if (name) {
                    input.setAttribute('name', name.replace(/\[\d+\]/, '[' + i + ']'));
                    input.value = '';
                }
            });
            container.appendChild(newRow);
        }

        addButton.addEventListener('click', function() {
            const firstRow = container.querySelector('.component-row');
            if (!firstRow) return;
            
            const newRow = firstRow.cloneNode(true);
            
            // Update names for array indexing
            newRow.querySelectorAll('select, input').forEach(input => {
                const name = input.getAttribute('name');
                if (name) {
                    input.setAttribute('name', name.replace(/\[\d+\]/, '[' + rowCount + ']'));
                    input.value = '';
                }
            });
            
            container.appendChild(newRow);
            rowCount++;
        });

        container.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-row')) {
                const rows = container.querySelectorAll('.component-row');
                if (rows.length > 1) {
                    e.target.closest('.component-row').remove();
                } else {
                    alert('At least one component is required.');
                }
            }
        });
    }
}
