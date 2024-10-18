{{-- <style>
    .imagen img {
        background: #f8eded;
        width: 100px;
        height: auto;
    }
</style> --}}
<div class="modal fade modal-slide-in-center" aria-hidden="true" role="dialog" tabindex="-1" id="modal-add">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header text-white" style="background: #0059D1;">
                <h4 style="margin: 0px">Nuevo Usuario</h4>
                <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            {!! Form::open(['url' => 'acceso/usuario', 'method' => 'POST', 'autocomplete' => 'off', 'files' => 'true']) !!}
            {!! Form::token() !!}
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-5 col-12">
                        <div class="form-group">
                            <label>N° Doc</label>
                            <div class="input-group a mb-6">
                                <input type="text" class="form-control form-control-sm {{ $errors->has('nroDoc') ? 'is-invalid' : '' }}" name="nroDoc"
                                    placeholder=" " value="{{ old('nroDoc') }}">
                            </div>
                            @if ($errors->has('nroDoc'))
                                <span class="text-danger">{{ $errors->first('nroDoc') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-7 col-12">
                        <div class="form-group">
                            <label>Nombres <span class="text-danger" title="Campo obligatorio">*</span> </label>
                            <div class="input-group a mb-3">
                                <input type="text" class="form-control form-control-sm {{ $errors->has('name') ? 'is-invalid' : '' }}" name="name"
                                    placeholder=" " value="{{ old('name') }}" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5 col-12">
                        <div class="form-group">
                            <label>Celular</label>
                            <div class="input-group a mb-6">
                                <input type="text" class="form-control form-control-sm {{ $errors->has('telUse') ? 'is-invalid' : '' }}" name="telUse"
                                    placeholder=" " value="{{ old('telUse') }}">
                            </div>
                            @if ($errors->has('telUse'))
                                <span class="text-danger">{{ $errors->first('telUse') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-7 col-12">
                        <div class="form-group">
                            <label>Correo <span class="text-danger" title="Campo obligatorio">*</span> </label>
                            <div class="input-group a mb-3">
                                <input type="email" class="form-control form-control-sm {{ $errors->has('email') ? 'is-invalid' : '' }}" name="email"
                                    placeholder=" " value="{{ old('email') }}" required>
                            </div>
                            @if ($errors->has('email'))
                                <span class="text-danger">{{ $errors->first('email') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="form-group">
                            <label>Contraseña <span class="text-danger" title="Campo obligatorio">*</span></label>
                            <div class="input-group a mb-6">
                                <input type="password" id="password"
                                    class="form-control form-control-sm {{ $errors->has('password') ? 'is-invalid' : '' }}"
                                    name="password" placeholder=" " required>
                            </div>
                            @if ($errors->has('password'))
                                <span class="text-danger">{{ $errors->first('password') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="form-group">
                            <label>Repetir Contraseña<span class="text-danger" title="Campo obligatorio">*</span></label>
                            <div class="input-group a mb-6">
                                <input id="password-confirm" type="password"
                                    class="form-control  form-control-sm {{ $errors->has('password_confirmation') ? 'is-invalid' : '' }}"
                                    name="password_confirmation" autocomplete="new-password" required>
                            </div>
                            @if ($errors->has('password_confirmation'))
                                <span class="text-danger">{{ $errors->first('password_confirmation') }}</span>
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
            {{ Form::Close() }}
        </div>
    </div>
</div>
@push('scripts')
    <script>
        $('.phoneUsers').on('input', function() {
            this.value = this.value.replace(/[^0-9]/g, '').replace(/,/g, '.');
        });
    </script>
    <script>
        function mostrarContrasena() {
            var tipo = document.getElementById("password");
            if (tipo.type == "password") {
                tipo.type = "text";
            } else {
                tipo.type = "password";
            }
        }
    </script>
@endpush
