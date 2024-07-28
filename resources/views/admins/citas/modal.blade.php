<form method="post" id="storeCita" action="{{route('admins.citas.createcita')}}">
    @method('post')
    @csrf
    <div class="modal fade" id="agregarCita">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fs-5">Agendar Cita</h5>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <input type="hidden" id="id_user" name="id_user" value="{{Auth::user()->id}}">
                        <div class="col-12">
                            <div class="form-group">
                                <label>
                                    Fecha
                                </label>
                                <input type="datetime-local" class="form-control" id="fecha" name="fecha">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label>
                                    Nutriologo
                                </label>
                                <select class="form-control" id="id_doctor" name="id_doctor">
                                    @foreach($doctores as $doctor)
                                    <option value="{{$doctor->id}}">{{$doctor->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label>
                                    Razón de cita
                                </label>
                                <textarea class="form-control" id="nota" name="nota"></textarea>
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