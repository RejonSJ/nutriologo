@extends('adminlte::page')

@section('title', 'TEST')

@section('content_header')
    {{-- <h1 class="m-0 text-dark">TEST</h1> --}}
@stop

@section('content')
    <div class="row">
        <script>
            var messageDetect = 0;
            var sessionType = '';
        </script>
        @if(Session::has('success'))
            <script>
                messageDetect = 1;
            </script>
        @endif
        <div class="col-12">
            <div class="card main-card">
                <div class="card-header">
                    <div class="card-title">
                        Libros
                    </div>
                </div>
                <div class="card-body">

                    
                    
                    <form method="post" action="{{route('admins.users.deleteUser', 3)}}">
                    @method('delete')
                    @csrf
                        <select name="id_autor">
                            @foreach ($autores as $autor)
                                <option value="{{$autor->id}}">{{$autor->nombre}}</option>
                            @endforeach
                        </select>
                        <button type="submit" class="btn btn-primary" title="Submit"><i class="fa-solid fa-paper-plane"></i></button>
                    </form>

                </div>
            </div>
        </div>
    </div>
@stop

@section('js')
    <script>
        $(document).ready(function(){
            
        })

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
