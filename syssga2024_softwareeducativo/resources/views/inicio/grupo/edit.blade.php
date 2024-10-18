@extends('layouts.admin')
@section('contenido')
    {!! Form::open([
        'url' => route('grupo.update', $grupo->idGrupo),
        'method' => 'PUT',
        'autocomplete' => 'off',
    ]) !!}
    <div class="row mt-2">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>
                        <b>Editar Grupo</b>
                        <input type="hidden" name="idGrupo" id="" value="{{ $grupo->idGrupo }}">
                    </h4>
                </div>
                <div class="card-body">
                    <div class="row justify-content-center">
                        <div class="col-md-4">
                       
                                <div class="form-group">
                                    <label>Nombre del Grupo<span class="text-danger" title="Campo obligatorio">*</span>
                                    </label>
                                    <div class="input-group">
                                        <input type="text"
                                            class="form-control form-control-sm {{ $errors->has('nombreGrupo') ? 'is-invalid' : '' }}"
                                            name="nombreGrupo" placeholder=" " autocomplete="off" value="{{ old('nombreGrupo', $grupo->nombreGrupo) }}"
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
                                                <option value="{{$c->idCurso}}" {{old('idCurso', $grupo->idCurso) == $c->idCurso ? 'selected' : ''}}>{{$c->nomCur}}</option>
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
                                                <option value="{{$d->idDocente}}" {{old('idDocente', $grupo->idDocente) == $d->idDocente ? 'selected' : ''}}>{{$d->nroDoc}} - {{$d->nomDoc}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    {!! $errors->first('idDocente', '<span class="help-block text-danger"><b>:message </b></span>') !!}
                                </div>
                           
                        </div>

                    </div>
                </div>
                <div class="card-footer text-center">
                    <a href="{{ route('grupo.index') }}" type="button" class="btn btn-danger ">Volver</a>
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
