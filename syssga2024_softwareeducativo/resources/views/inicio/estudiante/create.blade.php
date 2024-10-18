<div class="modal fade modal-slide-in-center" aria-hidden="true" role="dialog" tabindex="-1" id="modal-add">
    {!! Form::open(['url' => 'inicio/estudiante', 'method' => 'POST', 'autocomplete' => 'off', 'files' => 'true']) !!}
    {!! Form::token() !!}
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header text-white" style="background: #0059D1;">
                <h4 style="margin:0px">Nuevo Estudiante</h4>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="card-body">

                <div class="row">
                    <div class="col-md-12 col-12">
                        <div class="form-group">
                            <label>Nombre <span class="text-danger" title="Campo obligatorio">*</span> </label>
                            <div class="input-group">
                                <input type="text" class="form-control form-control-sm" name="nomEst"
                                    placeholder="Ingrese nombre del estudiante" autocomplete="off" style="text-transform:uppercase;"
                                    value="{{ old('nomEst') }}" onkeyup="javascript:this.value=this.value.toUpperCase();" required>
                            </div>
                            {!! $errors->first('nomEst', '<span class="help-block text-danger"><b>:message </b></span>') !!}
                        </div>
                    </div>
                    <div class="col-md-5 col-12">
                        <div class="form-group">
                            <label>Tipo Documento <span class="text-danger" title="Campo obligatorio">*</span>
                            </label>
                            <div class="input-group">
                                <select name="tipoDoc" class="form-control form-control-sm" required>
                                    <option value="" selected hidden>Seleccionar</option>
                                    @foreach ($tipo_documento as $key => $value)
                                        <option value="{{ $key }}"
                                            {{ $key == old('tipoDoc') ? 'selected' : '' }}>
                                            {{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                            {!! $errors->first('tipoDoc', '<span class="help-block text-danger"><b>:message </b></span>') !!}
                        </div>
                    </div>
                    <div class="col-md-7 col-12">
                        <div class="form-group">
                            <label>N° Documento <span class="text-danger" title="Campo obligatorio">*</span>
                            </label>
                            <div class="input-group">
                                <input type="text" class="form-control form-control-sm enteros" name="nroDoc"
                                    id="nroDoc" placeholder="Ingrese el n° de documento" autocomplete="off"
                                    value="{{ old('nroDoc') }}" required>
                            </div>
                            {!! $errors->first('nroDoc', '<span class="help-block text-danger"><b>:message </b></span>') !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-5 col-12">
                        <div class="form-group">
                            <label>Teléfono </label>
                            <div class="input-group">
                                <input type="text" class="form-control form-control-sm" name="telEst" placeholder=""
                                    autocomplete="off" value="{{ old('telEst') }}" >
                            </div>
                            {!! $errors->first('telEst', '<span class="help-block text-danger"><b>:message </b></span>') !!}
                        </div>
                    </div>
                    <div class="col-md-7 col-12">
                        <div class="form-group">
                            <label>Dirección </label>
                            <div class="input-group">
                                <input type="text" class="form-control form-control-sm" name="dirEst" placeholder=""
                                    autocomplete="off" value="{{ old('dirEst') }}">
                            </div>
                            {!! $errors->first('dirEst', '<span class="help-block text-danger"><b>:message </b></span>') !!}
                        </div>
                    </div>
                    <div class="col-md-12 col-12">
                        <div class="form-group">
                            <label>Correo  </label>
                            <div class="input-group">
                                <input type="text" class="form-control form-control-sm" name="email"
                                    placeholder="" autocomplete="off" value="{{ old('email') }}">
                            </div>
                            {!! $errors->first('email', '<span class="help-block text-danger"><b>:message </b></span>') !!}
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="form-group">
                            <label>Género <span class="text-danger" title="Campo obligatorio">*</span> </label>
                            <div class="input-group">
                                @php($genero = ['MASCULINO', 'FEMENINO'])
                                <select name="generoEst" class="form-control form-control-sm" required>
                                    <option value="" selected hidden>Seleccionar</option>
                                    @foreach ($genero as $g)
                                        <option value="{{ $g }}"
                                            {{ $g == old('generoEst') ? 'selected' : '' }}>{{ $g }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            {!! $errors->first('generoEst', '<span class="help-block text-danger"><b>:message </b></span>') !!}
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="form-group">
                            <label>F. Nacimiento</label>
                            <div class="input-group">
                                <input type="date" class="form-control form-control-sm" name="f_nacimiento"
                                    placeholder="" autocomplete="off" value="{{ old('f_nacimiento') }}">
                            </div>
                            {!! $errors->first('f_nacimiento', '<span class="help-block text-danger"><b>:message </b></span>') !!}
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group ">
                            <label for="">Foto</label><br>
                            <div class="input-group ">
                                <input type="file" name="fotoEst" id="Imagen" accept="image/png, .jpeg, .jpg, image/gif" class="form-control form-control-sm"
                                    onchange="mostrar()">
                            </div>
                            <img src="{{ asset('estudiante/auxiliar.png') }}" id="img" width="100"
                                height="100">
                            @if ($errors->has('fotoEst'))
                                <span class="text-danger">{{ $errors->first('fotoEst') }}</span>
                            @endif
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
</div>
{{ Form::Close() }}
