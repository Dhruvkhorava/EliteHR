document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    if (!calendarEl) return;

    var eventModalOptions = document.getElementById('eventModal');
    var eventModal = eventModalOptions ? new bootstrap.Modal(eventModalOptions) : null;
    var eventsUrl = calendarEl.dataset.eventsUrl;

    var calendar = new FullCalendar.Calendar(calendarEl, {
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
        },
        initialView: 'dayGridMonth',
        themeSystem: 'bootstrap5',
        events: eventsUrl,
        eventClick: function(info) {
            var event = info.event;
            var props = event.extendedProps;

            document.getElementById('display-event-title').innerText = event.title;
            document.getElementById('display-event-type').innerText = props.type.toUpperCase();
            document.getElementById('display-event-description').innerText = props.description || 'No additional details.';
            
            var dateStr = event.start.toLocaleString();
            if (event.end) {
                dateStr += ' - ' + event.end.toLocaleString();
            }
            document.getElementById('display-event-date').innerText = dateStr;

            // Style based on type
            var iconDiv = document.getElementById('event-type-icon');
            var typeBadge = document.getElementById('display-event-type');
            
            if (props.type === 'interview') {
                iconDiv.className = 'me-3 p-3 rounded-circle text-white bg-primary';
                typeBadge.className = 'badge badge-light-primary';
            } else if (props.type === 'leave') {
                iconDiv.className = 'me-3 p-3 rounded-circle text-white bg-success';
                typeBadge.className = 'badge badge-light-success';
            }

            if (eventModal) eventModal.show();
        },
        eventContent: function(arg) {
            let italicEl = document.createElement('div')
            italicEl.classList.add('fc-content-container');
            
            let titleEl = document.createElement('div')
            titleEl.classList.add('fc-title')
            titleEl.innerHTML = arg.event.title;

            italicEl.appendChild(titleEl);

            let arrayOfDomNodes = [ italicEl ]
            return { domNodes: arrayOfDomNodes }
        }
    });

    calendar.render();
});
