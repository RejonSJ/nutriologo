<form method="post" id="cambiarLocal" action="{{route('admins.users.switchClinica')}}">
    @method('put')
    @csrf
    <div class="modal fade" id="editarClinica">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fs-5">Editar Clinica</h5>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <input type="hidden" class="form-control" id="idEdit" name="id">
                        <div class="col-12">
                            <div class="form-group">
                                <label>
                                    Clinica
                                </label>
                                <select class="form-control" id="clinicaEdit" name="id_clinica">
                                    @foreach($clinicas as $clinica)
                                    <option value="{{$clinica->id}}">{{$clinica->nombre}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Agregar</button>
                </div>
            </div>
        </div>
    </div>
</form>