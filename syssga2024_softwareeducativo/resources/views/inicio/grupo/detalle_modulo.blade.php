<?php use App\Http\Controllers\GrupoDocenteController as GDC; ?>
@extends('layouts.admin')
@section('contenido')

    <div class="row mt-2">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>
                        <b>{{$grupo->nomCur}} - {{$grupo->nomDoc}}  ({{$grupo->nombreGrupo}})</b>
                    </h4>
                    <h4>
                        <b>Módulo N° {{$nroModulo}}</b>
                    </h4>
                </div>
                <div class="card-body">
                    <div class="row justify-content-center">
                        <div class="col-lg-2 col-md-3 col-sm-6 col-xs-6 text-center">
                      
                            <a href="{{route('adm_asistencia_index', [$grupo->idGrupo, $nroModulo])}}"  class="btn btn-default"
                                    style="background-color:#ffea29; color: #303030;">
                                <i class="fas fa-clipboard-list fa-4x"></i><br>
                                Asistencia
                            </a>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        
                        <div class="col-md-8 col-12">
                            <table class="table table-sm">
                                <thead class="text-white" style="background: #0059D1">
                                    <tr>
                                        <th>N°</th>
                                        <th>N° Documento</th>
                                        <th>Estudiante</th>
                                        <th>Nota 1</th>
                                        <th>Nota 2</th>
                                        <th>Nota 3</th>
                                        <th>Nota<br> Examen</th>
                                        <th>Nota<br> Final</th>
                                        <th>Nota<br> Recuperación</th>
                                        <th>Nota<br> Final 2</th>
                                        <th style="text-align: center">Opciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php($cont = 1)
                                    @foreach($estudiantes as $e)
                                        <tr>
                                            <td>{{$cont++}}</td>
                                            <td>{{$e->nroDoc}}</td>
                                            <td>{{$e->nomEst}}</td>
                                            <td>{{empty($e->nota1) ? '0.00' : GDC::promedioSubNota($e->nota1)}}</td>
                                            <td>{{empty($e->nota2) ? '0.00' : GDC::promedioSubNota($e->nota2)}}</td>
                                            <td>{{empty($e->nota3) ? '0.00' : GDC::promedioSubNota($e->nota3)}}</td>
                                            <td>{{$e->notaExamen}}</td>
                                            <td>{{$e->notaRecuperacion}}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                                
                        </div>

                    </div>
                </div>
                <div class="card-footer text-center">
                    <a href="{{ route('grupo.show', $grupo->idGrupo) }}" type="button" class="btn btn-danger ">Volver</a>
                    {{-- <button type="submit" class="btn btn-primary">Guardar</button> --}}
                </div>
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
    @endpush
@endsection
