<div class="modal fade modal-slide-in-center" aria-hidden="true" role="dialog" tabindex="-1" id="modal-add">
    <form method="POST" action="{{ route('forma_pago.store') }}">
        @csrf
    <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header text-white" style="background: #0059D1">
                   <h4 style="margin:0px">Nueva Forma de Pago</h4>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nombre de la forma de pago<span class="text-danger" title="Campo obligatorio">*</span>
                        </label>
                        <div class="input-group">
                            <input type="text"
                                class="form-control form-control-sm {{ $errors->has('nombreFP') ? 'is-invalid' : '' }}"
                                name="nombreFP" placeholder=" " autocomplete="off" value="{{ old('nombreFP') }}"
                                required>
                        </div>
                        {!! $errors->first('nombreFP', '<span class="help-block text-danger"><b>:message </b></span>') !!}
                    </div>
                </div>
                <div class="modal-footer">
                    <div style="margin: 0px auto 0px auto">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </div>
            </div>
        
    </div>
    </form>
</div>

