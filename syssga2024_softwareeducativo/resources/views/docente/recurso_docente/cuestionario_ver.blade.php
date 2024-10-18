<?php use App\Http\Controllers\RecursoCuestionarioController as RC; ?>
<?php use  App\Models\EstudianteRespCuestionario; ?>

@extends('layouts.estudiante')
@section('contenido')

<div class="row mt-2">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
            <h4>
                <b><b>Entrega | Desarrollo Actividad</b></b>
            </h4>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3 col-12">
                                <div class="card">
                                    <div class="card-header bg-primary">
                                            Detalle Actividad <br>
                                    </div>
                                    <div class="card-body">
                                            <b>Titulo: </b> {{$examen->titulo}}
                                            <br>
                                            <b>Descripción: </b> {{$examen->descripcion}}
                                            <br>
                                            @if($examen->restringir_fecha==1)
                                            <b>Disponible de: </b> <br>
                                            {{ date('d/m/y', strtotime($examen->fechaInicio)) . ' ' . date('h:i A', strtotime($examen->horaInicio)) }}
                                            <br>
                                            <b>Hasta: </b> <br>
                                            {{ date('d/m/y', strtotime($examen->fechaFin)) . ' ' . date('h:i A', strtotime($examen->horaFin)) }}
                                            <br>
                                            @endif
                                            <b>Tiempo Disponible: </b> <br>
                                            {{$examen->timeDisponible}}(min).
                                            <hr>
                                            <b>Iniciaste en: </b> <br>
                                            {{ date('d/m/y', strtotime($fechaini)) . ' ' . date('h:i A', strtotime($fechaini)) }}
                                            <br>
                                            <b>Tiempo Disponible (En ejecución): </b> <br>
                                            <span class="badge badge-default" style="color: rgb(255, 255, 255); font-size: 1em; background: rgb(40, 167, 69);"
                                                id="lbltiempoDisponible"></span>

                                    </div>
                                </div>                                                                                  
                            </div>
                            <div class="col-md-9 col-12">
                                <div class="card">
                                    <div class="card-header bg-primary">
                                            Resolución <br>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">             
                                            <div class="col-12">
                                                @php($a=1)
                                                @foreach($preguntas as $p)
                                                        <div class="card-header p-0 mt-2">
                                                            <div class="row">
                                                                <div class="col-md-10 col-12">
                                                                    <table class="table">
                                                                        <tbody>
                                                                            <tr>
                                                                                <td>
                                                                                <span class="badge badge-success m-2">{{$a}}
                                                                                </span>
                                                                                </td>
                                                                                <td><p>{!! $p->preguntaEnunciadoTD !!}</p></td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                                <div class="col-md-1 col-6 m-0">
                                                                        {{$p->puntajeTD}} Pts.
                                                                </div>
                                                                <div class="col-md-1 col-6 m-0">
                                                                
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="card-body">
                                                            @php($tipo = 'radio')
                                                            @if($p->tipoPreg=='OPCION MÚLTIPLE')
                                                                    @php($tipo = 'checkbox')
                                                            @endif
                                                            
                                                            @php($respuestas = RC::listarRespuestas($p->idPregunta))
                                                            @php($cant=0)
                                                            @php($correc=0)
                                                            @foreach($respuestas as $r)                                                                                                                        
                                                            <p class="p-1" style="background: #e9e8e8">
                                                
                                                            <input type="{{$tipo}}" value="{{$r->idRespuesta}}" name="{{$p->idPregunta}}[]">
                                                                            {{$r->opcionRespTD}} 
                           
                                                            </p>

                                                            @endforeach
                                                        </div>
                                                @php($a++)
                                                @endforeach
                                               
                                            </div>
                                          
                                            <div class="col-12 text-center">
                                                    
                                                    <button  id="enviar" class="btn btn-primary" disabled>Enviar</button>
                                                  
                                                    <a href="{{ route('crear_cuestionario',$examen->idCuestionario) }}" class="btn btn-danger">Volver</a>
                                                    
                                            </div>
                                        </div>
                                            
                                    </div>
                                </div>
                            </div>
                        </div>
                            
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script>
        function verificarTiempos(){
                const fechaini=@json($fechaini);
                const examen=@json($examen);
                
                let fechaActual=moment();
                let inicioResolucion = moment(fechaini);
                let timer =(examen.timeDisponible *  60) - fechaActual.diff(inicioResolucion,'seconds');
                let minutos = Math.floor(timer/60);
                let segundos = timer % 60;
                //console.log(nota);
                document.getElementById('lbltiempoDisponible').innerHTML = minutos.toString().padStart(2,'0')+':'+segundos.toString().padStart(2,'0');
                //console.log(inicioResolucion);
                //console.log(fechaActual.diff(inicioResolucion,'minutes'));
                document.getElementById('lbltiempoDisponible').style.background ="#28s745";
                if(fechaActual.diff(inicioResolucion,'minutes') >= examen.timeDisponible ){
                        document.getElementById('lbltiempoDisponible').innerHTML = 'El tiempo de resolución se agotó';
                        document.getElementById('lbltiempoDisponible').style.background = '#dc3545';
                        //$('#actualizar').click();
                        clearInterval(intervalID);
                      
                       
                }
                //console.log(examen);
        }

        let intervalID=setInterval(verificarTiempos,1000);

</script>
@endpush
@endsection