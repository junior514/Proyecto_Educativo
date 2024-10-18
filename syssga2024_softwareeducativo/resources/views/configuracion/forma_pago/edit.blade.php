@extends('layouts.admin')
@section('contenido')
    {!! Form::open([
        'url' => route('forma_pago.update', $formaPago->idFormaPago),
        'method' => 'PUT',
        'autocomplete' => 'off',
    ]) !!}
    <div class="row mt-2">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>
                        <b>Editar Forma de Pago</b>
                        <input type="hidden" name="idFormaPago" id="" value="{{ $formaPago->idFormaPago }}">
                    </h4>
                </div>
                <div class="card-body">
                    <div class="row justify-content-center">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Nombre de la forma de pago<span class="text-danger" title="Campo obligatorio">*</span>
                                </label>
                                <div class="input-group">
                                    <input type="text"
                                        class="form-control form-control-sm {{ $errors->has('nombreFP') ? 'is-invalid' : '' }}"
                                        name="nombreFP" placeholder=" " autocomplete="off" value="{{ old('nombreFP', $formaPago->nombreFP) }}"
                                        required>
                                </div>
                                {!! $errors->first('nombreFP', '<span class="help-block text-danger"><b>:message </b></span>') !!}
                            </div>
                          
                        </div>

                    </div>
                </div>
                <div class="card-footer text-center">
                    <a href="{{ route('forma_pago.index') }}" type="button" class="btn btn-danger ">Volver</a>
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
    @endpush
@endsection
