<?php use App\Http\Controllers\GrupoDocenteController as GDC; ?>
<?php use App\Http\Controllers\RecursoEstudianteController as REC; ?>
@extends('layouts.docente')
@section('contenido')

    <div class="row mt-2">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">

                    <h4>
                        <b>{{ $grupo->nomCur }} - {{ $grupo->nomDoc }} ({{ $grupo->nombreGrupo }})</b>
                    </h4>
                    <h4>
                        <b>Módulo N° {{ $leccion->nroModulo }}</b>
                    </h4>

                </div>

            </div>

            <div class="card">
                <div class="card-header">
                    <div class="float-left" style="padding: 4px;">
                        <i class="fa fa-tasks icono fa-2x p-1 text-white" style="background-color: #d9534f; " title=""
                            data-toggle="tooltip" data-container="body" data-original-title="Tarea"></i>
                    </div>
                    <div style="padding-left: 52px;">
                        <small style="color:#d9534f">Tarea:</small>
                        <h3 style="margin: 0px;">
                            <span>{{ $recurso->titulo }}</span>
                        </h3>
                    </div>

                </div>
                <div class="card-body">

                    <div class="row">

                        <div class="col-12">
                            <div class="form-group">
                                <label for="descripcion">Descripción</label><br>
                                {{ $recurso->descripcion }}
                            </div>
                        </div>


                    </div>

                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-md-3 col-6">
                            <div class="form-group">
                                <label for="fechaInicio">Mostrar desde </label><br>
                                {{ date('d/m/Y', strtotime($recurso->fechaInicio)) }}
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="form-group">
                                <label for="horaInicio">Hora Inicio </label><br>
                                {{ date('H:i', strtotime($recurso->horaInicio)) }}

                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="form-group">
                                <label for="fechaFin">Mostrar hasta </label><br>
                                {{ date('d/m/Y', strtotime($recurso->fechaFin)) }}

                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="form-group">
                                <label for="horaFin">Hora Fin </label><br>
                                {{ old('horaFin', date('H:i', strtotime($recurso->horaFin))) }}
                            </div>
                        </div>
                        @php
                            $filePath = public_path('tareas/' . $recurso->archivo);
                            $fileExists = file_exists($filePath) && !empty($recurso->archivo);
                            $extension = pathinfo($recurso->archivo, PATHINFO_EXTENSION); // Obtener la extensión del archivo
                        @endphp
                        @if ($fileExists)
                            <div class="col-md-3 col-12">
                                <div class="form-group">
                                    <label for="archivo">Archivo</label><br>
                                    <a href="{{ asset('tareas/' . $recurso->archivo) }}"
                                        class="{{ $extension == 'pdf' ? 'text-danger' : ($extension == 'doc' ? 'text-primary' : 'text-primary') }}"
                                        target="_blank">
                                        <i
                                            class="fa {{ $extension == 'pdf' ? 'fa-file-pdf' : ($extension == 'doc' ? 'fa-file-word' : 'fa-file') }}"></i>
                                        {{ $recurso->archivo }}
                                    </a>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            @php
                $isHora = REC::isHoraActualEnRango($recurso->fechaInicio, $recurso->horaInicio, $recurso->fechaFin, $recurso->horaFin);
            @endphp

            <form action="{{ route('recurso_estudiante.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="idRecurso" value="{{ $recurso->idRecurso }}">
                <div class="card">
                    <div class="card-header">
                        Cargar Tarea
                    </div>
                    <div class="card-body">
                        @if (!$isHora)
                            <div class="col-12 text-danger text-center">
                                {{ 'El formulario de entrega de tarea no está disponible, revise las fechas de disponibilidad.' }}
                            </div>
                        @endif
                        <div class="row">
                            <div class="col-md-4 col-12">
                                <div class="form-group">
                                    <label for="">Subir Archivo</label>
                                    <input type="file" accept=".pdf, .doc, .docx" class="form-control"
                                        name="archivoEntega" {{ $isHora ? '' : 'disabled' }} required>
                                </div>
                                @if ($errors->has('archivoEntega'))
                                    <span class="text-danger">{{ $errors->first('archivoEntega') }}</span>
                                @endif
                            </div>
                            <div class="col-md-8 col-12">
                                <div class="form-group">
                                    <label for="">Nota/Comentario</label>
                                    <textarea name="comentarioEstudiante" rows="2" class="form-control" {{ $isHora ? '' : 'disabled' }}>{{ old('comentarioEstudiante') }} </textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-footer">
                        <div class="col-12 text-center">
                            <a href="{{ route('recurso_estudiante.index') . "?grupo=$grupo->idGrupo&nroModulo=$leccion->nroModulo" }}"
                                class="btn btn-danger" data-dismiss="modal">Volver</a>
                            <button type="submit" class="btn btn-primary" {{ $isHora ? '' : 'disabled' }}>Enviar</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>



    @push('scripts')
        <script>
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
        </script>
        @if (Session::has('success'))
            <script type="text/javascript">
                Toast.fire({
                    icon: 'success',
                    title: '{{ Session::get('success') }}',
                    customClass: 'swal-pop',
                })
            </script>
        @elseif (Session::has('error'))
            <script type="text/javascript">
                Toast.fire({
                    icon: 'error',
                    title: '{{ Session::get('error') }}',
                    customClass: 'swal-pop',
                })
            </script>
        @endif
    @endpush
@endsection
