<div class="modal fade modal-slide-in-center" aria-hidden="true" role="dialog" tabindex="-1" id="modal-modulo-edit">
  
    <div class="modal-dialog" role="document">
        {!! Form::open(['url' => 'update_modulo', 'method' => 'POST', 'autocomplete' => 'off', 'files' => 'true']) !!}
        {!! Form::token() !!}
        <div class="modal-content">
            <div class="modal-header text-white" style="background: #0059D1;">
                <h4 style="margin:0px">Editar Módulo</h4>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <input type="hidden" name="idModulo" id="idModulo_e" value="{{old('idModulo')}}">
                    <div class="col-12">
                        <div class="form-group">
                            <label>N° Módulo <span class="text-danger" title="Campo obligatorio">*</span> </label>
                            <div class="input-group">
                                <input type="number" class="form-control form-control-sm @if(!is_null(old('idModulo')) && $errors->has('nroModulo')) is-invalid @endif" name="nroModulo" id="nroModulo_e" 
                                    placeholder="Ingrese el N° de Módulo" autocomplete="off"
                                    value="{{ !is_null(old('idModulo')) ? old('nroModulo') : '' }}"  readonly>
                            </div>
                            @if(!is_null(old('idModulo')))
                                {!! $errors->first('nroModulo', '<span class="help-block text-danger"><b>:message </b></span>') !!}
                            @endif
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label>Grupo <span class="text-danger" title="Campo obligatorio">*</span> </label>
                            <div class="input-group">
                                <select name="idGrupo" id="idGrupo_e" class="form-control form-control-sm @if(!is_null(old('idModulo')) && $errors->has('idGrupo')) is-invalid @endif selectpicker" data-live-search="true" required>
                                    <option value="" selected hidden>Seleccionar</option>
                                    @foreach($grupos as $g)
                                        <option value="{{$g->idGrupo}}" {{$g->idGrupo == old('idGrupo') && !is_null(old('idModulo'))  ? 'selected' : ''}}>{{$g->nomDoc}} - {{$g->nombreGrupo}}</option>
                                    @endforeach
                                </select>
                            </div>
                            @if(!is_null(old('idModulo')))
                                {!! $errors->first('idGrupo', '<span class="help-block text-danger"><b>:message </b></span>') !!}
                            @endif
                        </div>
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
        {{ Form::Close() }}
    </div>
</div>
