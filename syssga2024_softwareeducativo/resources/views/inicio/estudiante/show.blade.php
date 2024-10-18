<?php use App\Http\Controllers\EstudianteController as EC; ?>
@extends('layouts.admin')
@section('contenido')
    <div class="row mt-2">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>
                        <b>Pefíl Estudiante</b>
                        <input type="hidden" name="idEstudiante" id="" value="{{ $estudiante->idEstudiante }}">
                    </h4>
                    <div class="row justify-content-end">
                        <div class="col-md-8 col-12 text-right">
                            <h4>{{ $estudiante->nomEst }}</h4>
                            <h5>DNI: {{ $estudiante->nroDoc }}</h5>
                        </div>
                        <div class="col-md-2">
                            @php($nombre_fichero = public_path('estudiante/' . $estudiante->fotoEst))
                            @if (file_exists($nombre_fichero) && !empty($estudiante->fotoEst))
                                <img src="{{ asset('estudiante/' . $estudiante->fotoEst) }}" id="img" width="100"
                                    height="100">
                            @else
                                <img src="{{ asset('estudiante/auxiliar_' . ($estudiante->generoEst == 'MASCULINO' ? 'hombre' : 'mujer') . '.png') }}"
                                    id="img" width="100" height="100">
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row justify-content-center">
                        <div class="col-12">
                            <a class="btn btn-success btn-sm" href="" data-target="#modal-matricula"
                                data-toggle="modal">
                                <i class="fas fa-plus-circle" style="color: #cef5e1; margin-right: 10px"></i>Matrícula
                            </a>
                        </div>
                        <div class="col-md-8">
                            <table class="table table-sm">
                                @foreach ($matriculas as $m)
                                    <tr>
                                        <td colspan="4"><span style="font-size: 1.80em">{{ $m->nomCur }}</span>
                                            <br>Fecha Matrícula: {{ date('d/m/Y', strtotime($m->fecMat)) }}
                                        </td>
                                        <td colspan="2">
                                            <span class="badge badge-primary">MATRICULADO</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <a href="{{ route('index_modulo', $m->idMatricula) }}">Información académica</a>
                                        </td>
                                        <td colspan="2">
                                            <a href="{{ route('pagos_curso', $m->idMatricula) }}">Información Financiera</a>
                                        </td>
                                        <td colspan="2">
                                            @if (EC::valEliminarMatricula($m->idMatricula))
                                                <form method="POST"
                                                    action="{{ route('eliminar_matricula', $m->idMatricula) }}">
                                                    {!! csrf_field() !!}
                                                    {!! method_field('DELETE') !!}
                                                    <button class="btn btn-default borrar2 btn-sm"
                                                        title="Eliminar {{ $m->nomCur }}"
                                                        data-nombre="{{ $m->nomCur }}"><i
                                                            class="fas fa-trash text-danger"
                                                            aria-hidden="true"></i></button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-center">
                    <div style="margin: 0px auto 0px auto">
                        <a href="{{ route('estudiante.index') }}" type="button" class="btn btn-danger ">Volver</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('inicio.estudiante.matricula')

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
        @if (count($errors) > 0)
            <script>
                $(document).ready(function() {
                    Snackbar.show({
                        text: 'Registre de forma correcta los campos.',
                        actionText: 'CERRAR',
                        pos: 'bottom-right',
                        duration: 5000
                    });
                    $('#modal-matricula').modal('show');
                });
            </script>
        @endif
        <script type="text/javascript">
            function obtenerGrupo(idCurso) {
                let url = "{{ route('obtenerGrupo') }}";

                url += '?idCurso=' + idCurso;
                // Realizar una solicitud AJAX para obtener las opciones del segundo select
                fetch(url)
                    .then(response => response.json())
                    .then(data => {
                        var selectGruposContainer = document.getElementById('selectGruposContainer');
                        selectGruposContainer.innerHTML = data.selectGrupos;

                        $("#idGrupo").selectpicker('refresh');
                    });
            }

            document.getElementById('selectCursos').addEventListener('change', function() {
                let idCurso = this.value; // Obtener el valor seleccionado
                obtenerGrupo(idCurso);
            });


            document.querySelector('#formMatricula').addEventListener('submit', function(e) {
                e.preventDefault(); // Prevenir el envío del formulario inmediatamente

                Swal.fire({
                    title: '¿Estás seguro?',
                    text: '¿Deseas continuar con la matrícula?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Sí, continuar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // El usuario confirmó, entonces envía el formulario
                        var form = document.getElementById('formMatricula');
                        let myButton = document.getElementById('btn-matricula');
                        myButton.disabled = false;
                        myButton.style.opacity = 0.7;
                        myButton.textContent = 'Procesando ...';
                        form.submit();
                    } 
                });
            });


            document.addEventListener("DOMContentLoaded", function() {
                let idCurso = document.getElementById('selectCursos').value;
                obtenerGrupo(idCurso);
            });
        </script>
    @endpush
@endsection
