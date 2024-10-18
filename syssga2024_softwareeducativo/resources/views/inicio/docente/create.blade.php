<div class="modal fade modal-slide-in-center" aria-hidden="true" role="dialog" tabindex="-1" id="modal-add">
    {!! Form::open(['url' => 'inicio/docente', 'method' => 'POST', 'autocomplete' => 'off']) !!}
    {!! Form::token() !!}

    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">

            <div class="modal-header text-white" style="background: #0059D1;">
                <h4 style="margin:0px">Nuevo Docente</h4>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 col-12">
                            <div class="form-group">
                                <label style="margin:0px" for="">Nombres <span class="text-danger" title="Campo Obligatorio">*</span></label>
                                <div class="input-group">
                                    <input type="text" class="form-control {{ $errors->has('nomDoc') ? 'is-invalid' : '' }}" name="nomDoc"
                                        placeholder="Nombres del docente" value="{{ old('nomDoc') }}" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" required>
                                </div>
                                {!! $errors->first('nomDoc', '<span class="help-block text-danger"><b>:message </b></span>') !!}
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label style="margin:0px" for="">N° Documento <span class="text-danger" title="Campo Obligatorio">*</span></label>
                                <div class="input-group">
                                    <input type="text" class="form-control enteros{{ $errors->has('nroDoc') ? 'is-invalid' : '' }}" name="nroDoc"
                                        placeholder="Nombres del docente" value="{{ old('nroDoc') }}" maxlength="8"
                                        pattern="[0-9]{8}" title="El valor ingresado debe ser un n° de 8 digitos." required>
                                </div>
                                {!! $errors->first('nroDoc', '<span class="help-block text-danger"><b>:message </b></span>') !!}
                            </div>
                        </div>

                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label style="margin:0px" for="">Teléfono</label>
                                <div class="input-group">
                                    <input type="text" class="form-control {{ $errors->has('telDoc') ? 'is-invalid' : '' }}" name="telDoc"
                                        placeholder="N° Teléfono" value="{{ old('telDoc') }}">
                                </div>
                                {!! $errors->first('telDoc', '<span class="help-block text-danger"><b>:message </b></span>') !!}
                            </div>
                        </div>
                        <div class="col-md-12 col-12">
                            <div class="form-group">
                                <label style="margin:0px" for="">Correo</label>
                                <div class="input-group">
                                    <input type="email" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" name="email"
                                        placeholder="Ingrese el correo electrónico" value="{{ old('email') }}" >
                                </div>
                                {!! $errors->first('email', '<span class="help-block text-danger"><b>:message </b></span>') !!}
                            </div>
                        </div>
                        <div class="col-md-12 col-12">
                            <div class="form-group">
                                <label style="margin:0px" for="">Dirección</label>
                                <div class="input-group">
                                    <input type="text" class="form-control {{ $errors->has('dirDoc') ? 'is-invalid' : '' }}" name="dirDoc"
                                        placeholder="Dirección domicilio" value="{{ old('dirDoc') }}">
                                </div>
                                {!! $errors->first('dirDoc', '<span class="help-block text-danger"><b>:message </b></span>') !!}
                            </div>
                        </div>
                        <div class="col-md-12 col-12">
                            <div class="form-group">
                                <label style="margin:0px" for="">Especialidad</label>
                                <div class="input-group">
                                    <input type="text" class="form-control {{ $errors->has('espDoc') ? 'is-invalid' : '' }}" name="espDoc"
                                        placeholder="Especilidad del docente" value="{{ old('espDoc') }}">
                                </div>
                                {!! $errors->first('espDoc', '<span class="help-block text-danger"><b>:message </b></span>') !!}
                            </div>
                        </div>
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
</div>
{{ Form::Close() }}
