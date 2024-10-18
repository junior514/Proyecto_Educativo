<style>
    .imagen img {
        width: 100px;
        height: auto;
    }
</style>
<div class="modal fade modal-slide-in-right" aria-hidden="true" role="dialog" tabindex="-1"
    id="modal-add-{{ $users->id }}">
    {!! Form::model($users, ['method' => 'PATCH', 'route' => ['mi_perfil.update', $users->id], 'files' => 'true']) !!}
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
                                <input type="hidden" name="id" id="" value="{{ $users->id }}">
                                <input type="text" class="form-control form-control-sm" name="name"
                                    placeholder="Nombres" value="{{ empty(old('name')) ? $users->name : old('name') }}">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="form-group">
                            <label>N° Teléfono</label>
                            <div class="input-group a mb-6">
                                <input type="text" class="form-control form-control-sm" name="telUse"
                                    placeholder="Teléfono"
                                    value="{{ empty(old('telUse')) ? $users->telUse : old('telUse') }}">
                            </div>
                            @if ($errors->has('telUse'))
                                <span class="text-danger">{{ $errors->first('telUse') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="form-group">
                            <label>Correo</label>
                            <div class="input-group a mb-3">
                                <input type="text" class="form-control form-control-sm" name="email"
                                    placeholder="Correo Electrónico"
                                    value="{{ empty(old('email')) ? $users->email : old('email') }}">
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
                    @if (count($errors) > 0)
                        <div style="margin: 0px auto 0px auto">
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif
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
