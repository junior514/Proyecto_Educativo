@extends('layouts.admin')
@section('contenido')
    {!! Form::open([
        'url' => route('tipo_descuento.update', $tipoDescuento->idTipoDescuento),
        'method' => 'PUT',
        'autocomplete' => 'off',
    ]) !!}
    <div class="row mt-2">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4><b>Editar Tipo de Descuento</b></h4>
                    <input type="hidden" name="idTipoDescuento" value="{{ $tipoDescuento->idTipoDescuento }}">
                </div>
                <div class="card-body">
                    <div class="row justify-content-center">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Nombre del Tipo de Descuento<span class="text-danger" title="Campo obligatorio">*</span></label>
                                <div class="input-group">
                                    <input type="text"
                                        class="form-control form-control-sm {{ $errors->has('nombreTP') ? 'is-invalid' : '' }}"
                                        name="nombreTP" placeholder=" " autocomplete="off" value="{{ old('nombreTP', $tipoDescuento->nombreTP) }}"
                                        required>
                                </div>
                                {!! $errors->first('nombreTP', '<span class="help-block text-danger"><b>:message </b></span>') !!}
                            </div>
                            <div class="form-group">
                                <label>Valor Porcentaje<span class="text-danger" title="Campo obligatorio">*</span></label>
                                <div class="input-group">
                                    <input type="text"
                                        class="form-control form-control-sm {{ $errors->has('valorPorcentaje') ? 'is-invalid' : '' }}"
                                        name="valorPorcentaje" placeholder=" " autocomplete="off" value="{{ old('valorPorcentaje', $tipoDescuento->valorPorcentaje) }}"
                                        required>
                                </div>
                                {!! $errors->first('valorPorcentaje', '<span class="help-block text-danger"><b>:message </b></span>') !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-center">
                    <a href="{{ route('tipo_descuento.index') }}" type="button" class="btn btn-danger">Volver</a>
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
