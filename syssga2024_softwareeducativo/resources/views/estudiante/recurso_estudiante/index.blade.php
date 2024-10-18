<?php use App\Http\Controllers\RecursoController as RC; ?>
<?php use App\Http\Controllers\RecursoEstudianteController as REC; ?>

@extends('layouts.estudiante')
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
            @foreach ($lecciones as $l)
                <div class="card">
                    <div class="card-header border-transparent pt-2 pb-1" style="background: #7a7979; color: #ffffff;">
                        <h3 class="card-title">{{ $l->nombreLeccion }}</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                            {{-- <button type="button" class="btn btn-tool" data-card-widget=s"remove">
                                <i class="fas fa-times"></i>
                            </button> --}}
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table m-0">
                                @php($recursos = RC::listarRecursos($l->idLeccion))
                                <tbody>
                                    @foreach ($recursos as $r)
                                        <tr>
                                            <td style="width: 10%">
                                                @php($entregaTarea = REC::verificarEntregaTarea($r->idRecurso, auth()->user()->idEstudiante))
                                                @if (!$entregaTarea)
                                                    <a href="{{ route('entrega_tarea', $r->idRecurso) }}"
                                                        class="btn btn-default"
                                                        style="background-color:#d9534f; color: #FFF;">
                                                        <i class="fa fa-tasks"></i>
                                                    </a>
                                                @else
                                                    <a href="{{ route('corregir_tarea', $entregaTarea->idEntregaTarea) }}"
                                                        class="btn btn-default"
                                                        style="background-color:#d9534f; color: #FFF;">
                                                        <i class="fa fa-tasks"></i>
                                                    </a>
                                                @endif
                                            </td>
                                            <td style="width: 90%">
                                                @if (!$entregaTarea)
                                                    <a href="{{ route('entrega_tarea', $r->idRecurso) }}">
                                                        <span style="font-weight: bold">{{ $r->titulo }}</span> -
                                                        {{ date('d/m/y', strtotime($r->fechaInicio)) . ' ' . date('h:i A', strtotime($r->horaInicio)) }}
                                                        |
                                                        {{ date('d/m/y', strtotime($r->fechaFin)) . ' ' . date('h:i A', strtotime($r->horaFin)) }}
                                                    </a>
                                                @else
                                                    <a href="{{ route('corregir_tarea', $entregaTarea->idEntregaTarea) }}">
                                                        <span style="font-weight: bold">{{ $r->titulo }}</span> -
                                                        {{ date('d/m/y', strtotime($r->fechaInicio)) . ' ' . date('h:i A', strtotime($r->horaInicio)) }}
                                                        |
                                                        {{ date('d/m/y', strtotime($r->fechaFin)) . ' ' . date('h:i A', strtotime($r->horaFin)) }}
                                                    </a><br>
                                                    Entregado:
                                                    {{ date('d/m/Y h:i A', strtotime($entregaTarea->fechaEntrega)) }}
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endforeach


            <div class="card-footer text-center">
                <a href="{{ route('detalle_modulo_estudiante', [$grupo->idGrupo, $nroModulo]) }}" type="button"
                    class="btn btn-danger ">Volver</a>
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
