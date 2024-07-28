@extends('adminlte::page')

@section('title', 'Clínicas')

@section('content_header')
    {{-- <h1 class="m-0 text-dark">Usuarios</h1> --}}
@stop

@section('css')
<link rel="stylesheet" href="../css/libros.css">
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card main-card">
                <div class="card-header">
                    <div class="card-title">
                        Clínicas
                    </div>
                    <div class="card-actions">
                        <button type="button" class="btn btn-sm btn-primary" title="Agregar" data-toggle="modal" data-target="#agregarClinica" data-keyboard="false" data-backdrop="static">
                            <i class="fa-solid fa-circle-plus"></i> Agregar
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <table id="clinicasTable" class="table table-sm table-striped table-bordered">
                        <thead>
                            <tr>
                                <th class="col-5">Clínica</th>
                                <th class="col-6">Dirección</th>
                                <th class="col-1">Doctores</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($clinicas as $clinica)
                            <tr>
                                <td>{{$clinica->nombre}}</td>
                                <td>{{$clinica->direccion}}</td>
                                <td>{{$clinica->doctores}}</td>
                                <td class="buttons-form">
                                    <div class="button-wrapper">
                                        <button type="button" class="btn btn-success" title="Editar" onclick="editar({{json_encode($clinica)}})">
                                            <i class="fa-solid fa-pen-to-square fa-fw"></i>
                                        </button>
                                        <form method="post" action="{{route('admins.clinicas.deleteclinicas',$clinica->id)}}" id="form-delete-{{$clinica->id}}">
                                            @method('delete')
                                            @csrf
                                                <button type="button" class="btn btn-danger" title="Eliminar" onclick="eliminar({{$clinica->id}})"><i class="fa-solid fa-trash-can fa-fw"></i></button>
                                        </form>
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
@include('admins.clinicas.modal')
@include('admins.clinicas.modalEdit')
@stop
@section('js')
@if(Session::has('success'))
<script>
    Swal.fire({
        position: 'top-end',
        text: '{{$message = Session::get('success')}}',
        icon: 'success',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        toast: true,
        iconColor: 'white',
        customClass: {
            popup: 'colored-toast'
        },
    })
</script>
@endif
<script>
    $(document).ready(function(){
        $('#clinicasTable').DataTable();
    })
    function eliminar(id){
        Swal.fire({
            title: '¿Deseas eliminar el local?',
            text: "Esta acción es permanente.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Eliminar',
            cancelButtonText: 'Cancelar'
            }).then((result) => {
            if (result.isConfirmed) {
                $('#form-delete-'+id).submit();
            }
        })
    }
    function editar(clinica){
        document.getElementById('idEdit').value = clinica.id;
        document.getElementById('nombreEdit').value = clinica.nombre;
        document.getElementById('direccionEdit').value = clinica.direccion;
        $('#editarClinica').modal({backdrop: 'static', keyboard: false}, 'show');
    }
</script>
@stop