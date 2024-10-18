<?php use App\Http\Controllers\RecursoCuestionarioEController as RC; ?>

@extends('layouts.estudiante')
@section('contenido')
<div class="card">
    <div class="card-header">
        <h4><b>{{$grupo->nomCur}} - Módulo N° {{$nroModulo}}| Actividades</b></h4>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        @foreach($lecciones as $l)
        <div class="card">
            <div class="card-header bg-primary p-1">
                {{$l->nombreLeccion}}
            </div>
            <div class="card-body m-1">
                @php($recursos = RC::listarRecursos($l->idLeccion))
                @php($v=1)
                
                @php($hoy = $fecha .' '.$hora)
                @foreach($recursos as $r)
                <div class="row">
                    <div class="col-md-1 col-4">
                        <img src="{{ asset('dist/img/examen.png') }}" width="30" height="30" alt class="mt-2">
                    </div>
                    
                    <div class="col-md-4 col-8">
                       @if($r->restringir_fecha==1)
                        @php($ini = $r->fechaInicio . ' ' . $r->horaInicio)
                        @php($fin = $r->fechaFin . ' ' . $r->horaFin)
                        @if($hoy >= $ini && $hoy < $fin)
                            <a href="{{route('cuestionario_estudiante.ingresar_examen',[$r->idCuestionario,$grupo->idGrupo,$nroModulo])}}"><h5 style="margin: 0px; font-weight: bold; color: #235ca8">{{$v}}. {{$r->titulo}}</h5></a> 
                        @else
                            <h5 style="margin: 0px; font-weight: bold; color: #b98e8e">{{$v}}. {{$r->titulo}}</h5>
                        @endif
                       @else
                        <a href="{{route('cuestionario_estudiante.ingresar_examen',[$r->idCuestionario,$grupo->idGrupo,$nroModulo])}}"><h5 style="margin: 0px; font-weight: bold; color: #235ca8">{{$v}}. {{$r->titulo}}</h5></a>
                       @endif
                        
                        <span>{{ date('d/m/y', strtotime($r->fechaCreacion)) . ' ' . date('h:i A', strtotime($r->fechaCreacion)) }}</span>
                        <br>
                    </div>
                    <div class="col-md-3 col-6">
                    @if($r->restringir_fecha==1)
                        <b class="text-secondary">Disponible desde:</b>
                        <br>
                        <span>{{ date('d/m/y', strtotime($r->fechaInicio)) . ' ' . date('h:i A', strtotime($r->horaInicio)) }}</span>
                    @endif
                    </div>
                    <div class="col-md-3 col-6">
                    @if($r->restringir_fecha==1)
                        <b class="text-secondary">Disponible hasta:</b>
                        <br>
                        <span>{{ date('d/m/y', strtotime($r->fechaFin)) . ' ' . date('h:i A', strtotime($r->horaFin)) }}</span>
                    @endif
                    </div>
                </div>
                @php($v++)
                @endforeach
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection