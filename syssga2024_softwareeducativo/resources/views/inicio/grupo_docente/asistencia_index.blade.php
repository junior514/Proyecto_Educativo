<?php use App\Http\Controllers\GrupoDocenteController as GDC; ?>
@extends('layouts.docente')
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
                            <a class="btn btn-success btn-sm"
                                href="{{ route('asistencia_create', [$grupo->idGrupo, $nroModulo]) }}">
                                <i class="fas fa-plus-circle" style="color: #cef5e1; margin-right: 10px"></i>Agregar
                            </a>
                        </div>
                        <div class="col-md-1 col-12 text-center">
                            <a href="{{route('asistencia.excel', [$grupo->idGrupo, $nroModulo, $st, $st2])}}" class="btn btn-default">
                                <i class="fas fa-file-excel text-success"></i>
                            </a>
                        </div>
                    </div>

                </div>
                <div class="card-body pb-0">
                    @include('inicio.grupo_docente.asistencia_search')
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
                                                <a href="{{ route('asistencia_edit', $r->idAsistencia) }}"
                                                    class="text-warning"><i class="fas fa-edit"></i></a>
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
                                <tfoot>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        @foreach($registros as $r)
                                            <td style="text-align: center">
                                                <form action="{{ route('asistencia_destroy', $r->idAsistencia) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-default borrar2 btn-sm"
                                                        title="Eliminar {{ $r->fecha }}" data-nombre="{{ $r->fecha }}">
                                                        <i class="fa fa-trash text-danger" aria-hidden="true"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        @endforeach
                                    </tr>
                                </tfoot>
                            </table>

                        </div>

                    </div>
                </div>
                <div class="card-footer text-center">
                    <a href="{{route('detalle_modulo_docente', [$grupo->idGrupo, $nroModulo])}}" type="button"
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
