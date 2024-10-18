<div class="modal fade modal-slide-in-center" aria-hidden="true" role="dialog" tabindex="-1" id="modal-desglose-{{$e->idModulo}}">

    <div class="modal-dialog" role="document">
        <form action="{{ route('cargaSubNota', $e->idModulo) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="modal-content">
                <div class="modal-header text-white" style="background: #0059D1;">
                    <h4 style="margin:0px" id="lblnota_{{$e->idModulo}}">Nota 1</h4>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="card-body">
                    <input type="hidden" value="" name="nota" id="nota_{{$e->idModulo}}">
                    {{-- @php
           
                        $data1 = json_decode($e->nota1, true);

                        if ($data !== null) {
                            $nota1 = $data["subNota1"];
                            echo $nota1;
                        }
                    @endphp --}}
                    <div class="row">
                        <div class="col-md-4 col-12">
                            <div class="form-group">
                                <label>Sub Nota 1 <span class="text-danger" title="Campo obligatorio">*</span> </label>
                                <div class="input-group">
                                    <input type="number" class="form-control form-control-sm" name="subNota1" id="subNota1_{{$e->idModulo}}"
                                        autocomplete="off" required>
                                </div>
                                {!! $errors->first('subNota1', '<span class="help-block text-danger"><b>:message </b></span>') !!}
                            </div>
                        </div>
                        <div class="col-md-4 col-12">
                            <div class="form-group">
                                <label>Sub Nota 2 <span class="text-danger" title="Campo obligatorio">*</span> </label>
                                <div class="input-group">
                                    <input type="number" class="form-control form-control-sm" name="subNota2" id="subNota2_{{$e->idModulo}}"
                                        autocomplete="off" required>
                                </div>
                                {!! $errors->first('subNota1', '<span class="help-block text-danger"><b>:message </b></span>') !!}
                            </div>
                        </div>
                        <div class="col-md-4 col-12">
                            <div class="form-group">
                                <label>Sub Nota 3 <span class="text-danger" title="Campo obligatorio">*</span> </label>
                                <div class="input-group">
                                    <input type="number" class="form-control form-control-sm" name="subNota3" id="subNota3_{{$e->idModulo}}"
                                        autocomplete="off" required>
                                </div>
                                {!! $errors->first('subNota1', '<span class="help-block text-danger"><b>:message </b></span>') !!}
                            </div>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <div style="margin: 0px auto 0px auto">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-primary">Guardar</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

</div>
