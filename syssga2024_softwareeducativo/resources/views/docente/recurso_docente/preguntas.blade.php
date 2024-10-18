<?php use App\Http\Controllers\RecursoCuestionarioController as RC; ?>
<div class="col-md-12">
    <div class="card">
        <div class="card-header p-2">
            <ul class="nav nav-pills">
                <li class="nav-item">
                    <a class="nav-link active" href="#activity" data-toggle="tab">Preguntas</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#timeline" data-toggle="tab">Respuestas</a>
                </li>
            </ul>
        </div>
        <div class="card-body">
            <div class="tab-content">
                <div class="tab-pane active" id="activity">
                    <div class="row">
                        <div class="col-2">
                            <span class="btn btn-success" id="agregar" data-toggle="dropdown" aria-expanded="false">
                                Agregar Pregunta 
                            </span>
                            <div class="dropdown-menu dropdown-menu-lg" style="">
                                <a href="#" class="dropdown-header" onclick="opcionMultiple()">Múltiple
                                    respuesta</a>
                                <div class="dropdown-divider"></div>
                                <a href="#" class="dropdown-header" onclick="unicaRespuesta()">Única
                                    respuesta</a>
                                <div class="dropdown-divider"></div>
                                <a href="#" class="dropdown-header" onclick="verdaderoFalso();">Verdadero
                                    o
                                    Falso</a>
                            </div>
                        </div>
                    </div>
                    <form action="{{ route('store_preguntas') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                         <div class="row mt-4" id="vistaNuevaPregunta" style="display:none;">
                            <div class="col-12" >
                                <div class="row" >
                                    <input type="hidden" name="idCuestionario" value="{{$cuestionario->idCuestionario}}">
                                    <div class="col-10" >
                                        <div class="form-group" >
                                            <label for="">Título de Pregunta</label>
                                            
                                            <textarea name="preguntaEnunciadoTD" id="summernote" class="form-control" rows="5" required="" placeholder="Escriba aqui el enunciado de su pregunta" style="display: none;">
                                            </textarea>
                                           
                                        </div>
                                    </div>
                                    <div class="col-2" >
                                        <div class="form-group">
                                            <label for="">Puntaje</label>
                                            <input type="number" name="puntajeTD" class="form-control" min="1" max="20" required="">
                                        </div>
                                        <div class="form-group">
                                            <label for="">Tipo</label>
                                            <input type="text" name="tipoPreg" id="tipoPreg" class="form-control form-control-sm" readonly="">
                                        </div>
                                    </div>
                                </div>
                                <div class="row justify-content-center">
                                    <div class="col-2 text-center">
                                        <span class="btn btn-default bg-teal" style="opacity: 0.9; display: block;" id="agregarOpcion" onclick="dibujarRespuesta()">Añadir Opción de
                                            Respuesta</span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <table class="table" id="detalle">
                                        </table>
                                    </div>
                                    <div class="col-12 text-center">
                                        <a href="#" class="btn btn-danger" onclick="cancelar()">Cancelar</a>
                                        <button type="submit" class="btn btn-primary">Guardar</button>
                                    </div>
                                </div>
                                
                            </div>
                         </div>
                    </form>
                                  
                    <div class="row mt-3">
                        <div class="col-12">
                            <div class="card">
                                @php $a=1; @endphp
                                @php($preguntas = RC::listarPreguntas($cuestionario->idCuestionario))    
                                
                                @foreach ($preguntas as $p)
                                <div class="card-header p-0 mt-2">
                                    <div class="row">
                                        <div class="col-md-9 col-10">
                                            <table>
                                                <tbody><tr>
                                                    <td><span class="badge badge-success m-2">{{$a}}</span></td>
                                                    <td><p>{!! $p->preguntaEnunciadoTD !!}</p></td>
                                                </tr>
                                            </tbody></table>
                                        </div>
                                        <div class="col-md-1 col-2 m-0">
                                            {{$p->puntajeTD}} Pts.
                                        </div>
                                        <div class="col-md-1 col-4 m-0">
                                            <form action="{{ route('destroy_pregunta', $p->idPregunta) }}" style="margin-bottom: 0px" method="POST">
                                                {!! csrf_field() !!}
                                                {!! method_field('DELETE') !!}
                                                <button class="btn btn-default btn-sm borrar3" title="Eliminar " data-nombre="<p></p>"><i class="fas fa-trash text-danger" aria-hidden="true"></i></button>
                                            </form>
                                        </div>
                                        <div class="col-md-1 col-4">
                                            <a href="{{ route('editar_pregunta', $p->idPregunta) }}" class="btn btn-default btn-sm">
                                                    <i class="far fa-edit text-info"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    @php($respuestas = RC::listarRespuestas($p->idPregunta))    
                                    @foreach($respuestas as $r)
                                    @php($f='far fa-square')
                                    @if($r->respuestaTD==1)
                                    @php($f='fas fa-check-square')
                                    @endif
                                    <p class="p-1" style="background: #e9e8e8">
                                        <i class="{{$f}} "></i>
                                        {{$r->opcionRespTD}}
                                    </p>
                                    @endforeach
                                </div>
                                @php($a++)
                                @endforeach
                                
                               
                            </div>
                            <div class="card-footer text-center">
                                <a href="{{ route('cuestionario_docente.index') . "?grupo=$grupo->idGrupo&nroModulo=$leccion->nroModulo" }}"
                                     class="btn btn-danger">Volver</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="timeline">
             
                    <table class="table">
                        
                        <thead class="bg-secondary">
                            <tr>
                                <th>#</th>
                                <th>Estudiante</th>
                                <th>Fecha Entrega</th>
                                <th style="text-align: center">Nota</th>
                                <th>Comentario</th>
                                <th colspan="2">Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php($con=1)
                            @if(count($respuesta)>0)
                            @foreach($respuesta as $re)
                            <tr>
                                <td>{{$con}}</td>
                                <td>
                                    <b>{{$re->nroDoc}}</b><br>{{$re->nomEst}}
                                </td>
                                <td>{{ date('d/m/y', strtotime($re->fechaEntrega)) . ' ' . date('h:i A', strtotime($re->fechaEntrega)) }}</td>
                                <td style="text-align:center;background:#f3fcff;"><b>{{$re->nota}}</b></td>
                                <td style="text-align:center;background:#f3fcff;">{{$re->comentario}}</td>
                                <td>
                                    <a class="btn btn-default btn-sm" href="#" onclick="return abrirModalEditR('{{$re->nota}}','{{$re->comentario}}','{{$re->idEstCuestionario}}')">
                                                    <i class="far fa-edit text-info"></i>
                                                </a>
                                </td>
                                <td>
                                    <form action="{{ route('estudiantecuestionario_destroy', $re->idEstCuestionario) }}"  style="margin-bottom: 0px" method="POST">
                                        {!! csrf_field() !!}
                                        {!! method_field('DELETE') !!}
                                        <button class="btn btn-default btn-sm" title="Eliminar">
                                            <i class="fas fa-trash text-danger" aria-hidden="true"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @php($con++)
                            @endforeach
                            @else
                            <tr>
                                <td colspan="7" class="text-danger text-center">No se encontraron registros.</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modal-revisar" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h5 class="modal-title" style="text-align: center; font-weight: bold">Revisar Cuestionario</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form action="{{route('act_cuestionarioest')}}" id="revisar" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <input type="hidden" name="idEstCuestionario" id="idEstCuestionario">
                        <input type="hidden" name="idCuestionario" id="idCuestionario"  value="{{$cuestionario->idCuestionario}}">
                            <div class="col-md-3 col-12">
                                <div class="form-group">
                                    <label for="">Nota</label>
                                    <input type="number" class="form-control" name="nota"  id="nota">
                                </div>
                            </div>
                        
                        <div class="col-md-9 col-12">
                            <div class="form-group">
                                <label for="">Comentario</label>
                                <textarea name="comentario" id="comentario"  rows="2" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Registrar</button>
                </div>
            </form>    
        </div>
    </div>
</div>
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
    let cont=0;
    let elementos=[];
    function opcionMultiple() {
        // Mostramos div
        let vistaNuevaPregunta = document.getElementById('vistaNuevaPregunta');
        vistaNuevaPregunta.style.display = "block";
        dibujarRespuesta('checkbox');
        dibujarRespuesta('checkbox');
        document.getElementById('tipoPreg').value = 'OPCION MÚLTIPLE';
        // Ocultamos el botón
        document.getElementById('agregar').style.display = "none";
    }

    function unicaRespuesta() {
        // Mostramos div
        let vistaNuevaPregunta = document.getElementById('vistaNuevaPregunta');
        vistaNuevaPregunta.style.display = "block";
        dibujarRespuesta("radio");
        dibujarRespuesta("radio");
        document.getElementById('tipoPreg').value = 'ÚNICA RESPUESTA';
        // Ocultamos el botón
        document.getElementById('agregar').style.display = "none";
    }

    function verdaderoFalso() {
        // Mostramos div
        let vistaNuevaPregunta = document.getElementById('vistaNuevaPregunta');
        vistaNuevaPregunta.style.display = "block";
        let fila = `<tr class="selected" id="fila_${cont}">
                            <td><input type="radio" class="form-control" name="respuestaTD[]" value="${cont}"></td>
                            <td>
                                <input type="hidden" name="enumerarTD[]" value="${cont}">
                                <input type="text" class="form-control" placeholder="Opción de respuesta" name="opcionRespTD[]" value="VERDADERO" readOnly>
                            </td>
                            <td align="center">
                                <button type="button" class="btn btn-default btn-sm" onclick="eliminarElemento(${cont});" disabled>
                                    <i class="fas fa-trash-alt text-danger"></i>
                                </button>
                            </td>
                    </tr>`;
        $('#detalle').append(fila);
        elementos.push(cont);
        cont++;
        let fila2 = `<tr class="selected" id="fila_${cont}">
                            <td><input type="radio" class="form-control" name="respuestaTD[]" value="${cont}"></td>
                            <td>
                                <input type="hidden" name="enumerarTD[]" value="${cont}">
                                <input type="text" class="form-control" placeholder="Opción de respuesta" name="opcionRespTD[]" value="FALSO" readOnly>
                            </td>
                            <td align="center">
                                <button type="button" class="btn btn-default btn-sm" onclick="eliminarElemento(${cont});" disabled>
                                    <i class="fas fa-trash-alt text-danger"></i>
                                </button>
                            </td>
                    </tr>`;
        $('#detalle').append(fila2);
        elementos.push(cont);
        cont++;
        document.getElementById('tipoPreg').value = 'VERDADERO O FALSO';
        document.getElementById('agregarOpcion').style.display = 'none';
        // Ocultamos el botón
        document.getElementById('agregar').style.display = "none";
        console.log(cont)
    }

    function dibujarRespuesta(tipo) {

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

    // Cancelar
    function cancelar() {
        // Borramos las opciones
        let cont2 = 0;
        let tamanio_array = elementos.length;
        while (cont2 < tamanio_array) {
            if (document.getElementById('fila_' + cont2)) {
                $("#fila_" + cont2).remove();
                console.log("encontre " + cont2)
                elementos.splice(cont2, 1);
            }
            cont2++;
        }
        cont = 0;
        document.getElementById('tipoPreg').value = "";
        document.getElementById('agregarOpcion').style.display = 'block';
        document.getElementById('vistaNuevaPregunta').style.display = 'none';
        document.getElementById('agregar').style.display = 'block';
    }

    function abrirModalEditR(nota,comentario,id){
        document.getElementById('idEstCuestionario').value = id;
        document.getElementById('nota').value = nota;
        document.getElementById('comentario').value = comentario;
        //$('#idGrupo_e').selectpicker('refresh');
        $("#modal-revisar").modal('show');

    }

</script>
@endpush