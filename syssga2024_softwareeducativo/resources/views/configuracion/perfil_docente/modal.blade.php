<div class="modal fade modal-slide-in-right" aria-hidden="true" role="dialog" tabindex="-1"
    id="modal-add-{{ $users->idDocente }}">
    {!! Form::model($users, ['method' => 'PATCH', 'route' => ['perfil_docente.update', $users->idDocente], 'files' => 'true']) !!}
    {{ Form::token() }}
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header text-white" style="background: #0059D1">
                <h4 style="margin: 0px">
                    Mi perfíl</h4>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="row">
                    <div class="col-md-12 col-12">
                        <div class="form-group">
                            <label>Nombres</label>
                            <div class="input-group a mb-3">
                                <input type="hidden" name="idDocente" id="" value="{{ $users->idDocente }}">
                                <input type="text" class="form-control form-control-sm" name="nomDoc"
                                    placeholder="Nombres" value="{{ old('nomDoc', $users->nomDoc) }}">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-6">
                        <div class="form-group">
                            <label>N° Documento</label>
                            <div class="input-group a mb-6">
                                <input type="text" class="form-control form-control-sm" name="nroDoc"
                                    placeholder="Ingresando el N° Documento"
                                    value="{{ old('nroDoc', $users->nroDoc) }}">
                            </div>
                            @if ($errors->has('nroDoc'))
                                <span class="text-danger">{{ $errors->first('nroDoc') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6 col-6">
                        <div class="form-group">
                            <label>N° Teléfono</label>
                            <div class="input-group a mb-6">
                                <input type="text" class="form-control form-control-sm" name="telDoc"
                                    placeholder="Ingresando el N° Teléfono"
                                    value="{{ old('telDoc', $users->telDoc) }}">
                            </div>
                            @if ($errors->has('telDoc'))
                                <span class="text-danger">{{ $errors->first('telDoc') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="form-group">
                            <label>Correo</label>
                            <div class="input-group a mb-3">
                                <input type="text" class="form-control form-control-sm" name="email"
                                    placeholder="Correo Electrónico"
                                    value="{{ old('email', $users->email) }}">
                            </div>
                            @if ($errors->has('email'))
                                <span class="text-danger">{{ $errors->first('email') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="form-group">
                            <label>Contraseña</label>
                            <div class="input-group a mb-6">
                                <input type="password" id="password"
                                    class="form-control form-control-sm {{ $errors->has('password') ? 'is-invalid' : '' }}"
                                    name="password" placeholder="">
                            </div>
                            @if ($errors->has('password'))
                                <span class="text-danger">{{ $errors->first('password') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="form-group">
                            <label>Confirmar Contraseña</label>
                            <div class="input-group a mb-6">
                                <input id="password-confirm" type="password"
                                    class="form-control  form-control-sm {{ $errors->has('password_confirmation') ? 'is-invalid' : '' }}"
                                    name="password_confirmation" autocomplete="new-password">
                            </div>
                            @if ($errors->has('password_confirmation'))
                                <span class="text-danger">{{ $errors->first('password_confirmation') }}</span>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- <div class="input-group a mb-3">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="far fa-image fa-2x-x"></i><span
                                    class="tooltiptext">Ingrese su Fotografía</span></span>
                        </div>
                        <input type="file" name="imageUsers" id="Imagen" accept="image/png, .jpeg, .jpg, image/gif"
                            class="form-control" onchange="mostrar()">
                    </div>

                    <div>
                    <img src="{{ asset('users/' . $users->imageUsers) }}" id="img" / width="100" height="100">
                    </div>
                </div> --}}

                <div class="modal-footer">
                    {{-- @if (count($errors) > 0)
                        <div style="margin: 0px auto 0px auto">
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif --}}
                    <div style="margin: 0px auto 0px auto">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Confirmar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{ Form::Close() }}
</div>
