<?php use App\Http\Controllers\EstudianteController as EC; ?>
@extends('layouts.admin')
@section('contenido')
    <div class="row mt-2">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>
                        <b>Módulos - {{$matricula->nomCur}}</b>
                    </h4>
                    <div class="row justify-content-end">
                        <div class="col-md-8 col-12 text-right">
                            <h4>{{$matricula->nomEst}}</h4>
                            <h5>DNI: {{$matricula->nroDoc}}</h5> 
                        </div>
                        <div class="col-md-2">
                            @php($nombre_fichero = public_path('matricula/' . $matricula->fotoEst))
                            @if (file_exists($nombre_fichero) && !empty($matricula->fotoEst))
                                <img src="{{ asset('estudiante/' . $matricula->fotoEst) }}" id="img" width="100" height="100">
                            @else
                                <img src="{{ asset('estudiante/auxiliar_' . ($matricula->generoEst == 'MASCULINO' ? 'hombre' : 'mujer') . '.png') }}" id="img" width="100" height="100">
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row justify-content-center">
                        {{-- <div class="col-12">
                            <a class="btn btn-success btn-sm" href="" data-target="#modal-modulo" data-toggle="modal">
                                <i class="fas fa-plus-circle" style="color: #cef5e1; margin-right: 10px"></i>Agregar Módulo
                            </a>
                        </div> --}}
                        <div class="col-md-8">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>N°</th>
                                        <th>Docente</th>
                                        <th>N° Módulo</th>
                                        <th>Nota 1</th>
                                        <th>Nota 2</th>
                                        <th>Nota 3</th>
                                        <th>Nota Examen</th>
                                        <th>Nota Recuperación</th>
                                        <th colspan="2">Opciones</th>
                                    </tr>
                                </thead>
                                @php($cont = 1)
                                @foreach($modulos as $m)
                                    <tr>
                                        <td>{{ $cont++ }}</td>
                                        <td>{{$m->nomDoc }}</td>
                                        <td>Módulo {{ $m->nroModulo }}</td>
                                        <td>{{$m->nota1 }}</td>
                                        <td>{{$m->nota2 }}</td>
                                        <td>{{$m->nota3 }}</td>
                                        <td>{{$m->notaExamen }}</td>
                                        <td>{{$m->notaRecuperacion }}</td>
                                        <td>
                                            <a class="btn btn-default btn-sm" href="#" onclick="return abrirModalEdit('{{$m->idModulo}}', '{{$m->nroModulo}}', '{{$m->idGrupo}}')">
                                                <i class="far fa-edit text-info"></i>
                                            </a>
                                        </td>
                                        <td>
                                            {{-- <form action="{{ route('destroy_modulo', $m->idModulo)  }}"
                                                method="POST">
                                                {!! csrf_field() !!}
                                                {!! method_field('DELETE') !!}
                                                <button class="btn btn-default borrar2 btn-sm"
                                                    title="Eliminar {{ $m->nomDoc }}- Módulo N° {{ $m->nroModulo }}" data-nombre="{{ $m->nomDoc }}- Módulo N° {{ $m->nroModulo }}"><i
                                                        class="fa fa-trash text-danger" aria-hidden="true"></i></button>
                                            </form> --}}
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-center">
                    <div style="margin: 0px auto 0px auto">
                        <a href="{{ route('estudiante.show', $matricula->idEstudiante) }}" type="button" class="btn btn-danger ">Volver</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

@include('inicio.estudiante.modulo_create')
@include('inicio.estudiante.modulo_edit')

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
                    let idModulo = @json(old('idModulo'));
                    if(idModulo === null){
                        $('#modal-modulo').modal('show');
                    }else{
                        $("#modal-modulo-edit").modal('show');
                    }
                    
                });
            </script>
        @endif
        <script type="text/javascript">
            function abrirModalEdit(idModulo, nroModulo, idGrupo){
                
                document.getElementById('idModulo_e').value = idModulo;
                document.getElementById('nroModulo_e').value = nroModulo;
                document.getElementById('idGrupo_e').value = idGrupo;
                $('#idGrupo_e').selectpicker('refresh');
                $("#modal-modulo-edit").modal('show');
            }
        </script>
    @endpush
@endsection
