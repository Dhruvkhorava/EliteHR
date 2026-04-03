document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.querySelector('.calendar');
    var getModalTitleEl = document.querySelector('#event-title');
    var getModalStartDateEl = document.querySelector('#event-start-date');
    var getModalEndDateEl = document.querySelector('#event-end-date');
    var getModalAddBtnEl = document.querySelector('.btn-add-event');
    var getModalUpdateBtnEl = document.querySelector('.btn-update-event');
    var myModal = new bootstrap.Modal(document.getElementById('exampleModal'));
    
    // Add Delete Button to Modal Footer
    var deleteBtn = document.createElement('button');
    deleteBtn.type = 'button';
    deleteBtn.className = 'btn btn-danger btn-delete-event me-auto'; // Aligned to left
    deleteBtn.style.display = 'none';
    deleteBtn.textContent = 'Delete Event';
    var footer = document.querySelector('.modal-footer');
    if (footer) {
        footer.insertBefore(deleteBtn, footer.firstChild);
    }
    
    var calendar = new FullCalendar.Calendar(calendarEl, {
        selectable: true,
        initialView: 'dayGridMonth',
        headerToolbar: {
            left: 'prev next addEventButton',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
        },
        events: window.calendarData.fetchUrl, // Dynamic fetch
        customButtons: {
            addEventButton: {
                text: 'Add Event',
                click: function() {
                    getModalAddBtnEl.style.display = 'block';
                    getModalUpdateBtnEl.style.display = 'none';
                    deleteBtn.style.display = 'none';
                    var currentDate = new Date();
                    getModalStartDateEl.value = currentDate.toISOString().split('T')[0] + 'T00:00:00';
                    myModal.show();
                }
            }
        },
        select: function(info) {
            getModalAddBtnEl.style.display = 'block';
            getModalUpdateBtnEl.style.display = 'none';
            deleteBtn.style.display = 'none';
            getModalStartDateEl.value = info.startStr + 'T00:00:00';
            getModalEndDateEl.value = info.endStr + 'T00:00:00';
            myModal.show();
        },
        eventClick: function(info) {
            var eventObj = info.event;
            
            if (eventObj.extendedProps.type === 'custom') {
                getModalTitleEl.value = eventObj.title;
                
                var category = eventObj.extendedProps.category;
                var radio = document.querySelector('input[value="' + category + '"]');
                if(radio) radio.checked = true;
                
                getModalStartDateEl.value = eventObj.startStr;
                getModalEndDateEl.value = eventObj.endStr || '';
                
                getModalUpdateBtnEl.setAttribute('data-fc-event-public-id', eventObj.id);
                deleteBtn.setAttribute('data-fc-event-public-id', eventObj.id);
                
                getModalAddBtnEl.style.display = 'none';
                getModalUpdateBtnEl.style.display = 'block';
                deleteBtn.style.display = 'block';
                myModal.show();
            } else if (eventObj.url) {
                window.open(eventObj.url);
                info.jsEvent.preventDefault();
            } else {
                // For system events (leaves, interviews), just show details (or read-only modal)
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        title: eventObj.title,
                        html: eventObj.extendedProps.description || 'System Event',
                        icon: 'info'
                    });
                } else {
                    alert(eventObj.title + ': ' + (eventObj.extendedProps.description || 'System Event'));
                }
            }
        }
    });
    calendar.render();

    // Clear modal on hide
    document.getElementById('exampleModal').addEventListener('hidden.bs.modal', function () {
        getModalTitleEl.value = '';
        getModalStartDateEl.value = '';
        getModalEndDateEl.value = '';
        var checkedRadio = document.querySelector('input[name="event-level"]:checked');
        if (checkedRadio) checkedRadio.checked = false;
    });

    // Add Event
    getModalAddBtnEl.addEventListener('click', function() {
        var title = getModalTitleEl.value;
        var start_date = getModalStartDateEl.value;
        var end_date = getModalEndDateEl.value;
        var checkedRadio = document.querySelector('input[name="event-level"]:checked');
        var category = checkedRadio ? checkedRadio.value : 'Work';

        if(!title || !start_date) {
            if (typeof Swal !== 'undefined') Swal.fire('Error', 'Title and Start Date are required', 'error');
            return;
        }

        fetch(window.calendarData.storeUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': window.appData.csrfToken
            },
            body: JSON.stringify({
                title: title,
                start_date: start_date,
                end_date: end_date,
                category: category
            })
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                calendar.refetchEvents();
                myModal.hide();
                if (typeof Swal !== 'undefined') Swal.fire('Success', 'Event added successfully!', 'success');
            } else {
                if (typeof Swal !== 'undefined') Swal.fire('Error', 'Failed to add event', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            if (typeof Swal !== 'undefined') Swal.fire('Error', 'An error occurred', 'error');
        });
    });

    // Update Event
    getModalUpdateBtnEl.addEventListener('click', function() {
        var id = this.getAttribute('data-fc-event-public-id');
        var title = getModalTitleEl.value;
        var start_date = getModalStartDateEl.value;
        var end_date = getModalEndDateEl.value;
        var checkedRadio = document.querySelector('input[name="event-level"]:checked');
        var category = checkedRadio ? checkedRadio.value : 'Work';

        if(!title || !start_date) {
            if (typeof Swal !== 'undefined') Swal.fire('Error', 'Title and Start Date are required', 'error');
            return;
        }

        fetch(`/dashboard/calendar/events/${id}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': window.appData.csrfToken
            },
            body: JSON.stringify({
                title: title,
                start_date: start_date,
                end_date: end_date,
                category: category
            })
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                calendar.refetchEvents();
                myModal.hide();
                if (typeof Swal !== 'undefined') Swal.fire('Success', 'Event updated successfully!', 'success');
            } else {
                if (typeof Swal !== 'undefined') Swal.fire('Error', 'Failed to update event', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            if (typeof Swal !== 'undefined') Swal.fire('Error', 'An error occurred', 'error');
        });
    });
    
    // Delete Event
    deleteBtn.addEventListener('click', function() {
        var id = this.getAttribute('data-fc-event-public-id');
        
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    performDelete(id);
                }
            });
        } else {
            if (confirm('Are you sure you want to delete this event?')) {
                performDelete(id);
            }
        }

        function performDelete(id) {
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
                    if (typeof Swal !== 'undefined') Swal.fire('Deleted!', 'Event has been deleted.', 'success');
                } else {
                    if (typeof Swal !== 'undefined') Swal.fire('Error', 'Failed to delete event', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                if (typeof Swal !== 'undefined') Swal.fire('Error', 'An error occurred', 'error');
            });
        }
    });
});
