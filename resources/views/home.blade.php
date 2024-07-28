@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content_header')
<h1 class="m-0 text-dark"></h1>
@stop

@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/6.1.10/index.global.min.css">
@stop

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="card-title">
                    <h5 class="mb-0">Calendario de citas</h5>
                </div>
                <div class="card-actions">
                </div>
            </div>
        </div>
    </div>
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div id="calendar"></div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="detallesCita">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fs-5">Detalles de cita</h5>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-9 col-lg-6">
                        <div id="detallesFecha"></div>
                    </div>
                    <div class="col-sm-3 col-lg-6">
                        <div id="detallesEstado"></div>
                    </div>
                    <div class="col-lg-6">
                        <b>Paciente: </b><div id="detallesPaciente"></div>
                    </div>
                    <div class="col-lg-6">
                        <b>Nutriologo: </b><div id="detallesDoctor"></div>
                    </div>
                    <div class="col-12">
                        <b>Clinica: </b><div id="detallesClinica"></div>
                    </div>
                    <div class="col-12">
                        <div id="detallesDireccion"></div>
                    </div>
                    <div class="col-12">
                        <b>Nota: </b><div id="detallesNota"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
@stop

@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/6.1.10/index.global.min.js"></script>
<script>
    // script.js
document.addEventListener('DOMContentLoaded', function () {
    const calendarEl = document.getElementById('calendar');
    
    // Simular datos de citas
    const appointments = [
        @foreach($citas as $cita)
        { id: '{{$cita->id}}',
        status: '{{($cita->estado != '') ? $cita->estado : ((strtotime($today)>=strtotime(date("Y-m-d", strtotime($cita->fecha)))) ? "Vencida" : "Activa")}}', user: '{{$cita->paciente}}', date: '{{date("Y-m-d", strtotime($cita->fecha))}}', time: '{{date("h:i A", strtotime($cita->fecha))}}', doctor: '{{$cita->doctor}}', nota: '{{$cita->nota}}', clinica: '{{$cita->clinica}}', direccion: '{{$cita->direccion}}' },
        @endforeach
    ];

    // Convertir las citas en eventos para el calendario
    const calendarEvents = appointments.map(app => ({
        title: `${app.user} con ${app.doctor}`,
        start: app.date,
        color: getEventColor(app.status), // Asigna el color según el estado
        extendedProps: {
            status: app.status,
            time: app.time,
            date: app.date,
            user: app.user,
            doctor: app.doctor,
            clinica: app.clinica,
            direccion: app.direccion,
            nota: app.nota
        }
    }));

    const calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        events: calendarEvents,
        eventClick: function (info) {
            // Mostrar detalles del evento al hacer clic
            const event = info.event;
            document.getElementById('detallesFecha').innerHTML = event.extendedProps.date+' '+event.extendedProps.time;
            document.getElementById('detallesEstado').innerHTML = event.extendedProps.status;
            document.getElementById('detallesPaciente').innerHTML = event.extendedProps.user;
            document.getElementById('detallesDoctor').innerHTML = event.extendedProps.doctor;
            document.getElementById('detallesClinica').innerHTML = event.extendedProps.clinica;
            document.getElementById('detallesDireccion').innerHTML = event.extendedProps.direccion;
            document.getElementById('detallesNota').innerHTML = event.extendedProps.nota;
            $('#detallesCita').modal('show');
        }
    });

    calendar.render();

    const appointmentsList = document.getElementById('appointments-list');
    const userName = document.getElementById('user-name');
    const userEmail = document.getElementById('user-email');
    const userPhone = document.getElementById('user-phone');
    const appointmentDate = document.getElementById('appointment-date');
    const appointmentTime = document.getElementById('appointment-time');
    const doctorName = document.getElementById('doctor-name');

    // Función para renderizar citas
    const renderAppointments = (filter = '') => {
        appointmentsList.innerHTML = '';
        const filteredAppointments = filter ? appointments.filter(app => app.status === filter) : appointments;
        
        filteredAppointments.forEach(app => {
            const appointmentDiv = document.createElement('div');
            appointmentDiv.classList.add('appointment');
            appointmentDiv.innerHTML = `
                <span>${app.user}</span>
                <button data-id="${app.id}" class="view-details">Ver Detalles</button>
            `;
            appointmentsList.appendChild(appointmentDiv);
        });
        
        document.querySelectorAll('.view-details').forEach(button => {
            button.addEventListener('click', function () {
                const appointment = appointments.find(app => app.id == this.dataset.id);
                userName.textContent = appointment.user;
                clinica.textContent = appointment.clinica;
                direccion.textContent = appointment.direccion;
                appointmentDate.textContent = appointment.date;
                appointmentTime.textContent = appointment.time;
                doctorName.textContent = appointment.doctor;
                nota.textContent = appointment.nota;
            });
        });
    };

    // Función para manejar el cambio de filtro y botón activo
    const handleFilterButtonClick = (filter) => {
        renderAppointments(filter);
        
        document.querySelectorAll('.filters button').forEach(button => {
            button.classList.remove('active');
        });
        
        if (filter) {
            document.getElementById(`filter-${filter}`).classList.add('active');
        } else {
            document.getElementById('filter-all').classList.add('active');
        }
    };

    // Event listeners para los botones de filtrado
    document.getElementById('filter-all').addEventListener('click', () => handleFilterButtonClick(''));
    document.getElementById('filter-active').addEventListener('click', () => handleFilterButtonClick('active'));
    document.getElementById('filter-inactive').addEventListener('click', () => handleFilterButtonClick('inactive'));
    document.getElementById('filter-canceled').addEventListener('click', () => handleFilterButtonClick('canceled'));
    document.getElementById('filter-completed').addEventListener('click', () => handleFilterButtonClick('completed'));

    // Renderizar todas las citas al cargar la página
    renderAppointments();
});

// Función para obtener el color del evento según el estado
function getEventColor(status) {
    switch (status) {
        case 'Activa':
            return 'blue';
        case 'Vencida':
            return 'orange';
        case 'Cancelado':
            return 'red';
        case 'Completado':
            return 'green';
        default:
            return 'grey';
    }
}

</script>
@stop