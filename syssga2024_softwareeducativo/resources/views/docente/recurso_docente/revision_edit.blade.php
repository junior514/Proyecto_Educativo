<div class="modal fade modal-slide-in-center" aria-hidden="true" role="dialog" tabindex="-1"
    id="modal-revisionedit-{{ $ev->idEntregaTarea }}">
    <div class="modal-dialog">
        <form action="{{route('revisartarea_update', $ev->idEntregaTarea )}}" method="POST">
            @csrf
            @method('PUT')
            <div class="modal-content">
                <div class="modal-header text-white" style="background: #0059D1;">
                    <h4 style="margin: 0px">Editar Nota</h4>
                    <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label>Comentario </label>
                                <div class="input-group a mb-6">
                                    <textarea class="form-control form-control-sm {{ $errors->has('comentarioDocente') ? 'is-invalid' : '' }}"
                                        name="comentarioDocente"
                                        placeholder="Ingrese un comentario de la calificación (opcional).">{{ old('comentarioDocente', $ev->comentarioDocente) }}</textarea>
                                </div>
                                @if ($errors->has('comentarioDocente'))
                                    <span class="text-danger">{{ $errors->first('comentarioDocente') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label>Nota <span class="text-danger" title="Campo obligatorio">*</span> </label>
                                <div class="input-group a mb-3">
                                   
                                    <input type="number" name="nota" min="0" max="20" class="form-control form-control-sm {{ $errors->has('nota') ? 'is-invalid' : '' }}" 
                                        placeholder="Ingrese su nota" value="{{old('nota', $ev->nota)}}" required>
                                </div>
                                @if ($errors->has('nota'))
                                    <span class="text-danger">{{ $errors->first('nota') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center pb-4">
                    <div class="col-12 text-center">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </div>

            </div>
        </form>
    </div>
</div>
