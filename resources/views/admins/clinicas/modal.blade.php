<form method="post" id="storeClinica" action="{{route('admins.clinicas.createclinicas')}}">
    @method('post')
    @csrf
    <div class="modal fade" id="agregarClinica">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fs-5">Agregar Clinica</h5>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label>
                                    Nombre
                                </label>
                                <input type="text" class="form-control" id="nombre" name="nombre">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label>
                                    Dirección
                                </label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="direccion" name="direccion">
                                    <button type="button" class="btn btn-secondary" title="Buscar en el mapa" onclick="buscarUbicacion('direccion','mapModalCreate');">
                                        <i class="fa-solid fa-location-dot"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <iframe
                            id="mapModalCreate"
                            width="100%"
                            max-height="100%"
                            src="https://www.openstreetmap.org/export/embed.html?"
                            style="border: 1px solid black"
                            >
                            </iframe>
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