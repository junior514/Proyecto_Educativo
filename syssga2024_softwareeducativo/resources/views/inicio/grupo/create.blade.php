<div class="modal fade modal-slide-in-center" aria-hidden="true" role="dialog" tabindex="-1" id="modal-add">
    <form method="POST" action="{{ route('grupo.store') }}">
        @csrf
    <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header text-white" style="background: #0059D1">
                   <h4 style="margin:0px">Nuevo Grupo</h4>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nombre del Grupo<span class="text-danger" title="Campo obligatorio">*</span>
                        </label>
                        <div class="input-group">
                            <input type="text"
                                class="form-control form-control-sm {{ $errors->has('nombreGrupo') ? 'is-invalid' : '' }}"
                                name="nombreGrupo" placeholder=" " autocomplete="off" value="{{ old('nombreGrupo') }}"
                                required>
                        </div>
                        {!! $errors->first('nombreGrupo', '<span class="help-block text-danger"><b>:message </b></span>') !!}
                    </div>
                    <div class="form-group">
                        <label>Curso<span class="text-danger" title="Campo obligatorio">*</span>
                        </label>
                        <div class="input-group">
                            <select class="form-control form-control-sm selectpicker {{ $errors->has('idCurso') ? 'is-invalid' : '' }}" name="idCurso" data-live-search="true" required>
                                <option value="" selected hidden>Seleccionar</option>
                                @foreach($cursos as $c)
                                    <option value="{{$c->idCurso}}" {{old('idCurso') == $c->idCurso ? 'selected' : ''}}>{{$c->nomCur}}</option>
                                @endforeach
                            </select>
                        </div>
                        {!! $errors->first('idCurso', '<span class="help-block text-danger"><b>:message </b></span>') !!}
                    </div>
                    <div class="form-group">
                        <label>Docente<span class="text-danger" title="Campo obligatorio">*</span>
                        </label>
                        <div class="input-group">
                            <select class="form-control form-control-sm selectpicker {{ $errors->has('idDocente') ? 'is-invalid' : '' }}" name="idDocente" data-live-search="true" required>
                                <option value="" selected hidden>Seleccionar</option>
                                @foreach($docentes as $d)
                                    <option value="{{$d->idDocente}}" {{old('idDocente') == $d->idDocente ? 'selected' : ''}}>{{$d->nroDoc}} - {{$d->nomDoc}}</option>
                                @endforeach
                            </select>
                        </div>
                        {!! $errors->first('idDocente', '<span class="help-block text-danger"><b>:message </b></span>') !!}
                    </div>
                   
                </div>
                <div class="modal-footer">
                    <div style="margin: 0px auto 0px auto">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </div>
            </div>
        
    </div>
    </form>
</div>

