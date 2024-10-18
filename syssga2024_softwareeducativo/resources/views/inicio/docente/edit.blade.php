@extends('layouts.admin')
@section('contenido')
    {!! Form::open([
        'url' => route('docente.update', $docente->idDocente),
        'method' => 'PUT',
        'autocomplete' => 'off',
    ]) !!}
    <div class="row mt-2">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5>
                        <b>Editar Docente</b>
                        <input type="hidden" name="idDocente" id="" value="{{ $docente->idDocente }}">
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-md-12 col-12">
                                    <div class="form-group">
                                        <label style="margin:0px" for="">Nombres</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control {{ $errors->has('nomDoc') ? 'is-invalid' : '' }}" name="nomDoc"
                                                placeholder="Nombres del docente" value="{{ empty(old('nomDoc')) ? $docente->nomDoc : old('nomDoc') }}" required>
                                        </div>
                                        {!! $errors->first('nomDoc', '<span class="help-block text-danger"><b>:message </b></span>') !!}
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label style="margin:0px" for="">N° Documento</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control enteros{{ $errors->has('nroDoc') ? 'is-invalid' : '' }}" name="nroDoc"
                                                placeholder="Nombres del docente" value="{{ empty(old('nroDoc')) ? $docente->nroDoc : old('nroDoc') }}" maxlength="8"
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
                                                placeholder="N° Teléfono" value="{{ empty(old('telDoc')) ? $docente->telDoc : old('telDoc') }}">
                                        </div>
                                        {!! $errors->first('telDoc', '<span class="help-block text-danger"><b>:message </b></span>') !!}
                                    </div>
                                </div>
                                <div class="col-md-12 col-12">
                                    <div class="form-group">
                                        <label style="margin:0px" for="">Dirección</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control {{ $errors->has('dirDoc') ? 'is-invalid' : '' }}" name="dirDoc"
                                                placeholder="Dirección domicilio" value="{{ empty(old('dirDoc')) ? $docente->dirDoc : old('dirDoc') }}">
                                        </div>
                                        {!! $errors->first('dirDoc', '<span class="help-block text-danger"><b>:message </b></span>') !!}
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label style="margin:0px" for="">Especialidad</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control {{ $errors->has('espDoc') ? 'is-invalid' : '' }}" name="espDoc"
                                                placeholder="Especilidad del docente" value="{{ empty(old('espDoc')) ? $docente->espDoc : old('espDoc') }}">
                                        </div>
                                        {!! $errors->first('espDoc', '<span class="help-block text-danger"><b>:message </b></span>') !!}
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label style="margin:0px" for="">Correo</label>
                                        <div class="input-group">
                                            <input type="email" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" name="email"
                                                placeholder="Ingrese el correo electrónico" value="{{ empty(old('email')) ? $docente->email : old('email') }}" >
                                        </div>
                                        {!! $errors->first('email', '<span class="help-block text-danger"><b>:message </b></span>') !!}
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
                        </div>

                    </div>
                </div>
                <div class="card-footer text-center">
                    <div style="margin: 0px auto 0px auto">
                        <div style="margin: 0px auto 0px auto">
                            <a href="{{ route('docente.index') }}" type="button" class="btn btn-danger ">Volver</a>
                            <button type="submit" class="btn btn-primary">Guardar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{ Form::close() }}
    @push('scripts')
        @if (Session::has('success'))
            <script type="text/javascript">
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    onOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                });
                Toast.fire({
                    icon: 'success',
                    title: '{{ Session::get('success') }}',
                    customClass: 'swal-pop',
                })
            </script>
        @elseif (Session::has('error'))
            <script type="text/javascript">
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    onOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                });
                Toast.fire({
                    icon: 'error',
                    title: '{{ Session::get('error') }}',
                    customClass: 'swal-pop',
                })
            </script>
        @endif
    @endpush
@endsection
