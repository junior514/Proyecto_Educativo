<div class="modal fade modal-slide-in-center" aria-hidden="true" role="dialog" tabindex="-1" id="modal-modulo">
  
    <div class="modal-dialog" role="document">
        {!! Form::open(['url' => 'store_modulo', 'method' => 'POST', 'autocomplete' => 'off', 'files' => 'true']) !!}
        {!! Form::token() !!}
        <div class="modal-content">
            <div class="modal-header text-white" style="background: #0059D1;">
                <h4 style="margin:0px">Nuevo Módulo</h4>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <input type="hidden" name="idMatricula" value="{{  $matricula->idMatricula }}">
                    <div class="col-12">
                        <div class="form-group">
                            <label>N° Módulo <span class="text-danger" title="Campo obligatorio">*</span> </label>
                            <div class="input-group">
                                <input type="number" class="form-control form-control-sm @if(is_null(old('idModulo')) && $errors->has('nroModulo')) is-invalid @endif" name="nroModulo"
                                    placeholder="Ingrese el N° de Módulo" autocomplete="off"
                                    value="{{ is_null(old('idModulo')) ? old('nroModulo') : '' }}"  required>
                            </div>
                       
                            @if(is_null(old('idModulo')))
                                {!! $errors->first('nroModulo', '<span class="help-block text-danger"><b>:message </b></span>') !!}
                            @endif
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label>Grupo <span class="text-danger" title="Campo obligatorio">*</span> </label>
                            <div class="input-group">
                                <select name="idGrupo" class="form-control form-control-sm @error('idGrupo') is-invalid @enderror selectpicker" data-live-search="true" required>
                                    <option value="" selected hidden>Seleccionar</option>
                                    @foreach($grupos as $g)
                                        <option value="{{$g->idGrupo}}" {{$g->idGrupo == old('idGrupo') ? 'selected' : ''}}>{{$g->nomCur }} - {{$g->nomDoc}}  ({{$g->nombreGrupo}})</option>
                                    @endforeach
                                </select>
                            </div>
                            {!! $errors->first('idGrupo', '<span class="help-block text-danger"><b>:message </b></span>') !!}
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
