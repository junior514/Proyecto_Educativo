<div class="modal fade modal-slide-in-center" aria-hidden="true" role="dialog" tabindex="-1" id="modal-observacion">

    <div class="modal-dialog" role="document">
        {{-- {!! Form::open(['url' => 'store_observacion', 'method' => 'POST', 'autocomplete' => 'off', 'files' => 'true']) !!}
        {!! Form::token() !!} --}}
        <form action="" id="formulario_observacion" method="POST">
            @csrf
          
            <div class="modal-content">
                <div class="modal-header text-white" style="background: #0059D1;">
                    <h4 style="margin:0px" id="tituloObservacion">Crear Observación</h4>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <input type="hidden" name="idCredito" value="{{ old('idCredito', $c->idCredito) }}">
                        <input type="hidden" name="idObservacion"  id="idObservacion">
                        <div class="col-12">
                            <div class="form-group">
                                <label>Fecha <span class="text-danger" title="Campo obligatorio">*</span> </label>
                                <div class="input-group">
                                    <input type="date" class="form-control form-control-sm" name="fechaObs" id="fechaObs"
                                        autocomplete="off" value="{{ old('fechaObs', $fecha) }}" max=""
                                        required>
                                </div>
                                {!! $errors->first('fechaObs', '<span class="help-block text-danger">:message</span>') !!}
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label>Observaciones <span class="text-danger" title="Campo obligatorio">*</span>
                                </label>
                                <div class="input-group">
                                    <textarea class="form-control" name="detalleObs" id="detalleObs" rows="2" required>{{ old('detalleObs') }}</textarea>
                                </div>
                                {!! $errors->first('detalleObs', '<span class="help-block text-danger"><b>:message </b></span>') !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary" id="enviar">Guardar</button>
                </div>
            </div>
        </form>
    </div>
</div>
