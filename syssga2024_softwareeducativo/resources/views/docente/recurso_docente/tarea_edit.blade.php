<?php use App\Http\Controllers\GrupoDocenteController as GDC; ?>

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
            <form action="{{ route('recurso_docente.update', $recurso->idRecurso) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="card">
                    <div class="card-header">
                        <h5>{{ $leccion->nombreLeccion }}</h5>
                    </div>
                    <div class="card-body">
                        @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="titulo">Título <span title="Campo Obligatorio"
                                            class="text-danger">*</span></label>
                                    <input type="text" name="titulo" class="form-control" id="titulo"
                                        placeholder="Ingrese el título de la tarea"
                                        value="{{ old('titulo', $recurso->titulo) }}" required>
                                    @error('titulo')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="descripcion">Descripción</label>
                                    <textarea name="descripcion" id="descripcion" rows="2"
                                        class="form-control @error('descripcion') is-invalid @enderror"
                                        placeholder="Ingrese la descripción de la tarea (Opcional)">{{ old('descripcion', $recurso->descripcion) }}</textarea>
                                    @error('descripcion')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3 col-6">
                                <div class="form-group">
                                    <label for="fechaInicio">Mostrar desde <span title="Campo Obligatorio"
                                            class="text-danger">*</span></label>
                                    <input type="date" name="fechaInicio"
                                        value="{{ old('fechaInicio', $recurso->fechaInicio) }}" class="form-control"
                                        id="fechaInicio" required>
                                    @error('fechaInicio')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3 col-6">
                                <div class="form-group">
                                    <label for="horaInicio">Hora Inicio <span title="Campo Obligatorio"
                                            class="text-danger">*</span></label>
                                    <input type="time" name="horaInicio"
                                        value="{{ old('horaInicio', date('H:i', strtotime($recurso->horaInicio))) }}"
                                        class="form-control" id="horaInicio" required>
                                    @error('horaInicio')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3 col-6">
                                <div class="form-group">
                                    <label for="fechaFin">Mostrar hasta <span title="Campo Obligatorio"
                                            class="text-danger">*</span></label>
                                    <input type="date" name="fechaFin" value="{{ old('fechaFin', $recurso->fechaFin) }}"
                                        class="form-control" id="fechaFin" required>
                                    @error('fechaFin')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3 col-6">
                                <div class="form-group">
                                    <label for="horaFin">Hora Fin <span title="Campo Obligatorio"
                                            class="text-danger">*</span></label>
                                    <input type="time" name="horaFin"
                                        value="{{ old('horaFin', date('H:i', strtotime($recurso->horaFin))) }}"
                                        class="form-control" id="horaFin" required>
                                    @error('horaFin')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3 col-12">
                                <div class="form-group">
                                    <label for="archivo">Archivo</label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" class="form-control" name="archivo" id="archivo">
                                        </div>
                                        @php
                                            $filePath = public_path('tareas/' . $recurso->archivo);
                                            $fileExists = file_exists($filePath) && !empty($recurso->archivo);
                                            $extension = pathinfo($recurso->archivo, PATHINFO_EXTENSION); // Obtener la extensión del archivo
                                        @endphp
                                        
                                    </div>
                                    @if ($fileExists)
                                            <a href="{{ asset('tareas/' . $recurso->archivo) }}" class="{{ $extension == 'pdf' ? 'text-danger' : ($extension == 'doc' ? 'text-primary' : 'text-primary') }}" target="_blank">
                                                <i class="fa {{ $extension == 'pdf' ? 'fa-file-pdf' : ($extension == 'doc' ? 'fa-file-word' : 'fa-file') }}"></i>
                                                    {{ $recurso->archivo }}
                                            </a>
                                        @endif
                                    @error('archivo')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                        </div>

                    </div>
                    <div class="card-footer text-center">
                        <a href="{{ route('recurso_docente.index') . "?grupo=$grupo->idGrupo&nroModulo=$leccion->nroModulo" }}"
                            class="btn btn-danger" data-dismiss="modal">Cancelar</a>
                        <button type="submit" class="btn btn-primary">Modificar</button>
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
