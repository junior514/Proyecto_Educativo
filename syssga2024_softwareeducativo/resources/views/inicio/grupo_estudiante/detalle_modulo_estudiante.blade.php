<?php use App\Http\Controllers\GrupoDocenteController as GDC; ?>

@extends('layouts.estudiante')
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
                        <div class="col-lg-2 col-md-3 col-sm-6 col-xs-6">
                      
                                <a href="{{route('asistencia_index', [$grupo->idGrupo, $nroModulo])}}"  class="btn btn-default"
                                        style="background-color:#ffea29; color: #303030;">
                                    <i class="fas fa-clipboard-list fa-4x"></i><br>
                                    Asistencia
                                </a>
                        </div>
                        <div class="col-lg-2 col-md-3 col-sm-6 col-xs-6">
                            {{-- <a href="#" class="btn btn-default" style="background-color:#3276b1; color: #FFF;"> --}}
                                <a href="#" class="btn btn-default" style="background-color:#7e7f7f; color: #FFF;">
                                <i class="fa fa-book fa-4x" style=""></i><br>
                                Contenido
                            </a>
                        </div>
                        <div class="col-lg-2 col-md-3 col-sm-6 col-xs-6">
                            {{-- <a href="#" class="btn btn-default" style="background-color:#5bc0de; color: #FFF;"> --}}
                                <a href="#" class="btn btn-default" style="background-color:#7e7f7f; color: #FFF;">
                                <i class="fa fa-comments fa-4x"></i><br>
                                Foro
                            </a>
                        </div>
                        <div class="col-lg-2 col-md-3 col-sm-6 col-xs-6">
                            <a href="{{ route('recurso_estudiante.index') . '?grupo=' . $grupo->idGrupo . '&nroModulo=' . $nroModulo }}" class="btn btn-default" style="background-color:#d9534f; color: #FFF;">
                                {{-- <a href="#" class="btn btn-default" style="background-color:#7e7f7f; color: #FFF;"> --}}
                                <i class="fa fa-tasks fa-4x"></i><br>
                                Tarea
                            </a>
                        </div>
                        <div class="col-lg-2 col-md-3 col-sm-6 col-xs-6">
                            {{-- <a href="#" class="btn btn-default" style="background-color:#5cb85c; color: #FFF;"> --}}
                                <a href="{{ route('cuestionario_estudiante.index') . '?grupo=' . $grupo->idGrupo . '&nroModulo=' . $nroModulo }}" class="btn btn-default" style="background-color:#2424a8; color: #FFF;">
                                <i class="fa fa-question fa-4x"></i><br>
                                Cuestionario
                            </a>
                        </div>
                        <div class="col-md-10 col-12">
                            <table class="table table-sm">
                                <thead class="text-white" style="background: #0059D1">
                                    <tr>
                                        <th>N°</th>
                            
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
                                    {{-- @php($cont = 1)
                                    @foreach($estudiantes as $e)
                                        <tr>
                                            <td>{{$cont++}}</td>
                                         
                                            <td>
                                                <a href="#" onclick="desglose_nota('Nota 1', '{{$e->nota1}}')">{{empty($e->nota1) ? '0.00' : GDC::promedioSubNota($e->nota1)}} </a>
                                            </td>
                                            <td>
                                                <a href="#" onclick="desglose_nota('Nota 2', '{{$e->nota2}}')">{{empty($e->nota2) ? '0.00' : GDC::promedioSubNota($e->nota2)}} </a>
                                            </td>
                                            <td>
                                                <a href="#" onclick="desglose_nota('Nota 3', '{{$e->nota3}}')">{{empty($e->nota3) ? '0.00' : GDC::promedioSubNota($e->nota3)}} </a>
                                            </td>
                                            <td>{{$e->notaExamen}}</td>
                                            <td>{{$e->notaRecuperacion}}</td>
                                        </tr>
                                    @endforeach --}}
                                </tbody>
                            </table>
                                
                        </div>

                    </div>
                </div>
                <div class="card-footer text-center">
                    <a href="{{ route('grupo_estudiante.show', $grupo->idGrupo) }}" type="button" class="btn btn-danger ">Volver</a>
                    {{-- <button type="submit" class="btn btn-primary">Guardar</button> --}}
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
            function desglose_nota(titulo, nota){
                if(nota !== ""){
                    let jsonObject = JSON.parse(nota);
                    document.getElementById('subNota1').value = jsonObject.subNota1;
                    document.getElementById('subNota2').value = jsonObject.subNota2;
                    document.getElementById('subNota3').value = jsonObject.subNota3;
                }else{
                    document.getElementById('subNota1').value = "";
                    document.getElementById('subNota2').value = "";
                    document.getElementById('subNota3').value = "";
                }

                document.getElementById('nota').value = titulo;
                document.getElementById('lblnota').innerHTML = titulo;
                $('#modal-desglose').modal("show");
            }
        </script>
    @endpush
@endsection
