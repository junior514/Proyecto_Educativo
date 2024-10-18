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
                        <b>Módulo N° {{ $nroModulo }}</b>
                    </h4>
                </div>
            </div>
            <div class="card">
                <form action="{{ route('asistencia_store') }}" method="POST" id="form">
                    @csrf
                    <input type="hidden" name="idGrupo" value="{{ $grupo->idGrupo }}">
                    <input type="hidden" name="nroModulo" value="{{ $nroModulo }}">
                    <div class="card-body ">
                        <div class="row">
                            <div class="col-md-4 col-12">
                                <div class="form-group">
                                    <label for="">Fecha</label>
                                    <input type="date" class="form-control formcontrol-sm" name="fecha" id="fecha"
                                        value="{{ $fecha }}" required>
                                    <span id="fecha-error" class="text-danger"></span>
                                </div>
                            </div>
                            <div class="col-md-8 col-12">
                                <div class="form-group">
                                    <label for="">Observación</label>
                                    <textarea name="observacion" class="form-control form-control-sm" rows="2"></textarea>
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
                                            <tr>
                                                <td>{{ $cont++ }}</td>
                                                <td>{{ $e->nomEst }}</td>
                                                <td>
                                                    <select name="estado[]" class="form-control form-control-sm"
                                                        id="">
                                                        @foreach ($estados as $item)
                                                            <option value="{{ $item }}">{{ $item }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="hidden" name="idEstudiante[]"
                                                        value="{{ $e->idEstudiante }}">
                                                    <input type="text" name="observacionD[]" placeholder="OPCIONAL"
                                                        class="form-control form-control-sm">
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                            </div>


                        </div>
                    </div>
                    <div class="card-footer text-center">
                        <a href="{{ route('asistencia_index', [$grupo->idGrupo, $nroModulo]) }}" type="button"
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
                let form = this;
                let fd = new FormData(form);
                e.preventDefault();
                let myButton = document.getElementById('enviar');
                myButton.disabled = true;
                myButton.style.opacity = 0.7;
                myButton.textContent = 'Procesando ...';

                // Realizar la solicitud AJAX
                fetch("{{ route('asistencia_store') }}", {
                        method: 'POST',
                        body: fd,
                    })
                    .then(response => response.json())
                    .then(data => {
                        limpiaValidacion();
                        if (data.success) {
                            const mensaje = "¡Satisfactorio!, Asistencia registrado " + document.getElementById('fecha').value + "."; 
                            localStorage.setItem("mensaje", mensaje);
                            window.location.href = data.redireccionar
                        } else {
                            if (Array.isArray(data.errors)) {
                                data.errors.forEach(error => {
                                    document.getElementById(error.field + '-error').innerHTML = error
                                        .message;
                                });
                            }else{
                                alert(data.message);
                            }

                            myButton.disabled = false;
                            myButton.style.opacity = 1;
                            myButton.textContent = 'Guardar';
                        }

                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            });
        </script>
    @endpush
@endsection
