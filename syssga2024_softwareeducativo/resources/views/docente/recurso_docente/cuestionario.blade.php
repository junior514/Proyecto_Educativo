<?php use App\Http\Controllers\RecursoCuestionarioController as RC; ?>

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
                          
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table m-0">
                                @php($recursos = RC::listarRecursos($l->idLeccion))
                                <tbody>
                                    @foreach ($recursos as $r)
                                    @php($respt = RC::listarRespuestasEst($r->idCuestionario))
                                        <tr>
                                            <td style="width: 10%">
                                                <a href="{{ route('crear_cuestionario', $r->idCuestionario) }}" class="btn btn-default"
                                                    style="background-color:#d9534f; color: #FFF;">
                                                    <i class="fa fa-tasks"></i>
                                                </a>
                                            </td>
                                            <td style="width: 80%">
                                                <a href="{{ route('crear_cuestionario', $r->idCuestionario) }}">
                                                    {{ $r->titulo }}
                                                </a>
                                                <br>
                                                <span>{{ date('d/m/y', strtotime($r->fechaCreacion)) . ' ' . date('h:i A', strtotime($r->fechaCreacion)) }}</span>
                                            </td>
                                            <td style="width: 10%">
                                                <a href="{{ route('cuestionario_docente.edit', $r->idCuestionario) }}"
                                                    class="btn btn-default btn-sm">
                                                    <i class="far fa-edit text-info"
                                                        title="EDITAR Examen {{ $r->titulo }}"></i>
                                                </a>
                                            </td>
                                            <td style="width: 10%">
                                            @if(count($respt)==0)
                                                <form action="{{ route('cuestionario_destroy', $r->idCuestionario) }}"
                                                    style="margin-bottom: 0px" method="POST">
                                                    {!! csrf_field() !!}
                                                    {!! method_field('DELETE') !!}
                                                    <button class="btn btn-default borrar2 btn-sm"
                                                        title="Eliminar Examen {{ $r->titulo }}"
                                                        data-nombre="{{ $r->titulo }}"><i
                                                            class="fas fa-trash text-danger"
                                                            aria-hidden="true"></i></button>
                                                </form>
                                            @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                    </div>
                    <div class="card-footer clearfix">
                        <a href="{{ route('create_cuestionario', $l->idLeccion) }}"
                            class="float-right"><i class="fa fa-plus"></i>&nbsp;Agregar Cuestionario</a>
                            
                            <a href="#" onclick="return editmodalLeccion('{{$l->idLeccion}}','{{$l->nombreLeccion}}');"
                            class="float-left" title="Editar Sesion"><i class="fa fa-edit"></i></a>
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

    <div class="modal fade" id="modal-edit-leccion" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-dark">
                    <h5 class="modal-title" style="text-align: center; font-weight: bold">Editar Sesión</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form action="{{route('edit_leccion')}}" id="editSesion" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <input type="hidden" name="idLeccion" id="idLeccion">
                            <div class="col-md-12 col-12">
                                <div class="form-group">
                                    <label for="">Nombre</label>
                                    <textarea name="nombreLeccion" id="nombreLeccion"  rows="2" class="form-control"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Modificar</button>
                    </div>
                </form>    
            </div>
        </div>
    </div>
    @include('docente.recurso_docente.leccioncuestionario_create')

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

            function editmodalLeccion(id,nombre){
                document.getElementById('idLeccion').value = id;
                document.getElementById('nombreLeccion').value = nombre;
                $("#modal-edit-leccion").modal('show');
            }
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
