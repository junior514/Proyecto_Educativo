
@extends('layouts.docente')
@section('contenido')
<div class="row mt-2">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-10">
                        <h4>
                            <b>{{ $cuestionario->titulo }} </b>
                        </h4>
                        <h7>
                            {{ $cuestionario->tipo }} 
                        </h7>
                    </div>
                    <div class="col-2">
                        <a class="btn btn-info float-right" href="{{route('ver_cuestionario',[$cuestionario->idCuestionario,$grupo->idGrupo,$leccion->nroModulo])}}"><i class="fa fa-search"></i> <br>Previsualización</a>
                    </div>
                </div>
               

            </div>
            <div class="card-body">
                @if($cuestionario->descripcion!=null)
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            {{$cuestionario->descripcion}}
                        </div>
                    </div>
                </div>
                @endif
                @if($cuestionario->restringir_fecha==1)
                <div class="row">
                    <div class="col-4">
                        <label for="timeDisponible">Disponible desde: </label>
                        <p>{{ date('d/m/y', strtotime($cuestionario->fechaInicio)) . ' ' . date('h:i A', strtotime($cuestionario->horaInicio)) }}</p> 
                    </div>
                    <div class="col-4">
                        <label for="timeDisponible">Disponible hasta: </label>
                        <p>{{ date('d/m/y', strtotime($cuestionario->fechaFin)) . ' ' . date('h:i A', strtotime($cuestionario->horaFin)) }}</p> 
                    </div>
                    <div class="col-4">
                        
                    </div>
                </div>
                @endif
                <div class="row">
                    <div class="col-4">
                        <label for="timeDisponible">Tiempo Disponible: </label>
                        <p>{{ $cuestionario->timeDisponible }} Minuto(s)</p> 
                    </div>
                    <div class="col-4">
                        <label for="titulo">Intentos Disponibles: </label>
                        <p>{{ $cuestionario->intentoDisponible }}</p>
                    </div>
                    <div class="col-4">
                        <label for="titulo">N° de preguntas por página: </label>
                        <p>{{ $cuestionario->preguntaPagina }}</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-4">
                        <label for="titulo">Revisar Preguntas: </label>
                        @if($cuestionario->revisarPreguntas==1)
                        <p>Sí</p>
                        @else
                        <p>No</p>
                        @endif
                        
                    </div>
                    <div class="col-4">
                        <label for="titulo">Ver resultados: </label>
                        @if($cuestionario->verResultados==1)
                        <p>Sí</p>
                        @else
                        <p>No</p>
                        @endif
                    </div>
                    <div class="col-4">
                        <label for="titulo">Preguntas Aleatorias: </label>
                        @if($cuestionario->preguntasAleatoria==1)
                        <p>Sí</p>
                        @else
                        <p>No</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('docente.recurso_docente.preguntas')
</div>

@endsection

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
