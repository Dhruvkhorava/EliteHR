document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.querySelector('.calendar');
    var getModalTitleEl = document.querySelector('#event-title');
    var getModalStartDateEl = document.querySelector('#event-start-date');
    var getModalEndDateEl = document.querySelector('#event-end-date');
    var getModalDescriptionEl = document.querySelector('#event-description');
    var getModalDescriptionViewEl = document.querySelector('#event-description-view');
    var getModalAddBtnEl = document.querySelector('.btn-add-event');
    var getModalUpdateBtnEl = document.querySelector('.btn-update-event');
    var btnAddSidebar = document.querySelector('#btn-add-event-sidebar');
    var upcomingListEl = document.querySelector('#upcoming-events-list');
    
    var myModal = new bootstrap.Modal(document.getElementById('exampleModal'));
    
    // Add Delete Button to Modal Footer
    var deleteBtn = document.createElement('button');
    deleteBtn.type = 'button';
    deleteBtn.className = 'btn btn-danger btn-delete-event me-auto shadow-sm';
    deleteBtn.style.display = 'none';
    deleteBtn.textContent = 'Delete Event';
    var footer = document.querySelector('.modal-footer');
    if (footer) {
        footer.insertBefore(deleteBtn, footer.firstChild);
    }
    
    function getEventIcon(type, category) {
        if (type === 'birthday') return '🎂';
        if (type === 'holiday') return '🎉';
        if (type === 'leave') return '🤒';
        if (type === 'interview') return '🤝';
        
        switch(category) {
            case 'Travel': return '✈️';
            case 'Personal': return '🌿';
            case 'Important': return '🚩';
            default: return '🏢';
        }
    }

    var calendar = new FullCalendar.Calendar(calendarEl, {
        selectable: true,
        initialView: 'dayGridMonth',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,listMonth'
        },
        events: window.calendarData.fetchUrl,
        
        eventContent: function(arg) {
            let icon = getEventIcon(arg.event.extendedProps.type, arg.event.extendedProps.category);
            let arrayOfDomNodes = [];
            
            let titleEl = document.createElement('div');
            titleEl.className = 'fc-event-main-frame';
            titleEl.innerHTML = `<span class="event-icon">${icon}</span> <span class="fc-event-title">${arg.event.title}</span>`;
            
            arrayOfDomNodes.push(titleEl);
            return { domNodes: arrayOfDomNodes };
        },

        eventDidMount: function(info) {
            // Add subtle tooltip or styling
            if (info.event.extendedProps.description) {
                // info.el.setAttribute('title', info.event.extendedProps.description.replace(/<[^>]*>?/gm, ''));
            }
        },

        loading: function(isLoading) {
            if (!isLoading) {
                populateUpcomingEvents();
            }
        },

        select: function(info) {
            resetModal();
            getModalAddBtnEl.style.display = 'block';
            getModalUpdateBtnEl.style.display = 'none';
            deleteBtn.style.display = 'none';
            getModalDescriptionEl.classList.remove('d-none');
            getModalDescriptionViewEl.classList.add('d-none');
            
            // Format for datetime-local
            getModalStartDateEl.value = info.startStr.includes('T') ? info.startStr.substring(0, 16) : info.startStr + 'T09:00';
            getModalEndDateEl.value = info.endStr ? (info.endStr.includes('T') ? info.endStr.substring(0, 16) : info.endStr + 'T18:00') : '';
            
            myModal.show();
        },

        eventClick: function(info) {
            var eventObj = info.event;
            resetModal();
            
            if (eventObj.extendedProps.type === 'custom') {
                getModalTitleEl.value = eventObj.title;
                getModalTitleEl.readOnly = false;
                
                var category = eventObj.extendedProps.category;
                var radio = document.querySelector('input[value="' + category + '"]');
                if(radio) radio.checked = true;
                
                getModalStartDateEl.value = eventObj.startStr.substring(0, 16);
                getModalEndDateEl.value = eventObj.endStr ? eventObj.endStr.substring(0, 16) : '';
                
                getModalDescriptionEl.value = eventObj.extendedProps.description || '';
                getModalDescriptionEl.classList.remove('d-none');
                getModalDescriptionViewEl.classList.add('d-none');
                
                getModalUpdateBtnEl.setAttribute('data-fc-event-public-id', eventObj.id);
                deleteBtn.setAttribute('data-fc-event-public-id', eventObj.id);
                
                getModalAddBtnEl.style.display = 'none';
                getModalUpdateBtnEl.style.display = 'block';
                deleteBtn.style.display = 'block';
                myModal.show();
            } else {
                // System Event
                getModalTitleEl.value = eventObj.title;
                getModalTitleEl.readOnly = true;
                getModalDescriptionViewEl.innerHTML = eventObj.extendedProps.description || 'No additional details.';
                getModalDescriptionViewEl.classList.remove('d-none');
                getModalDescriptionEl.classList.add('d-none');
                
                getModalAddBtnEl.style.display = 'none';
                getModalUpdateBtnEl.style.display = 'none';
                deleteBtn.style.display = 'none';
                
                // Hide category selection for system events
                document.querySelectorAll('input[name="event-level"]').forEach(el => el.disabled = true);
                
                myModal.show();
            }
        }
    });

    calendar.render();

    function resetModal() {
        getModalTitleEl.value = '';
        getModalTitleEl.readOnly = false;
        getModalStartDateEl.value = '';
        getModalEndDateEl.value = '';
        getModalDescriptionEl.value = '';
        getModalDescriptionViewEl.innerHTML = '';
        document.querySelectorAll('input[name="event-level"]').forEach(el => {
            el.disabled = false;
            el.checked = (el.value === 'Work');
        });
    }

    function populateUpcomingEvents() {
        var events = calendar.getEvents();
        var now = new Date();
        var upcoming = events.filter(e => new Date(e.start) >= now)
                            .sort((a, b) => new Date(a.start) - new Date(b.start))
                            .slice(0, 5);
        
        upcomingListEl.innerHTML = '';
        if (upcoming.length === 0) {
            upcomingListEl.innerHTML = '<p class="text-muted small">No upcoming events this month.</p>';
            return;
        }

        upcoming.forEach(e => {
            var date = new Date(e.start);
            var dateStr = date.toLocaleDateString('en-US', { day: 'numeric', month: 'short' });
            var icon = getEventIcon(e.extendedProps.type, e.extendedProps.category);
            var colorClass = e.classNames[0] || 'bg-primary';

            var item = document.createElement('div');
            item.className = 'upcoming-event-item';
            item.style.borderLeftColor = getComputedStyle(document.querySelector('.' + colorClass) || document.body).backgroundColor;
            item.innerHTML = `
                <div class="d-flex justify-content-between align-items-center">
                    <div class="fw-bold text-truncate" style="max-width: 150px;">${icon} ${e.title}</div>
                    <div class="badge bg-light-primary text-primary small">${dateStr}</div>
                </div>
            `;
            item.onclick = function() {
                calendar.gotoDate(e.start);
                // Trigger click
                calendar.trigger('eventClick', { event: e, jsEvent: {}, view: calendar.view });
            };
            upcomingListEl.appendChild(item);
        });
    }

    // Sidebar Create Event
    if (btnAddSidebar) {
        btnAddSidebar.addEventListener('click', function() {
            resetModal();
            getModalAddBtnEl.style.display = 'block';
            getModalUpdateBtnEl.style.display = 'none';
            deleteBtn.style.display = 'none';
            var currentDate = new Date();
            getModalStartDateEl.value = currentDate.toISOString().substring(0, 16);
            myModal.show();
        });
    }

    // Add Event
    getModalAddBtnEl.addEventListener('click', function() {
        executeEventAction(window.calendarData.storeUrl, 'POST');
    });

    // Update Event
    getModalUpdateBtnEl.addEventListener('click', function() {
        var id = this.getAttribute('data-fc-event-public-id');
        executeEventAction(`/dashboard/calendar/events/${id}`, 'PUT');
    });
    
    function executeEventAction(url, method) {
        var title = getModalTitleEl.value;
        var start_date = getModalStartDateEl.value;
        var end_date = getModalEndDateEl.value;
        var description = getModalDescriptionEl.value;
        var checkedRadio = document.querySelector('input[name="event-level"]:checked');
        var category = checkedRadio ? checkedRadio.value : 'Work';

        if(!title || !start_date) {
            Swal.fire('Error', 'Title and Start Date are required', 'error');
            return;
        }

        fetch(url, {
            method: method,
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': window.appData.csrfToken
            },
            body: JSON.stringify({
                title: title,
                start_date: start_date,
                end_date: end_date,
                category: category,
                description: description
            })
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                calendar.refetchEvents();
                myModal.hide();
                Swal.fire('Success', `Event ${method === 'POST' ? 'added' : 'updated'} successfully!`, 'success');
            } else {
                Swal.fire('Error', 'Action failed. Please check your input.', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire('Error', 'An unexpected error occurred.', 'error');
        });
    }

    // Delete Event
    deleteBtn.addEventListener('click', function() {
        var id = this.getAttribute('data-fc-event-public-id');
        
        Swal.fire({
            title: 'Delete Event?',
            text: "This action cannot be undone.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#e7515a',
            cancelButtonColor: '#888ea8',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch(`/dashboard/calendar/events/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': window.appData.csrfToken
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if(data.success) {
                        calendar.refetchEvents();
                        myModal.hide();
                        Swal.fire('Deleted!', 'Event has been removed.', 'success');
                    }
                });
            }
        });
    });
});
