<div class="modal fade modal-slide-in-center" aria-hidden="true" role="dialog" tabindex="-1" id="modal-add-leccion">
    <div class="modal-dialog">
        <form action="{{ route('storecuestionario_leccion') }}" method="post" id="formLeccion">
            @csrf
            <div class="modal-content">
                <div class="modal-header text-white" style="background: #0059D1;">
                    <h4 style="margin: 0px">Nueva Lección</h4>
                    <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label>Nombre de Lección</label>
                                <div class="input-group a mb-6">
                                    <input type="text"
                                        class="form-control form-control-sm {{ $errors->has('nombreLeccion') ? 'is-invalid' : '' }}"
                                        name="nombreLeccion" placeholder=" " value="{{ old('nombreLeccion') }}" required>
                                </div>
                                @if ($errors->has('nombreLeccion'))
                                    <span class="text-danger">{{ $errors->first('nombreLeccion') }}</span>
                                @endif
                            </div>
                        </div>
                        <input type="hidden" name="nroModulo" value="{{$nroModulo}}">
                        <input type="hidden" name="idGrupo" value="{{$grupo->idGrupo}}">
                    </div>
                </div>
                <div class="row justify-content-center pb-4">
                    <div class="col-12 text-center">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary" id="enviarLeccion">Guardar</button>
                    </div>
                </div>

            </div>
        </form>
    </div>
</div>
