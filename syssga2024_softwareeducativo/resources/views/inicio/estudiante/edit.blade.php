@extends('layouts.admin')
@section('contenido')
    {!! Form::open([
        'url' => route('estudiante.update', $estudiante->idEstudiante),
        'method' => 'PUT',
        'autocomplete' => 'off',
        'files' => 'true'
    ]) !!}
    <div class="row mt-2">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>
                        <b>Editar Estudiante</b>
                        <input type="hidden" name="idEstudiante" id="" value="{{ $estudiante->idEstudiante }}">
                    </h4>
                </div>
                <div class="card-body">
                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-md-12 col-12">
                                    <div class="form-group">
                                        <label>Nombre <span class="text-danger" title="Campo obligatorio">*</span> </label>
                                        <div class="input-group a mb-3">
                                            <input type="text"
                                                class="form-control {{ $errors->has('nomSuc') ? 'is-invalid' : '' }}"
                                                name="nomEst" placeholder="Ingrese nombre del estudiante"
                                                autocomplete="off" value="{{ $estudiante->nomEst }}" required>
                                        </div>
                                        {!! $errors->first('nomEst', '<span class="help-block text-danger"><b>:message </b></span>') !!}
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label>Tipo Documento <span class="text-danger" title="Campo obligatorio">*</span>
                                        </label>
                                        <div class="input-group">
                                            <select name="tipoDoc" class="form-control" required>
                                                @foreach ($tipo_documento as $key => $value)
                                                    <option value="{{ $key }}"
                                                        {{ empty(old('tipoDoc')) ? ($key == $estudiante->tipoDoc ? 'selected' : '') : ($key == old('tipoDoc') ? 'selected' : '') }}>
                                                        {{ $value }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        {!! $errors->first('tipoDoc', '<span class="help-block text-danger"><b>:message </b></span>') !!}
                                    </div>
                                </div>
                                <div class="col-md-6 col-12" id="bloque_nroDocEst"
                                    style="display: {{ $estudiante->idTipDoc == 1 ? 'none' : 'block' }}">
                                    <div class="form-group">
                                        <label>N° Documento <span class="text-danger" title="Campo obligatorio">*</span>
                                        </label>
                                        <div class="input-group a mb-3">
                                            <input type="text"
                                                class="form-control {{ $errors->has('nroDoc') ? 'is-invalid' : '' }}"
                                                name="nroDoc" id="nroDoc" placeholder="Ingrese el n° de documento"
                                                autocomplete="off" value="{{ $estudiante->nroDoc }}" required>
                                        </div>
                                        {!! $errors->first('nroDoc', '<span class="help-block text-danger"><b>:message </b></span>') !!}
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label>Teléfono
                                        </label>
                                        <div class="input-group a mb-3">
                                            <input type="text"
                                                class="form-control {{ $errors->has('telEst') ? 'is-invalid' : '' }}"
                                                name="telEst" placeholder="" autocomplete="off"
                                                value="{{ $estudiante->telEst }}">
                                        </div>
                                        {!! $errors->first('telEst', '<span class="help-block text-danger"><b>:message </b></span>') !!}
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label>Dirección </label>
                                        <div class="input-group a mb-3">
                                            <input type="text"
                                                class="form-control {{ $errors->has('dirEst') ? 'is-invalid' : '' }}"
                                                name="dirEst" placeholder="" autocomplete="off"
                                                value="{{ $estudiante->dirEst }}">
                                        </div>
                                        {!! $errors->first('dirEst', '<span class="help-block text-danger"><b>:message </b></span>') !!}
                                    </div>
                                </div>

                                <div class="col-md-3 col-6">
                                    <div class="form-group">
                                        <label>Género <span class="text-danger" title="Campo obligatorio">*</span> </label>
                                        <div class="input-group a mb-3">
                                            @php($genero = ['MASCULINO', 'FEMENINO'])
                                            <select name="generoEst"
                                                class="form-control {{ $errors->has('generoEst') ? 'is-invalid' : '' }}">
                                                @foreach ($genero as $g)
                                                    <option value="{{ $g }}"
                                                        {{ $g == $estudiante->generoEst ? 'selected' : '' }}>
                                                        {{ $g }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        {!! $errors->first('generoEst', '<span class="help-block text-danger"><b>:message </b></span>') !!}
                                    </div>
                                </div>
                                <div class="col-md-3 col-6">
                                    <div class="form-group">
                                        <label>F. Nacimiento</label>
                                        <div class="input-group a mb-3">
                                            <input type="date"
                                                class="form-control {{ $errors->has('f_nacimiento') ? 'is-invalid' : '' }}"
                                                name="f_nacimiento" placeholder="" autocomplete="off"
                                                value="{{ $estudiante->f_nacimiento }}">
                                        </div>
                                        {!! $errors->first('f_nacimiento', '<span class="help-block text-danger"><b>:message </b></span>') !!}
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label>Correo </label>
                                        <div class="input-group a mb-3">
                                            <input type="text"
                                                class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}"
                                                name="email" placeholder="" autocomplete="off"
                                                value="{{ empty(old('email')) ? $estudiante->email : old('email') }}">
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
                                <div class="col-md-6 col-12">
                                    <div class="form-group ">
                                        <label for="">Foto</label><br>
                                        <div class="input-group ">
                                            <input type="file" name="fotoEst" id="Imagen" accept="image/png, .jpeg, .jpg, image/gif" class="form-control form-control-sm"
                                                onchange="mostrar()">
                                        </div>
                                        @php($nombre_fichero = public_path('estudiante/' . $estudiante->fotoEst))
                                        @if (file_exists($nombre_fichero) && !empty($estudiante->fotoEst))
                                            <img src="{{ asset('estudiante/' . $estudiante->fotoEst) }}" id="img" width="100" height="100">
                                        @else
                                            <img src="{{ asset('estudiante/auxiliar.png') }}" id="img" width="100" height="100">
                                        @endif
                                        @if ($errors->has('fotoEst'))
                                            <span class="text-danger">{{ $errors->first('fotoEst') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-center">
                    <a href="{{ route('estudiante.index') }}" type="button" class="btn btn-danger ">Volver</a>
                    <button type="submit" class="btn btn-primary">Guardar</button>
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
        <script type="text/javascript">
            function mostrar() {
                var archivo = document.getElementById("Imagen").files[0];
                var reader = new FileReader();
                if (archivo) {
                    reader.readAsDataURL(archivo);
                    reader.onloadend = function() {
                        document.getElementById("img").src = reader.result;
                        // document.getElementById("nombre_imagen").value = archivo.name;
                    }
                } else {
                    document.getElementById("img").src = "";
                    // document.getElementById("nombre_imagen").value = "";
                }
            }
        </script>
    @endpush
@endsection
