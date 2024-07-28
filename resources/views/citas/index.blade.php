@extends('adminlte::page')

@section('title', 'Citas')

@section('content_header')
    <h1 class="m-0 text-dark"></h1>
@stop

@section('css')
<link rel="stylesheet" href="../css/prestamos.css">
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        <h5 class="mb-0">Citas</h5>
                    </div>
                    <div class="card-actions">
                        <button type="button" class="btn btn-sm btn-primary" title="Agregar" data-toggle="modal" data-target="#agregarCita" data-keyboard="false" data-backdrop="static">
                            <i class="fa-solid fa-circle-plus"></i> Agendar
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form>
                        @csrf
                        <div class="row">
                            <div class="col-6 col-md">
                                <input type="date" title="Fecha inicial" class="form-control" id="filter-fechainicial" name="fechainicial">
                            </div>
                            <div class="col-6 col-md">
                                <input type="date" title="Fecha final" class="form-control" id="filter-fechafinal" name="fechafinal">
                            </div>
                            <div class="col-12 col-sm col-md">
                                <select class="form-control" id="filter-doctor" name="doctor">
                                    @foreach($doctores as $doctor)
                                    <option value="{{$doctor->id}}">{{$doctor->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="d-none d-md-block col-auto col-md"></div>
                            <div class="col col-sm-auto">
                                <button type="submit" class="btn btn-primary d-none d-sm-block">
                                    <i class="fa-solid fa-filter"></i>
                                </button>
                                <button type="submit" class="btn btn-primary w-100 d-block d-sm-none">
                                    Filtrar <i class="fa-solid fa-filter"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="userTable" class="table table-sm table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th class="col-2">Fecha de cita</th>
                                    <th class="col-2">Nutriologo</th>
                                    <th class="col-2">Clinica</th>
                                    <th class="col-5">Nota</th>
                                    <th class="col-1">Estado</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($citas as $cita)
                                    <tr>
                                        <td>{{$cita->fecha}}</td>
                                        <td>{{$cita->doctor}}</td>
                                        <td>
                                            <div class="row">
                                                <div class="col">
                                                    {{$cita->clinica}}
                                                </div>
                                                <div class="col-auto">
                                                    <a class="btn btn-sm btn-primary" target="_blank" href="https://www.google.com/maps/search/{{urlencode($cita->direccion)}}">
                                                        <i class="fa-solid fa-magnifying-glass-location"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{$cita->nota}}</td>
                                        @switch($cita->estado)
                                            @case('')
                                                @if (strtotime($today)==strtotime(date('Y-m-d', strtotime($cita->fecha))))
                                                <td>Hoy</td>
                                                @else
                                                @if (strtotime($today)<strtotime(date('Y-m-d', strtotime($cita->fecha))))
                                                <td>Pendiente</td>
                                                @else
                                                <td>Vencido</td>
                                                @endif
                                                @endif
                                                @break
                                                @default
                                                <td>{{$cita->estado}}</td>
                                                @break
                                        @endswitch
                                        
                                        <td class="buttons-form">
                                            <div class="button-wrapper">
                                                @if ((strtotime($today)<=strtotime(date('Y-m-d', strtotime($cita->fecha)))) && ($cita->estado!='Cancelado'))
                                                <form method="post" action="{{route('admins.citas.updatecita')}}" id="form-update-{{$cita->id}}">
                                                    @method('put')
                                                    @csrf
                                                    <input type="hidden" id="editId-{{$cita->id}}" name="id" value="{{$cita->id}}">
                                                    <input type="hidden" id="editStatus-{{$cita->id}}" name="estado" value="Cancelado">
                                                    <button type="button" class="btn btn-danger" title="Cancelar" onclick="eliminar({{$cita->id}})">
                                                        <i class="fa-solid fa-ban"></i>
                                                    </button>
                                                </form>
                                                @else
                                                <button type="button" class="btn btn-danger disabled" title="Esta cita no puede cancelarse">
                                                    <i class="fa-solid fa-ban"></i>
                                                </button>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
 @include('citas.modal')
@stop

@section('js')
<script>
    $(document).ready(function(){
        $('#userTable').DataTable({
            order: [[1, 'desc']],
            language:{
                url : '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-MX.json'
            },
            'columnDefs' : [
                {'targets': 3,'createdCell': function (td, cellData,rowData,row,col){}},
            ]
        });
        
        $('#filter-doctor').select2({
            placeholder: "Seleccionar nutriologo",
            allowClear: true
        });

        $('#filter-fechainicial').val('{{$fechainicial}}');
        $('#filter-fechafinal').val('{{$fechafinal}}');
        $('#filter-doctor').val('{{$nutriologo}}').change();
    })

    function eliminar(id){
        Swal.fire({
            title: '¿Desea cancelar la cita?',
            text: "Esta acción es permanente.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Eliminar',
            cancelButtonText: 'Cancelar'
            }).then((result) => {
            if (result.isConfirmed) {
                $('#form-update-'+id).submit();
            }
        })
    }
</script>
    
@stop
