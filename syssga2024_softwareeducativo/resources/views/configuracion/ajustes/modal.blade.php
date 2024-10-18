<div class="modal fade modal-slide-in-right" aria-hidden="true" role="dialog" tabindex="-1"
    id="modal-add-{{ $empresa->idAjuste }}">

    {!! Form::model($empresa, [
        'method' => 'PATCH',
        'route' => ['ajustes.update', $empresa->idAjuste],
        'files' => 'true',
    ]) !!}
    {{ Form::token() }}
    <style>
        .imagen img {
            width: 100px;
            height: auto;
        }
    </style>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header text-white" style="background: #0059D1">
                <h4 style="margin: 0px" >
                    Ajustes</h4>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <input type="hidden" name="idAjuste" id="idAjuste" value="{{ $empresa->idAjuste }}">
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Nombres</label>
                            <div class="input-group a mb-3">
                                <input type="text" class="form-control form-control-sm" name="nombre"
                                    placeholder="Nombres"
                                    value="{{ empty(old('nombre')) ? $empresa->nombre : old('nombre') }}">
                            </div>
                            @if ($errors->has('nombre'))
                                <span class="text-danger">{{ $errors->first('nombre') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label>N° Teléfono</label>
                            <div class="input-group a mb-6">
                                <input type="text" class="form-control form-control-sm" name="telefono"
                                    placeholder="Teléfono"
                                    value="{{ empty(old('telefono')) ? $empresa->telefono : old('telefono') }}">
                            </div>
                            @if ($errors->has('telefono'))
                                <span class="text-danger">{{ $errors->first('telefono') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-8 col-12">
                        <div class="form-group">
                            <label>Correo</label>
                            <div class="input-group a mb-3">
                                <input type="email" class="form-control form-control-sm" name="correo"
                                    placeholder="Correo Electrónico"
                                    value="{{ empty(old('correo')) ? $empresa->correo : old('correo') }}">
                            </div>
                            @if ($errors->has('correo'))
                                <span class="text-danger">{{ $errors->first('correo') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label>RUC</label>
                            <div class="input-group a mb-3">
                                <input type="text" class="form-control form-control-sm" name="ruc"
                                    placeholder="ruc" value="{{ empty(old('ruc')) ? $empresa->ruc : old('ruc') }}"
                                    maxlength="13" pattern="[0-9]{11}"
                                    title="El valor ingresado debe ser un n° de 11 digitos.">
                            </div>
                            @if ($errors->has('ruc'))
                                <span class="text-danger">{{ $errors->first('ruc') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-8 col-12">
                        <div class="form-group">
                            <label>Dirección</label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control form-control-sm" name="direccion"
                                    placeholder="Dirección"
                                    value="{{ empty(old('direccion')) ? $empresa->direccion : old('direccion') }}">
                            </div>
                            @if ($errors->has('direccion'))
                                <span class="text-danger">{{ $errors->first('direccion') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="input-group ">
                            <div class="input-group ">
                                <input type="file" name="logo" id="Imagen"
                                    accept="image/png, .jpeg, .jpg, image/gif" class="form-control form-control-sm"
                                    onchange="mostrar()">
                            </div>
                            {{-- @if ($usuario->foto != '') --}}
                            <img src="{{ asset('empresa/' . $empresa->logo) }}" id="img" width="100">
                            {{-- @endif --}}
                            @if ($errors->has('logo'))
                                <span class="text-danger">{{ $errors->first('logo') }}</span>
                            @endif
                        </div>
                    </div>
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
                <div class="modal-footer">
                    <div style="margin: 0px auto 0px auto">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Confirmar</button>
                    </div>
                </div>
            </div>

        </div>
        {{ Form::Close() }}

    </div>
</div>
