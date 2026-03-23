let serverClientOffset = 0;

function updateTime() {
    const timeEl = document.getElementById('current-time');
    if (!timeEl) return;

    if (serverClientOffset === 0 && timeEl.dataset.serverNow) {
        const serverNow = new Date(timeEl.dataset.serverNow);
        const clientNow = new Date();
        serverClientOffset = serverNow.getTime() - clientNow.getTime();
    }

    const now = new Date(new Date().getTime() + serverClientOffset);
    timeEl.innerText = now.toLocaleTimeString([], {
        hour: '2-digit',
        minute: '2-digit',
        second: '2-digit',
        hour12: true
    });

    updateAttendanceTimers(now);
}

function updateAttendanceTimers(nowInput) {
    const sessionInfo = document.getElementById('session-info');
    if (!sessionInfo) return;

    const checkInStr = sessionInfo.dataset.checkIn;
    const isOnBreak = sessionInfo.dataset.onBreak === '1';
    const breakStartStr = sessionInfo.dataset.breakStart;
    const totalBreakSeconds = parseInt(sessionInfo.dataset.totalBreakSeconds || 0);

    const now = nowInput || new Date(new Date().getTime() + serverClientOffset);
    
    // Parse ISO strings directly
    const checkInDate = new Date(checkInStr);

    let currentBreakSeconds = 0;
    if (isOnBreak && breakStartStr) {
        const breakStartDate = new Date(breakStartStr);
        if (!isNaN(breakStartDate.getTime())) {
            currentBreakSeconds = Math.floor((now - breakStartDate) / 1000);
        }
    }

    const totalSecondsOnBreak = totalBreakSeconds + currentBreakSeconds;
    const totalWorkSeconds = Math.floor((now - checkInDate) / 1000) - totalSecondsOnBreak;

    const workTimerEl = document.getElementById('work-timer');
    if (workTimerEl) {
        workTimerEl.innerText = formatDuration(totalWorkSeconds);
    }

    const breakTimerEl = document.getElementById('break-timer');
    if (breakTimerEl) {
        breakTimerEl.innerText = formatDurationSimple(totalSecondsOnBreak);
    }
}

function formatDuration(seconds) {
    if (seconds < 0) seconds = 0;
    const hours = Math.floor(seconds / 3600);
    const minutes = Math.floor((seconds % 3600) / 60);
    const secs = seconds % 60;
    return `${hours}h ${minutes}m ${secs}s`;
}

function formatDurationSimple(seconds) {
    if (seconds < 0) seconds = 0;
    const minutes = Math.floor(seconds / 60);
    const secs = seconds % 60;
    return `${minutes}m ${secs}s`;
}

setInterval(updateTime, 1000);

$(document).ready(function() {
    const tableEl = $('#attendance-history-table');
    if (tableEl.length) {
        tableEl.DataTable({
            "dom": "<'dt--top-section'<'row'<'col-12 col-sm-6 d-flex justify-content-sm-start justify-content-center'l><'col-12 col-sm-6 d-flex justify-content-sm-end justify-content-center mt-sm-0 mt-3'f>>>" +
                "<'table-responsive'tr>" +
                "<'dt--bottom-section d-sm-flex justify-content-sm-between text-center'<'dt--pages-count  mb-sm-0 mb-3'i><'dt--pagination'p>>",
            "oLanguage": {
                "oPaginate": {
                    "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>',
                    "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>'
                },
                "sInfo": "Showing page _PAGE_ of _PAGES_",
                "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
                "sSearchPlaceholder": "Search...",
                "sLengthMenu": "Results :  _MENU_",
            },
            "stripeClasses": [],
            "lengthMenu": [7, 10, 20, 50],
            "pageLength": 10,
            "order": [
                [0, "desc"]
            ]
        });
    }
});
