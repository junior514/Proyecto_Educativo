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
                        <b>Módulo N° {{ $nroModulo }}</b>
                    </h4>
                    <a class="btn btn-success btn-sm" href="" data-target="#modal-add-leccion" data-toggle="modal">
                        <i class="fas fa-plus-circle" style="color: #cef5e1; margin-right: 10px"></i>Agregar
                    </a>
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
                                                <a href="{{ route('tarea_show', $r->idRecurso) }}" class="btn btn-default"
                                                    style="background-color:#d9534f; color: #FFF;">
                                                    <i class="fa fa-tasks"></i>
                                                </a>
                                            </td>
                                            <td style="width: 80%">
                                                <a href="{{ route('tarea_show', $r->idRecurso) }}">
                                                    {{ $r->titulo }}
                                                </a>
                                            </td>
                                            <td style="width: 10%">
                                                <a href="{{ route('recurso_docente.edit', $r->idRecurso) }}"
                                                    class="btn btn-default btn-sm">
                                                    <i class="far fa-edit text-info"
                                                        title="EDITAR Tarea {{ $r->titulo }}"></i>
                                                </a>
                                            </td>
                                            <td style="width: 10%">
                                                <form action="{{ route('tarea_destroy', $r->idRecurso) }}"
                                                    style="margin-bottom: 0px" method="POST">
                                                    {!! csrf_field() !!}
                                                    {!! method_field('DELETE') !!}
                                                    <button class="btn btn-default borrar2 btn-sm"
                                                        title="Eliminar Tarea {{ $r->titulo }}"
                                                        data-nombre="{{ $r->titulo }}"><i
                                                            class="fas fa-trash text-danger"
                                                            aria-hidden="true"></i></button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                    </div>
                    <div class="card-footer clearfix">
                        <a href="" data-target="#modal-add-recurso-{{ $l->idLeccion }}" data-toggle="modal"
                            class="float-right"><i class="fa fa-plus"></i>&nbsp;Agregar Recurso</a>
                    </div>


                </div>
                @include('docente.recurso_docente.seleccion_recurso')
            @endforeach

            <div class="card-footer text-center">
                <a href="{{ route('detalle_modulo_docente', [$grupo->idGrupo, $nroModulo]) }}" type="button"
                    class="btn btn-danger ">Volver</a>
            </div>
        </div>
       
    </div>


    @include('docente.recurso_docente.leccion_create')

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
