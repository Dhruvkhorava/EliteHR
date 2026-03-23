document.addEventListener('DOMContentLoaded', function() {
    const fromDateInput = document.getElementById('from_date');
    const toDateInput = document.getElementById('to_date');
    const totalDaysSpan = document.getElementById('total-days-count');

    function calculateDays() {
        const fromDate = new Date(fromDateInput.value);
        const toDate = new Date(toDateInput.value);

        if (fromDate && toDate && toDate >= fromDate) {
            const diffTime = Math.abs(toDate - fromDate);
            const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1;
            totalDaysSpan.innerText = diffDays;
        } else {
            totalDaysSpan.innerText = '0';
        }
    }

    if (fromDateInput && toDateInput) {
        fromDateInput.addEventListener('change', calculateDays);
        toDateInput.addEventListener('change', calculateDays);
        calculateDays();
    }
});
