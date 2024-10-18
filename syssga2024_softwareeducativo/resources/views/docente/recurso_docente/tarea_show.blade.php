<?php use App\Http\Controllers\GrupoDocenteController as GDC; ?>
<?php use App\Http\Controllers\RecursoController as RC; ?>

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
            <div class="card">
                <div class="modal-body">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="home-tab-20" data-toggle="tab" href="#home-20" role="tab"
                                aria-controls="home" aria-selected="true">Entregados ({{ count($entregados) }})</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="profile-tab-20" data-toggle="tab" href="#profile-20" role="tab"
                                aria-controls="profile" aria-selected="false">Evaluados ({{ count($evaluados) }})</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="postulantes-tab-20" data-toggle="tab" href="#postulantes-20"
                                role="tab" aria-controls="postulantes" aria-selected="false">Pendientes</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade active show" id="home-20" role="tabpanel" aria-labelledby="home-tab-20">
                            <div class="row">
                                <div class="col-12">
                                    @php($cont = 1)
                                    @foreach ($entregados as $en)
                                        <?php
                                        $filePath = public_path('entrega_tareas/' . $en->archivoEntega);
                                        $fileExists = file_exists($filePath) && !empty($en->archivoEntega);
                                        $extension = pathinfo($en->archivoEntega, PATHINFO_EXTENSION); // Obtener la extensión del archivo
                                        ?>
                                        <div class="card">
                                            <div class="card-body">
                                                <form action="{{ route('revisartarea_store', $en->idEntregaTarea) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="post">
                                                        <div class="user-block">
                                                            @php($nombre_fichero = public_path('estudiante/' . $en->fotoEst))
                                                            @if (file_exists($nombre_fichero) && !empty($en->fotoEst))
                                                                <img class="img-circle img-bordered-sm"
                                                                    src="{{ asset('estudiante/' . $en->fotoEst) }}"
                                                                    id="img" width="100" height="100">
                                                            @else
                                                                <img class="img-circle img-bordered-sm"
                                                                    src="{{ asset('estudiante/auxiliar' . ($en->generoEst == 'MASCULINO' ? '_hombre' : '_mujer') . '.png') }}"
                                                                    id="img" width="100" height="100">
                                                            @endif
                                                            <span class="username">
                                                                <a href="#">{{ $en->nomEst }}</a>

                                                            </span>
                                                            <span class="description">{{ $en->fechaEntrega }}</span>
                                                        </div>
                                                        <p>
                                                            {{ $en->comentarioEstudiante }}
                                                        </p>
                                                        <p>
                                                            @if ($fileExists)
                                                                <a href="{{ asset('entrega_tareas/' . $en->archivoEntega) }}"
                                                                    class="{{ $extension == 'pdf' ? 'text-danger' : ($extension == 'doc' ? 'text-primary' : 'text-primary') }}"
                                                                    target="_blank">
                                                                    <i
                                                                        class="fa {{ $extension == 'pdf' ? 'fa-file-pdf' : ($extension == 'doc' ? 'fa-file-word' : 'fa-file') }}"></i>
                                                                    {{ $en->archivoEntega }}
                                                                </a>
                                                            @endif
                                                        </p>
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <div class="form-group">
                                                                    <input class="form-control form-control-sm"
                                                                        type="text" name="comentarioDocente"
                                                                        placeholder="Ingrese un comentario de la calificación (opcional).">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3 col-12">
                                                                <div class="form-group">
                                                                    <input type="number" name="nota" min="0"
                                                                        max="20"
                                                                        class="form-control form-control-sm"
                                                                        placeholder="Ingrese su nota" required>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-9 col-12">
                                                                <button type="submit"
                                                                    class="btn btn-primary btn-sm">Calificar</button>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                            </div>
                        </div>
                        <div class="tab-pane fade" id="profile-20" role="tabpanel" aria-labelledby="profile-tab-20">
                            <div class="row">
                                <div class="col-12">
                                    @php($cont = 1)
                                    @foreach ($evaluados as $ev)
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="post">
                                                    <div class="user-block">
                                                        @php($nombre_fichero = public_path('estudiante/' . $ev->fotoEst))
                                                        @if (file_exists($nombre_fichero) && !empty($ev->fotoEst))
                                                            <img class="img-circle img-bordered-sm"
                                                                src="{{ asset('estudiante/' . $ev->fotoEst) }}"
                                                                id="img" width="100" height="100">
                                                        @else
                                                            <img class="img-circle img-bordered-sm"
                                                                src="{{ asset('estudiante/auxiliar' . ($ev->generoEst == 'MASCULINO' ? '_hombre' : '_mujer') . '.png') }}"
                                                                id="img" width="100" height="100">
                                                        @endif

                                                        <span class="username">
                                                            <a href="#">{{ $ev->nomEst }}</a>

                                                        </span>
                                                        <span class="description">{{ $ev->fechaEntrega }}</span>
                                                    </div>
                                                    <p>
                                                        {{ $ev->comentarioEstudiante }}
                                                    </p>
                                                    <p>
                                                        @if ($fileExists)
                                                            <a href="{{ asset('entrega_tareas/' . $ev->archivoEntega) }}"
                                                                class="{{ $extension == 'pdf' ? 'text-danger' : ($extension == 'doc' ? 'text-primary' : 'text-primary') }}"
                                                                target="_blank">
                                                                <i
                                                                    class="fa {{ $extension == 'pdf' ? 'fa-file-pdf' : ($extension == 'doc' ? 'fa-file-word' : 'fa-file') }}"></i>
                                                                {{ $en->archivoEntega }}
                                                            </a>
                                                        @endif
                                                    </p>


                                                </div>
                                            </div>
                                            <div class="card-footer">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            {{ $ev->comentarioDocente }}
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3 col-12">
                                                        <div class="form-group">
                                                            <label for="">Nota: </label> {{ $ev->nota }}
                                                        </div>
                                                    </div>
                                                    <div class="col-md-9 col-12">
                                                        <div class="float-right">
                                                            <div style="display: inline-block; margin-right: 10px;">
                                                                <a href="#" href=""
                                                                    data-target="#modal-revisionedit-{{ $ev->idEntregaTarea }}"
                                                                    data-toggle="modal" class="btn btn-default btn-sm">
                                                                    <i class="far fa-edit text-info"></i> Editar
                                                                </a>
                                                            </div>
                                                            <div style="display: inline-block;">
                                                                <form
                                                                    action="{{ route('revisartarea_destroy', $ev->idEntregaTarea) }}"
                                                                    style="margin-bottom: 0px" method="POST">
                                                                    {!! csrf_field() !!}
                                                                    {!! method_field('DELETE') !!}
                                                                    <button class="btn btn-default borrar2 btn-sm"
                                                                        title="Eliminar Revisión"
                                                                        data-nombre="Revisión N° {{ $ev->idEntregaTarea }}">
                                                                        <i class="fas fa-trash text-danger"
                                                                            aria-hidden="true"></i> Eliminar
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @include('docente.recurso_docente.revision_edit')
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="postulantes-20" role="tabpanel"
                            aria-labelledby="postulantes-tab-20">
                            <div class="row table-responsive">
                                <div class="col-12">
                                    <table class="table table-sm" id="tabla_postulantes_20">
                                        <thead>
                                            <tr>
                                                <th>N°</th>
                                                <th>Estudiante</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php($cont = 1)
                                            @foreach ($estudiantes as $e)
                                                @php($verif = RC::verificarEntregaEst($recurso->idRecurso, $e->idEstudiante))
                                                @if (!$verif)
                                                    <tr>
                                                        <td>{{ $cont++ }}</td>
                                                        <td>{{ $e->nomEst }}</td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="card">
                <div class="card-footer">
                    <div class="col-12 text-center">
                        <a href="{{ route('recurso_docente.index') . "?grupo=$grupo->idGrupo&nroModulo=$leccion->nroModulo" }}"
                            class="btn btn-danger" data-dismiss="modal">Volver</a>
                    </div>
                </div>

            </div>

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
