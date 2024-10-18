<div class="modal fade modal-slide-in-center" aria-hidden="true" role="dialog" tabindex="-1" id="modal-matricula">
    <form method="POST" action="{{route('matricula')}}" id="formMatricula">
        @csrf
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header text-white" style="background: #0059D1">
                    <h4 style="margin:0px">Nueva Matrícula</h4>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 col-12">
                            <input type="hidden" name="idEstudiante" value="{{ $estudiante->idEstudiante }}">
                            <div class="form-group">
                                <label>Curso<span class="text-danger" title="Campo obligatorio">*</span>
                                </label>
                                <div class="input-group">
                                    <select name="idCurso" id="selectCursos" class="form-control form-control-sm {{ $errors->has('idCurso') ? 'is-invalid' : '' }} selectpicker" data-live-search="true" required>
                                        <option value="" selected hidden>Seleccionar</option>
                                        @foreach($cursos as $c)
                                            <option value="{{$c->idCurso}}" {{$c->idCurso == old('idCurso') ? 'selected' : ''}}>{{$c->nomCur}} </option>
                                        @endforeach
                                    </select>
                                </div>
                                {!! $errors->first('idCurso', '<span class="help-block text-danger"><b>:message </b></span>') !!}
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label>Grupo<span class="text-danger" title="Campo obligatorio">*</span>
                                </label>
                                
                                    <div id="selectGruposContainer">

                                    </div>
                               
                                {!! $errors->first('idCurso', '<span class="help-block text-danger"><b>:message </b></span>') !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div style="margin: 0px auto 0px auto">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary" id="btn-matricula">Guardar</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

