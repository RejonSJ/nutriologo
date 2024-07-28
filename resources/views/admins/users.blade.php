@extends('adminlte::page')

@section('title', 'Usuarios')

@section('content_header')
    {{-- <h1 class="m-0 text-dark">Usuarios</h1> --}}
@stop

@section('css')
<link rel="stylesheet" href="../css/users.css">
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card main-card">
                <div class="card-header">
                    <div class="card-title">
                        Usuarios
                    </div>
                </div>
                <script>
                    var messageDetect = 0;
                    var sessionType = '';
                </script>
                @if(Session::has('success'))
                    <script>
                        messageDetect = 1;
                    </script>
                @endif
                <div class="card-body">
                    <table id="userTable" class="table table-sm table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Usuario</th>
                                <th>Correo</th>
                                <th>Rol</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td class="col-5">{{$user->name}}</td>
                                    <td class="col-5">{{$user->email}}</td>
                                    <td class="col-2">{{$user->role}}</td>
                                    <td class="buttons-form">
                                        <div class="button-wrapper">
                                            @if($user->id==1)
                                            <button class="btn btn-secondary disabled" title="No se puede cambiar el rol del administrador principal"><i class="fa-solid fa-user"></i></button>
                                            <button class="btn btn-success disabled" title="No se puede cambiar el rol del administrador principal"><i class="fa-solid fa-user-doctor"></i></button>
                                            <button class="btn btn-danger disabled" title="No se puede eliminar al administrador principal"><i class="fa-solid fa-trash-can fa-fw"></i></button>
                                            @else

                                            @if ($user->role!='admin')
                                            <form action="{{route('admins.users.switchRole')}}">
                                                <input type="hidden" name="id" value="{{$user->id}}">
                                                <input type="hidden" name="role" value="admin">
                                                <button class="btn btn-primary" title="Cambiar a administrador"><i class="fa-solid fa-user-shield fa-fw"></i></button>
                                            </form>
                                            @endif
                                            @if ($user->role!='user')
                                            <form action="{{route('admins.users.switchRole')}}">
                                                <input type="hidden" name="id" value="{{$user->id}}">
                                                <input type="hidden" name="role" value="user">
                                                <button class="btn btn-secondary" title="Cambiar a usuario"><i class="fa-solid fa-user"></i></button>
                                            </form>
                                            @endif
                                            @if ($user->role!='doctor')
                                            <form action="{{route('admins.users.switchRole')}}">
                                                <input type="hidden" name="id" value="{{$user->id}}">
                                                <input type="hidden" name="role" value="doctor">
                                                <button class="btn btn-success" title="Cambiar a doctor"><i class="fa-solid fa-user-doctor"></i></button>
                                            </form> 
                                            @else
                                            <button type="button" class="btn btn-success" title="Clínica" onclick="editar({{json_encode($user)}})">
                                                <i class="fa-solid fa-house-medical"></i>
                                            </button>
                                            @endif

                                            <form method="post" action="{{route('admins.users.deleteUser',$user->id)}}" id="form-delete-{{$user->id}}">
                                            @method('delete')
                                            @csrf
                                                <button type="button" class="btn btn-danger" title="Eliminar usuario" onclick="eliminar({{$user->id}})"><i class="fa-solid fa-trash-can fa-fw"></i></button>
                                            </form>

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
@include('admins.clinicaModal')
@stop
@section('js')
<script>
    $(document).ready(function(){
        $('#userTable').DataTable();
        $('#clinicaEdit').select2({
            placeholder: "Seleccionar clinica",
            allowClear: true
        });
    })
    function eliminar(id){
        Swal.fire({
            title: '¿Deseas eliminar el usuario?',
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
    function editar(user){
        document.getElementById('idEdit').value = user.id;
        document.getElementById('clinicaEdit').value = user.id_clinica;
        $('#clinicaEdit').val(user.id_clinica).trigger('change');
        $('#editarClinica').modal({backdrop: 'static', keyboard: false}, 'show');
    }
    if(messageDetect==1){
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
    }
</script>
@stop