@extends('layouts.docente')
@section('contenido')
<div class="row mt-2">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4>
                    <b>{{ $cuestionario->titulo }} </b>
                </h4>
                <h7>
                    {{ $cuestionario->tipo }}
                </h7>
                <h5>
                    Editar Pregunta
                </h5>
            </div>
            <div class="card-body">
                <form action="{{ route('update_preguntas') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row mt-4" >
                        <div class="col-12" >
                            <div class="row" >
                                <input type="hidden" name="idCuestionario" value="{{$cuestionario->idCuestionario}}">
                                <input type="hidden" name="idPregunta" value="{{$pregunta->idPregunta}}">
                                <div class="col-10" >
                                    <div class="form-group" >
                                        <label for="">Título de Pregunta</label>
                                        
                                        <textarea name="preguntaEnunciadoTD" id="summernote" class="form-control" rows="5" required="" placeholder="Escriba aqui el enunciado de su pregunta" style="display: none;">
                                        {!! $pregunta->preguntaEnunciadoTD !!}
                                        </textarea>
                                    
                                    </div>
                                </div>
                                <div class="col-2" >
                                    <div class="form-group">
                                        <label for="">Puntaje</label>
                                        <input type="number" name="puntajeTD" class="form-control" min="1" max="20" required="" value="{{$pregunta->puntajeTD}}">
                                    </div>
                                    <div class="form-group">
                                        <label for="">Tipo</label>
                                        <input type="text" name="tipoPreg" id="tipoPreg" class="form-control form-control-sm" readonly="" value="{{$pregunta->tipoPreg}}">
                                    </div>
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                <div class="col-2 text-center">
                                    <span class="btn btn-default bg-teal" style="opacity: 0.9; display: block;" id="agregarOpcion" onclick="dibujarRespuesta1(null,{{count($respuesta)}})">Añadir Opción de
                                        Respuesta</span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <table class="table" id="detalle">
                                        @php($tipo='radio')
                                        @php($cont=0)
                                        @php($readOnly='')
                                        @php($disabled='')
                                        @if($pregunta->tipoPreg=='OPCION MÚLTIPLE')
                                            @php($tipo='checkbox')
                                        @endif
                                        @if($pregunta->tipoPreg=='VERDADERO O FALSO')
                                            @php($readOnly='readOnly')
                                            @php($disabled='disabled')
                                        @endif
                                        @foreach($respuesta as $r)
                                        @php($checked='')
                                        @if($r->respuestaTD=='1')
                                            @php($checked='checked')
                                        @endif
                                        <tr class="selected" id="fila_{{$cont}}">
                                            <td><input type="{{$tipo}}" class="form-control" name="respuestaTD[]" value="{{$cont}}" {{$checked}}></td>
                                            <td>
                                                <input type="hidden" name="enumerarTD[]" value="{{$cont}}">
                                                <input type="text" class="form-control" placeholder="Opción de respuesta" name="opcionRespTD[]" value="{{$r->opcionRespTD}}" {{$readOnly}}>
                                            </td>
                                            <td align="center">
                                                <button type="button" class="btn btn-default btn-sm" onclick="eliminarElemento({{$cont}});" {{$disabled}}>
                                                    <i class="fas fa-trash-alt text-danger"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        @php($cont++)
                                        @endforeach
                                    </table>
                                </div>
                                <div class="col-12 text-center">
                                    <a href="{{route('crear_cuestionario',$cuestionario->idCuestionario)}}" class="btn btn-danger" >Cancelar</a>
                                    <button type="submit" class="btn btn-primary">Modificar</button>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
   
</div>

@endsection
@push('scripts')
<script>
     $('#summernote').summernote({
        tabsize: 2,
        height: 80,
        toolbar: [
            ['style', ['bold', 'italic', 'underline', 'clear']],
            ['font', ['fontname', 'fontsize', 'color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['height', ['height']],
            ['table', ['table']],
            ['link', ['link']],
            ['codeview', ['codeview']],
            ['undo', ['undo']],
            ['redo', ['redo']]
        ],
        fontNames: ['Arial', 'Arial Black', 'Comic Sans MS', 'Courier New', 'Helvetica', 'Impact', 'Tahoma', 'Times New Roman', 'Verdana']
    });
    let elementos=[];
    let cont=0;
    function dibujarRespuesta1(tipo,cont) {

        if (tipo == null) {
            tipo = document.getElementById('tipoPreg').value == 'OPCION MÚLTIPLE' ? 'checkbox' : 'radio';
        }


        let fila = `<tr class="selected" id="fila_${cont}">
                            <td><input type="${tipo}" class="form-control" placeholder="Opción de respuesta" name="respuestaTD[]" value="${cont}"></td>
                            <td>
                                <input type="hidden" name="enumerarTD[]" value="${cont}">
                                <input type="text" class="form-control" placeholder="Opción de respuesta" name="opcionRespTD[]" value="">
                            </td>
                            <td align="center">
                                <button type="button" class="btn btn-default btn-sm" onclick="eliminarElemento(${cont});">
                                    <i class="fas fa-trash-alt text-danger"></i>
                                </button>
                            </td>
                        </tr>`;
        $('#detalle').append(fila);
        elementos.push(cont);
        cont++;

    }
    function eliminarElemento(value) {
        // let cont = arreglo.length;
        // for (x of arreglo) {

        $("#fila_" + value).remove();
        value = value - 1;
        elementos.splice(value, 1);
        cont--;
        // }
        // $("#fila_u").remove();
    }
</script>
@endpush
