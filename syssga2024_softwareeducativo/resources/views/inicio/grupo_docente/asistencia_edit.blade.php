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
                        <b>Módulo N° {{ $asistencia->nroModulo }}</b>
                    </h4>
                </div>
            </div>
            <div class="card">
                <form action="{{ route('asistencia_update', $asistencia->idAsistencia) }}" method="POST" id="form">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="idAsistencia" value="{{ $asistencia->idAsistencia }}">

                    <div class="card-body ">
                        <div class="row">
                            <div class="col-md-4 col-12">
                                <div class="form-group">
                                    <label for="">Fecha</label>
                                    <input type="date" class="form-control formcontrol-sm" name="fecha" id="fecha"
                                        value="{{ $asistencia->fecha }}" required>
                                    <span id="fecha-error" class="text-danger"></span>
                                </div>
                            </div>
                            <div class="col-md-8 col-12">
                                <div class="form-group">
                                    <label for="">Observación</label>
                                    <textarea name="observacion" class="form-control form-control-sm" rows="2">{{ $asistencia->observacion }}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-center">

                            <div class="col-12 table-responsive">
                                <table id="lista" class="table table-sm table-hover text-nowrap">
                                    <thead class="text-white" style="background: #0059D1">
                                        <tr>
                                            <th>#</th>
                                            <th>Estudiante</th>
                                            <th>Estado </th>
                                            <th>Observación</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php($cont = 1)
                                        @foreach ($estudiantes as $e)
                                            @php($a = GDC::obtenerAsistencia($e->idEstudiante, $asistencia->idAsistencia))
                                            @if ($a == '')
                                                <tr>
                                                    <td>{{ $cont++ }}</td>
                                                    <td>
                                                        <input type="hidden" name="idEstudiante[]"
                                                            value="{{ $e->idEstudiante }}">
                                                        <input type="hidden" name="idDetalleAsistencia[]" value="-1">
                                                        {{ $e->nomEst }}
                                                    </td>
                                                    <td>
                                                        <select name="estado[]" class="form-control form-control-sm"
                                                            required>
                                                            <option value="" selected hidden>SELECCIONAR</option>
                                                            @foreach ($estados as $item)
                                                                <option value="{{ $item }}">{{ $item }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </td>

                                                    <td>
                                                        <input type="text" name="observacion[]" placeholder="OPCIONAL"
                                                            class="form-control form-control-sm">
                                                    </td>
                                                </tr>
                                            @else
                                                <tr>
                                                    <td>{{ $cont++ }}</td>
                                                    <td>
                                                        <input type="hidden" name="idEstudiante[]"
                                                            value="{{ $e->idEstudiante }}">
                                                        <input type="hidden" name="idDetalleAsistencia[]"
                                                            value="{{ $a->idDetalleAsistencia }}">
                                                        {{ $e->nomEst }}
                                                    </td>
                                                    <td>
                                                        <select name="estado[]" class="form-control form-control-sm"
                                                            id="">
                                                            @foreach ($estados as $item)
                                                                <option value="{{ $item }}"
                                                                    {{ $a->estado == $item ? 'selected' : '' }}>
                                                                    {{ $item }}</option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <input type="text" name="observacion[]" placeholder="OPCIONAL"
                                                            class="form-control form-control-sm"
                                                            value="{{ $a->observacion }}">
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>

                            </div>


                        </div>
                    </div>
                    <div class="card-footer text-center">
                        <a href="{{ route('asistencia_index', [$grupo->idGrupo, $asistencia->nroModulo]) }}" type="button"
                            class="btn btn-danger ">Volver</a>
                        <button type="submit" class="btn btn-primary" id="enviar">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


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
        <script>
            function desglose_nota(titulo, nota) {
                if (nota !== "") {
                    let jsonObject = JSON.parse(nota);
                    document.getElementById('subNota1').value = jsonObject.subNota1;
                    document.getElementById('subNota2').value = jsonObject.subNota2;
                    document.getElementById('subNota3').value = jsonObject.subNota3;
                } else {
                    document.getElementById('subNota1').value = "";
                    document.getElementById('subNota2').value = "";
                    document.getElementById('subNota3').value = "";
                }

                document.getElementById('nota').value = titulo;
                document.getElementById('lblnota').innerHTML = titulo;
                $('#modal-desglose').modal("show");
            }

            // Para el formulario de creación
            function limpiaValidacion() {
                document.getElementById('fecha-error').innerHTML = "";

            }


            document.querySelector('#form').addEventListener('submit', function(e) {
                e.preventDefault();
                let form = this;
                let data = {};

                // Extraer datos del formulario y construir el objeto JSON
                data.idAsistencia = form.querySelector('input[name="idAsistencia"]').value;
                data.fecha = form.querySelector('input[name="fecha"]').value;
                data.observacion = form.querySelector('textarea[name="observacion"]').value;

                // Datos de los estudiantes
                data.estudiantes = [];
                let estudiantesRows = form.querySelectorAll('#lista tbody tr');
                estudiantesRows.forEach(function(row) {
                    let estudiante = {};
                    estudiante.idEstudiante = row.querySelector('input[name="idEstudiante[]"]').value;
                    estudiante.idDetalleAsistencia = row.querySelector('input[name="idDetalleAsistencia[]"]').value;
                    estudiante.estado = row.querySelector('select[name="estado[]"]').value;
                    estudiante.observacion = row.querySelector('input[name="observacion[]"]').value;
                    data.estudiantes.push(estudiante);
                });

                let myButton = document.getElementById('enviar');
                myButton.disabled = true;
                myButton.style.opacity = 0.7;
                myButton.textContent = 'Procesando ...';

                // Realizar la solicitud AJAX
                fetch("{{ route('asistencia_update', $asistencia->idAsistencia) }}", {
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify(data),
                    })
                    .then(response => response.json())
                    .then(data => {
                        limpiaValidacion();
                        if (data.success) {
                            const mensaje = "¡Satisfactorio!, Asistencia actualizada para el registro con fecha " + document.getElementById('fecha').value + ".";
                            localStorage.setItem("mensaje", mensaje);
                            window.location.href = data.redireccionar
                        } else {
                            if (Array.isArray(data.errors)) {
                                data.errors.forEach(error => {
                                    document.getElementById(error.field + '-error').innerHTML = error
                                        .message;
                                });
                            } else {
                                alert(data.message);
                            }

                            myButton.disabled = false;
                            myButton.style.opacity = 1;
                            myButton.textContent = 'Guardar';
                        }

                    })
                    .catch(error => {
                        // console.error('Error:' + error);
                        console.log(error); 
                    });
            });
        </script>
    @endpush
@endsection
