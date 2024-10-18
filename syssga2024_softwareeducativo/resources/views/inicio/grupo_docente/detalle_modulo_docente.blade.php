<?php use App\Http\Controllers\GrupoDocenteController as GDC; ?>

@extends('layouts.docente')
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
                            <a href="{{ route('recurso_docente.index') . '?grupo=' . $grupo->idGrupo . '&nroModulo=' . $nroModulo }}" class="btn btn-default" style="background-color:#d9534f; color: #FFF;">
                                {{-- <a href="#" class="btn btn-default" style="background-color:#7e7f7f; color: #FFF;"> --}}
                                <i class="fa fa-tasks fa-4x"></i><br>
                                Tarea
                            </a>
                        </div>
                        <div class="col-lg-2 col-md-3 col-sm-6 col-xs-6">
                            {{-- <a href="#" class="btn btn-default" style="background-color:#5cb85c; color: #FFF;"> --}}
                                <a href="{{ route('cuestionario_docente.index') . '?grupo=' . $grupo->idGrupo . '&nroModulo=' . $nroModulo }}" class="btn btn-default" style="background-color:#2424a8; color: #FFF;">
                                <i class="fa fa-question fa-4x"></i><br>
                                Cuestionario
                            </a>
                        </div>
                        <div class="col-md-11 col-12 table-responsive">
                            <table class="table table-sm">
                                <thead class="text-white" style="background: #0059D1">
                                    <tr>
                                        <th>N°</th>
                                        <th>N° Documento</th>
                                        <th>Estudiante</th>
                                        <th style="text-align: center">Nota 1</th>
                                        <th style="text-align: center">Nota 2</th>
                                        <th style="text-align: center">Nota 3</th>
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
                                            <td style="text-align: center">
                                                <a href="#" onclick="desglose_nota('Nota 1', '{{$e->nota1}}', {{$e->idModulo}})">{{empty($e->nota1) ? '0.00' : GDC::promedioSubNota($e->nota1)}} </a>
                                                <input type="hidden" id="n1_{{ $e->idEstudiante }}" value="{{empty($e->nota1) ? '0.00' : GDC::promedioSubNota($e->nota1)}}">
                                            </td>
                                            <td style="text-align: center">
                                                <a href="#" onclick="desglose_nota('Nota 2', '{{$e->nota2}}', {{$e->idModulo}})">{{empty($e->nota2) ? '0.00' : GDC::promedioSubNota($e->nota2)}} </a>
                                                <input type="hidden" id="n2_{{ $e->idEstudiante }}" value="{{empty($e->nota2) ? '0.00' : GDC::promedioSubNota($e->nota2)}}">
                                            </td>
                                            <td style="text-align: center">
                                                <a href="#" onclick="desglose_nota('Nota 3', '{{$e->nota3}}', {{$e->idModulo}})">{{empty($e->nota3) ? '0.00' : GDC::promedioSubNota($e->nota3)}} </a>
                                                <input type="hidden" id="n3_{{ $e->idEstudiante }}" value="{{empty($e->nota3) ? '0.00' : GDC::promedioSubNota($e->nota3)}}">
                                            </td>
                                            <td>
                                                <input type="text"  id="nExamen_{{ $e->idEstudiante }}" class="form-control form-control-sm" 
                                                    value="{{$e->notaExamen}}" onkeyup="notaFinal('{{ $e->idEstudiante }}');">
                                            </td>
                                            <td>
                                                <input type="text" id="n_final_{{ $e->idEstudiante }}" class="form-control form-control-sm">
                                            </td>
                                            <td>
                                                <input type="text"  name="nRecuperacion[]" id="nRecuperacion_{{ $e->idEstudiante }}" 
                                                    class="form-control form-control-sm" value="{{$e->notaRecuperacion}}">
                                            </td>
                                            <td>
                                                <input type="text" class="form-control form-control-sm" id="n_final2_{{ $e->idEstudiante }}" disabled>
                                            </td>
                                            <td>
                                                
                                            </td>
                                        </tr>
                                        @include('inicio.grupo_docente.desglose_nota')
                                    @endforeach
                                </tbody>
                            </table>
                                
                        </div>

                    </div>
                </div>
                <div class="card-footer text-center">
                    <a href="{{ route('grupo_docente.show', $grupo->idGrupo) }}" type="button" class="btn btn-danger ">Volver</a>
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
        <script>
            function desglose_nota(titulo, nota, idModulo){
                if(nota !== ""){
                    let jsonObject = JSON.parse(nota);
                    document.getElementById('subNota1_' + idModulo).value = jsonObject.subNota1;
                    document.getElementById('subNota2_' + idModulo).value = jsonObject.subNota2;
                    document.getElementById('subNota3_' + idModulo).value = jsonObject.subNota3;
                }else{
                    document.getElementById('subNota1_' + idModulo).value = "";
                    document.getElementById('subNota2_' + idModulo).value = "";
                    document.getElementById('subNota3_' + idModulo).value = "";
                }

                document.getElementById('nota_' + idModulo).value = titulo;
                document.getElementById('lblnota_' + idModulo).innerHTML = titulo;
                $('#modal-desglose-' + idModulo).modal("show");
            }

            function notaFinal(id) {
                var n1 = document.getElementById('n1_' + id).value == '' ? 0 : parseFloat(document.getElementById('n1_' + id)
                    .value);
                var n2 = document.getElementById('n2_' + id).value == '' ? 0 : parseFloat(document.getElementById('n2_' + id)
                    .value);
                var n3 = document.getElementById('n3_' + id).value == '' ? 0 : parseFloat(document.getElementById('n3_' + id)
                    .value);
                var nExamen = document.getElementById('nExamen_' + id).value == '' ? 0 : parseFloat(document.getElementById(
                    'nExamen_' + id).value);

                let nFinal = (n1 * 0.22) + (n2 * 0.22) + (n3 * 0.22) + (nExamen * 0.34);

                document.getElementById('n_final_' + id).value = nFinal.toFixed(0);
                let nRecup = document.getElementById('nRecuperacion_' + id).value;
                if (nRecup !== '') {
                    nFinal = (n1 * 0.22) + (n2 * 0.22) + (n3 * 0.22) + (nRecup * 0.34);
                    document.getElementById('n_final2_' + id).value = nFinal.toFixed(0);
                }else{
                    document.getElementById('n_final2_' + id).value = "";
                }
            }
        </script>
    @endpush
@endsection
