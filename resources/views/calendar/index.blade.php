@extends('layouts.app')

@section('styles')
{{-- Style Here --}}
    <link rel="stylesheet" href="{{asset('plugins/src/fullcalendar/fullcalendar.min.css')}}">
    @vite(['resources/scss/light/plugins/fullcalendar/custom-fullcalendar.scss'])
    @vite(['resources/scss/light/assets/components/modal.scss'])

    @vite(['resources/scss/dark/plugins/fullcalendar/custom-fullcalendar.scss'])
    @vite(['resources/scss/dark/assets/components/modal.scss'])
@endsection

@section('content')
<div class="row layout-top-spacing layout-spacing" id="cancel-row">
    <div class="col-xl-12 col-lg-12 col-md-12">
        <div class="calendar-container">
            <div class="calendar"></div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <div class="row">
                    <div class="col-md-12">
                        <div class="">
                            <label class="form-label">Enter Title</label>
                            <input id="event-title" type="text" class="form-control">
                        </div>
                    </div>

                    <div class="col-md-12 d-none">
                        <div class="">
                            <label class="form-label">Enter Start Date</label>
                            <input id="event-start-date" type="text" class="form-control">
                        </div>
                    </div>

                    <div class="col-md-12 d-none">
                        <div class="">
                            <label class="form-label">Enter End Date</label>
                            <input id="event-end-date" type="text" class="form-control">
                        </div>
                    </div>
                    
                    <div class="col-md-12">

                        <div class="d-flex mt-4">
                            <div class="n-chk">
                                <div class="form-check form-check-primary form-check-inline">
                                    <input class="form-check-input" type="radio" name="event-level" value="Work" id="rwork">
                                    <label class="form-check-label" for="rwork">Work</label>
                                </div>
                            </div>
                            <div class="n-chk">
                                <div class="form-check form-check-warning form-check-inline">
                                    <input class="form-check-input" type="radio" name="event-level" value="Travel" id="rtravel">
                                    <label class="form-check-label" for="rtravel">Travel</label>
                                </div>
                            </div>
                            <div class="n-chk">
                                <div class="form-check form-check-success form-check-inline">
                                    <input class="form-check-input" type="radio" name="event-level" value="Personal" id="rPersonal">
                                    <label class="form-check-label" for="rPersonal">Personal</label>
                                </div>
                            </div>
                            <div class="n-chk">
                                <div class="form-check form-check-danger form-check-inline">
                                    <input class="form-check-input" type="radio" name="event-level" value="Important" id="rImportant">
                                    <label class="form-check-label" for="rImportant">Important</label>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success btn-update-event" data-fc-event-public-id="">Update changes</button>
                <button type="button" class="btn btn-primary btn-add-event">Add Event</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
{{-- Scripts Here --}}
    <script src="{{asset('plugins/src/fullcalendar/fullcalendar.min.js')}}"></script>
    <script src="{{asset('plugins/src/uuid/uuid4.min.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
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
            document.querySelector('.modal-footer').insertBefore(deleteBtn, document.querySelector('.modal-footer').firstChild);
            
            var calendar = new FullCalendar.Calendar(calendarEl, {
                selectable: true,
                initialView: 'dayGridMonth',
                headerToolbar: {
                    left: 'prev next addEventButton',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
                },
                events: '{{ route("calendar.events") }}', // Dynamic fetch
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
                        Swal.fire({
                            title: eventObj.title,
                            html: eventObj.extendedProps.description || 'System Event',
                            icon: 'info'
                        });
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
                    Swal.fire('Error', 'Title and Start Date are required', 'error');
                    return;
                }

                fetch('{{ route("calendar.events.store") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
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
                        Swal.fire('Success', 'Event added successfully!', 'success');
                    } else {
                        Swal.fire('Error', 'Failed to add event', 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire('Error', 'An error occurred', 'error');
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
                    Swal.fire('Error', 'Title and Start Date are required', 'error');
                    return;
                }

                fetch(`/dashboard/calendar/events/${id}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
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
                        Swal.fire('Success', 'Event updated successfully!', 'success');
                    } else {
                        Swal.fire('Error', 'Failed to update event', 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire('Error', 'An error occurred', 'error');
                });
            });
            
            // Delete Event
            deleteBtn.addEventListener('click', function() {
                var id = this.getAttribute('data-fc-event-public-id');
                
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
                        fetch(`/dashboard/calendar/events/${id}`, {
                            method: 'DELETE',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if(data.success) {
                                calendar.refetchEvents();
                                myModal.hide();
                                Swal.fire('Deleted!', 'Event has been deleted.', 'success');
                            } else {
                                Swal.fire('Error', 'Failed to delete event', 'error');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            Swal.fire('Error', 'An error occurred', 'error');
                        });
                    }
                });
            });
        });
    </script>
@endsection