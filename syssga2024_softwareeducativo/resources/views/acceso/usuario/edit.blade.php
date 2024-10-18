@extends('layouts.admin')
@section('contenido')
    <style>
        .imagen img {
            background: #f8eded;
            width: 100px;
            height: auto;
        }
    </style>
    
    <div class="row mt-2">
        <div class="col-md-12">
            <form method="PUT" autocomplete="off" action="{{ route('usuario.update', $usuario->id) }}" class="card">
                <div class="card-header">
                    <h4>
                        <b>Editar | {{ 'Usuario' }}</b>
                        <input type="hidden" name="id" value="{{ $usuario->id }}">
                        <h4>
                </div>
                <div class="card-body">
                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            <div class="row">
                                {{-- <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label>Tipo de Rol</label>
                                        <div class="input-group a mb-6">
                                            <select name="tipUse" class="form-control form-control-sm {{ $errors->has('tipUse') ? 'is-invalid' : '' }}" required>
                                                <option value="" selected hidden>Seleccionar</option>
                                                @foreach ($tipo as $t)
                                                    <option value="{{$t}}" {{empty(old('tipUse')) ? ($usuario->tipUse == $t ? 'selected' : '') : (old('tipUse') == $t ? 'selected' : '')}}>{{$t}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @if ($errors->has('telUse'))
                                            <span class="text-danger">{{ $errors->first('tipUse') }}</span>
                                        @endif
                                    </div>
                                </div> --}}
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label>N° Doc</label>
                                        <div class="input-group a mb-6">
                                            <input type="text" class="form-control form-control-sm {{ $errors->has('nroDoc') ? 'is-invalid' : '' }}" name="nroDoc"
                                                placeholder=" " value="{{ old('nroDoc', $usuario->nroDoc) }}">
                                        </div>
                                        @if ($errors->has('nroDoc'))
                                            <span class="text-danger">{{ $errors->first('nroDoc') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label>Nombres y Apellidos<span class="text-danger"
                                                title="Campo obligatorio">*</span></label>
                                        <div class="input-group a mb-3">
                                            <input type="text"
                                                class="form-control form-control-sm {{ $errors->has('name') ? 'is-invalid' : '' }}"
                                                name="name" placeholder=" "
                                                value="{{ empty(old('name')) ? $usuario->name : old('name') }}" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label>Celular</label>
                                        <div class="input-group a mb-6">
                                            <input type="text"
                                                class="form-control form-control-sm {{ $errors->has('telUse') ? 'is-invalid' : '' }}"
                                                name="telUse" placeholder=" "
                                                value="{{ empty(old('telUse')) ? $usuario->telUse : old('telUse') }}">
                                        </div>
                                        @if ($errors->has('telUse'))
                                            <span class="text-danger">{{ $errors->first('telUse') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label>Correo<span class="text-danger" title="Campo obligatorio">*</span></label>
                                        <div class="input-group a mb-3">
                                            <input type="email"
                                                class="form-control form-control-sm {{ $errors->has('email') ? 'is-invalid' : '' }}"
                                                name="email" placeholder=" "
                                                value="{{ empty(old('email')) ? $usuario->email : old('email') }}" required>
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
                                        <label>Repetir Contraseña</label>
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
                    <div class="card-footer text-center">
                        <div style="margin: 0px auto 0px auto">
                            <div style="margin: 0px auto 0px auto">
                                <a href="{{ route('usuario.index') }}" type="button" class="btn btn-danger ">Cancelar</a>
                                <button type="submit" class="btn btn-primary">Modificar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <div class="mt-4 col-6">
                <form class="mb-2" method="POST" action="/acceso/createserie">
                    @csrf
                    <input type="hidden" name="id" value="{{ $usuario->id }}">
                    <select class="form-control mb-3" name="tipo_doc">
                        @foreach ($tipos_doc as $tipo)
                            <option value="{{$tipo->idTipoDoc}}">{{ $tipo->nombre }}</option>
                        @endforeach
                    </select>
                    <input type="text" name="serie" class="form-control" placeholder="Serie">
                    <button type="submit" class="btn btn-primary mt-2 mb-2">Agregar</button>
                </form>
                <table
                    class="table table-hover"
                >
                    <thead class="table-head">
                        <td style="font-weight: bold">Tipo doc</td>
                        <td style="font-weight: bold">Serie</td>
                        <td style="font-weight: bold">Eliminar</td>
                    </thead>
                    @foreach ($series as $serie)
                    <tr>
                        <td>{{ $serie->tipo_doc }}</td>
                        <td>{{ $serie->nombre }}</td>
                        <td>
                            <form method="POST" action="/acceso/deleteserie">
                                @csrf
                                <input type="hidden" name="id" value="{{ $serie->idSerieDoc }}">
                                <button type="submit" class="btn btn-danger">Eliminar</button>
                            </form>
                        </td>
                    <tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
    {{ Form::close() }}
    <script>
        document.getElementById("imageUsers").onchange = function(e) {
            console.log("das");
            // Creamos el objeto de la clase FileReader
            let reader = new FileReader();

            // Leemos el archivo subido y se lo pasamos a nuestro fileReader
            reader.readAsDataURL(e.target.files[0]);

            // Le decimos que cuando este listo ejecute el código interno
            reader.onload = function() {
                let preview = document.getElementById('img2'),
                    image = document.createElement('img');
                console.log("mostrado")
                image.src = reader.result;

                preview.innerHTML = '';
                preview.append(image);
            };
        }
    </script>
    @push('scripts')
        <script>
            $('.phoneUsers').on('input', function() {
                this.value = this.value.replace(/[^0-9]/g, '').replace(/,/g, '.');
            });
        </script>

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
        @elseif(Session::has('error'))
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
