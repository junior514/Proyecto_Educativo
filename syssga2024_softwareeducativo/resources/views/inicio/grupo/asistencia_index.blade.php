<?php use App\Http\Controllers\GrupoDocenteController as GDC; ?>
@extends('layouts.admin')
@section('contenido')

    <div class="row mt-2">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-11 col-12">
                            <h4>
                                <b>{{ $grupo->nomCur }} - {{ $grupo->nomDoc }} ({{ $grupo->nombreGrupo }})</b>
                            </h4>
                            <h4>
                                <b>Módulo N° {{ $nroModulo }}</b>
                            </h4>
                          
                        </div>
                        <div class="col-md-1 col-12 text-center">
                            <a href="{{route('adm_asistencia.excel', [$grupo->idGrupo, $nroModulo, $st, $st2])}}" class="btn btn-default">
                                <i class="fas fa-file-excel text-success"></i>
                            </a>
                        </div>
                    </div>

                </div>
                <div class="card-body pb-0">
                    @include('inicio.grupo.asistencia_search')
                </div>
            </div>

            <div class="card">
                <div class="card-body p-0">
                    <div class="row justify-content-center">

                        <div class="col-12 table-responsive">
                            <table class="table table-sm table-bordered table-striped">
                                <thead class="text-white" style="background: #0059D1">
                                    <tr>
                                        <th>N°</th>
                                        <th>Estudiante</th>
                                        @foreach ($registros as $r)
                                            <th style="text-align: center">
                                                {{ date('d/m', strtotime($r->fecha)) }}
                                               
                                            </th>
                                        @endforeach

                                    </tr>
                                </thead>
                                <tbody>
                                    @php($cont = 1)
                                    @foreach ($estudiantes as $e)
                                        <tr>
                                            <td>{{ $cont++ }}</td>
                                            <td>{{ $e->nomEst }}</td>
                                            @foreach ($registros as $r)
                                                @php($a = GDC::obtenerAsistencia($e->idEstudiante, $r->idAsistencia))
                                                @php($a = !empty($a) ? $a->estado[0] : $a)
                                                <th style="text-align: center;}" class="text-{{$a == 'F' ? 'danger' : 'dark' }}">
                                                    {{ $a }}
                                                </th>
                                            @endforeach
                                        </tr>
                                    @endforeach
                                </tbody>
                               
                            </table>

                        </div>

                    </div>
                </div>
                <div class="card-footer text-center">
                    <a href="{{route('detalle_modulo', [$grupo->idGrupo, $nroModulo])}}" type="button"
                        class="btn btn-danger ">Volver</a>
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

            const mensaje = localStorage.getItem("mensaje");
            if (mensaje) {
                Toast.fire({
                    icon: 'success',
                    title: mensaje,
                    customClass: 'swal-pop',
                })
                localStorage.removeItem("mensaje");
            }
        </script>
    @endpush
@endsection
