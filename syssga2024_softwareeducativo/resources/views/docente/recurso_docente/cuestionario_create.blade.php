<?php use App\Http\Controllers\GrupoDocenteController as GDC; ?>

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

                </div>

            </div>
            <form action="{{ route('store_cuestionario') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card ">
                    <div class="card-header ">
                        <h5>{{ $leccion->nombreLeccion }}</h5>
                    </div>
                    <div class="card-body">
                        @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <div class="row">
                            <div class="col-8">
                                <div class="form-group">
                                    <label for="titulo">Título <span title="Campo Obligatorio"
                                            class="text-danger">*</span></label>
                                    <input type="text" name="titulo" class="form-control" id="titulo"
                                        placeholder="Ingrese el título del examen" value="{{ old('titulo') }}" required>
                                    @error('titulo')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="tipo">Tipo de Actividad <span title="Campo Obligatorio"
                                            class="text-danger">*</span></label>
                                    <select name="tipo" class="form-control {{ $errors->has('tipo') ? 'is-invalid' : '' }}" required onchange="mostrarAd(this.value);">
                                        <option value="" selected hidden>Seleccionar</option>
                                        <option value="EXAMEN FINAL"  >Examen Final</option>
                                        <option value=" EXAMEN RECUPERACION"  >Examen de Recuperacion</option>
                                       
                                    </select>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="descripcion">Descripción</label>
                                    <textarea name="descripcion" id="descripcion" rows="2"
                                        class="form-control @error('descripcion') is-invalid @enderror"
                                        placeholder="Ingrese la descripción del examen (Opcional)">{{ old('descripcion') }}</textarea>
                                    @error('descripcion')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            
                            <input type="hidden" name="idLeccion" value="{{ $leccion->idLeccion }}">
                            <div class="col-12" id="configInicial" style="display:none;">
                                <div class="card"  >
                                    <div class="card-header bg-info">
                                        <h6>Configuración Inicial Cuestionario</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-4">
                                                <div class="form-group">
                                                    <label for="restringir_fecha">Restringir Fecha <span title="Campo Obligatorio"
                                                    class="text-danger">*</span></label>
                                                    <br>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="restringir_fecha" id="inlineRadio1" value="1" onclick="mostrarRestrig();" required>
                                                        <label class="form-check-label" for="inlineRadio1">Sí</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="restringir_fecha" id="inlineRadio2" value="0" onclick="mostrarRestrig();" checked required>
                                                        <label class="form-check-label" for="inlineRadio2">No</label>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="col-2" id="f1" style="display:none;">
                                                <div class="form-group">
                                                    <label for="fechaInicio">Disponible desde: <span title="Campo Obligatorio"
                                                    class="text-danger">*</span></label>
                                                    <input type="date" class="form-control " name="fechaInicio" id="fechaInicio" >
                                                </div>
                                            </div>
                                            <div class="col-2" id="h1" style="display:none;">
                                                <div class="form-group">
                                                    <label for="tipo">Hora Inicio: <span title="Campo Obligatorio"
                                                    class="text-danger">*</span></label>
                                                    <input type="time" class="form-control " name="horaInicio" id="horaInicio" >
                                                </div>
                                            </div>
                                            <div class="col-2" id="f2" style="display:none;">
                                                <div class="form-group">
                                                    <label for="tipo">Disponible hasta: <span title="Campo Obligatorio"
                                                    class="text-danger">*</span></label>
                                                    <input type="date" class="form-control " name="fechaFin" id="fechaFin" >
                                                </div>
                                            </div>
                                            <div class="col-2" id="h2" style="display:none;">
                                                <div class="form-group">
                                                    <label for="tipo">Hora Fin: <span title="Campo Obligatorio"
                                                    class="text-danger">*</span></label>
                                                    <input type="time" class="form-control " name="horaFin" id="horaFin" >
                                                </div>
                                            </div>
                                            
                                            
                                        </div>
                                        <div class="row">
                                            <div class="col-4">
                                                <div class="form-group">
                                                    <label for="timeDisponible">Tiempo disponible: <span title="Campo Obligatorio"
                                                        class="text-danger">*</span></label>
                                                    <input type="number" max="60" class="form-control" name="timeDisponible" value="30" required>

                                                </div>
                                                
                                            </div>
                                            <div class="col-4">
                                                <div class="form-group">
                                                    <label for="intentoDisponible">Intentos Disponibles:<span title="Campo Obligatorio"
                                                        class="text-danger">*</span></label>
                                                    <input type="number" max="3" class="form-control" name="intentoDisponible" value="1" required>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="form-group">
                                                    <label for="preguntaPagina">Número preguntas por página:<span title="Campo Obligatorio"
                                                        class="text-danger">*</span></label>
                                                    <input type="number" min="5" class="form-control" name="preguntaPagina" value="5" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-4">
                                                <div class="form-group">
                                                    <label for="revisarPreguntas">Revisar Preguntas: <span title="Campo Obligatorio"
                                                        class="text-danger">*</span></label><br>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="revisarPreguntas" id="inlineRadio3" value="1"  required>
                                                        <label class="form-check-label" for="inlineRadio3">Sí</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="revisarPreguntas" id="inlineRadio4" value="0"  checked required>
                                                        <label class="form-check-label" for="inlineRadio4">No</label>
                                                    </div>
                                                </div>
                                                
                                            </div>
                                            <div class="col-4">
                                                <div class="form-group">
                                                    <label for="verResultados">Ver resultados:<span title="Campo Obligatorio"
                                                        class="text-danger">*</span></label><br>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="verResultados" id="inlineRadio5" value="1"  required>
                                                        <label class="form-check-label" for="inlineRadio5">Sí</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="verResultados" id="inlineRadio6" value="0"  checked required>
                                                        <label class="form-check-label" for="inlineRadio6">No</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="form-group">
                                                    <label for="preguntasAleatoria">Preguntas Aleatorias:<span title="Campo Obligatorio"
                                                        class="text-danger">*</span></label><br>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="preguntasAleatoria" id="inlineRadio7" value="1"  required>
                                                        <label class="form-check-label" for="inlineRadio7">Sí</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="preguntasAleatoria" id="inlineRadio8" value="0"  checked required>
                                                        <label class="form-check-label" for="inlineRadio8">No</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="card-footer text-center">
                        <a href="{{ route('cuestionario_docente.index') . "?grupo=$grupo->idGrupo&nroModulo=$nroModulo" }}"
                            class="btn btn-danger" data-dismiss="modal">Cancelar</a>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </div>
            </form>
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
            function mostrarRestrig(){
                var restringir=$('input[name="restringir_fecha"]:checked').val();
                if(restringir==1){
                    $('#f1').css('display','block');
                    $('#h1').css('display','block');
                    $('#f2').css('display','block');
                    $('#h2').css('display','block');
                    $("#fechaInicio").prop('required',true);
                    $("#horaInicio").prop('required',true);
                    $("#fechaFin").prop('required',true);
                    $("#horaFin").prop('required',true);
                }else{
                    $('#f1').css('display','none');
                    $('#h1').css('display','none');
                    $('#f2').css('display','none');
                    $('#h2').css('display','none');
                    $("#fechaInicio").prop('required',false);
                    $("#horaInicio").prop('required',false);
                    $("#fechaFin").prop('required',false);
                    $("#horaFin").prop('required',false);
                }
            }
            function mostrarAd(id){
                if(id!=''){
                    $('#configInicial').css('display','block');
                }else{
                    $('#configInicial').css('display','none');
                }
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
