<div class="modal fade modal-slide-in-center" aria-hidden="true" role="dialog" tabindex="-1"
    id="modal-pago">

    <div class="modal-dialog" role="document">
        <form action="{{route('store_pago')}}" method="POST" id="formularioPago">
            @csrf
            <div class="modal-content">
                <div class="modal-header text-white" style="background: #0059D1;">
                    <h4 style="margin:0px">Nuevo Pago</h4>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <input type="hidden" name="idCredito" id="idCredito" value="{{ old('idCredito') }}">
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label>Fecha <span class="text-danger" title="Campo obligatorio">*</span> </label>
                                <div class="input-group">
                                    <input type="date" class="form-control form-control-sm" name="fechaPago"
                                        autocomplete="off" value="{{ old('fechaPago', $fecha) }}" max=""
                                        required>
                                </div>
                                {!! $errors->first('fechaPago', '<span class="help-block text-danger">:message</span>') !!}
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label>Fecha asiento<span class="text-danger" title="Campo obligatorio">*</span>
                                </label>
                                <div class="input-group">
                                    <input type="date" class="form-control form-control-sm" name="fechaAsiento"
                                        autocomplete="off" value="{{ $fecha }}" readonly>
                                </div>
                                {!! $errors->first('fechaAsiento', '<span class="help-block text-danger">:message</span>') !!}
                            </div>
                        </div>
                        <div class="col-md-4 col-6">
                            <div class="form-group">
                                <label for="">Tipo de comprobate</label>
                                <select 
                                required
                                name="idTipoDoc" id="idTipoDocModal"
                                    class="form-control form-control-sm">
                                    <option value="">Seleccione</option>
                                    @foreach ($tipos_doc as $tp)
                                        <option value="{{ $tp->idTipoDoc }}">{{ $tp->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4 col-6">
                            <div class="form-group">
                                <label for="">Serie</label>
                                <select 
                                    required 
                                    name="idSerieDoc" id="idSerieDocModal"
                                    class="form-control form-control-sm">
                                    <option value="">Seleccione</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4 col-6">
                            <div class="form-group">
                                <label for="">Correlativo</label>
                                <input type="text" name="correlativo" id="correlativoModal"
                                    class="form-control form-control-sm" readonly>
                            </div>
                        </div>
                        <div class="col-md-7 col-6">
                            <div class="form-group">
                                <label for="">Forma de pago</label>
                                <div class="input-group">
                                    <select name="idFormaPago" id="idFormaPago" class="form-control form-control-sm"
                                        required>
                                        <option value="">Seleccione forma de pago</option>
                                        @foreach ($formasPago as $f)
                                            <option value="{{ $f->idFormaPago }}"
                                                {{ $f->idFormaPago == old('idFormaPago') ? 'selected' : '' }}>
                                                {{ $f->nombreFP }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                {!! $errors->first('idFormaPago', '<span class="help-block text-danger">:message</span>') !!}
                            </div>
                        </div>
                        <div class="col-md-5 col-6">
                            <div class="form-group">
                                <label>Valor <span class="text-danger" title="Campo obligatorio">*</span> </label>
                                <div class="input-group">
                                    <input type="number"
                                        class="form-control form-control-sm {{ $errors->has('valorPagoC') ? 'is-invalid' : '' }}"
                                        name="valorPagoC" id="valorPagoC" placeholder="Ingrese el valor de Pago" autocomplete="off"
                                        value="{{ old('valorPagoC') }}" max="" required>
                                </div>
                                {!! $errors->first('valorPagoC', '<span class="help-block text-danger">:message</span>') !!}
                            </div>
                        </div>

                        <div class="col-12" id="bloque_nroDocEst">
                            <div class="form-group">
                                <label>Observaciones</label>
                                <div class="input-group">
                                    <textarea class="form-control" name="detallePago" rows="2">{{ old('detallePago') }}</textarea>
                                </div>
                                {!! $errors->first('detallePago', '<span class="help-block text-danger"><b>:message </b></span>') !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div style="margin: 0px auto 0px auto">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary" id="enviarPago">Guardar</button>
                    </div>
                </div>

            </div>
        </form>

    </div>
    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function() {
            const idTipoDocModal = document.getElementById('idTipoDocModal');
            const idSerieDocModal = document.getElementById('idSerieDocModal');

            idTipoDocModal.addEventListener('change', async function() {
                    //VACIAR EL SELECT
                    while (idSerieDocModal.firstChild) {
                        idSerieDocModal.removeChild(idSerieDocModal.firstChild);
                    }
                    const newSerie = document.createElement('option');
                    //obtener serie con fetch
                    await fetch(`/obtenerSeries/${idTipoDocModal.value}`)
                        .then(response => response.json())
                        .then(data => {
                            newSerie.value = "";
                            newSerie.textContent = "Seleccione";
                            idSerieDocModal.appendChild(newSerie);
                            data.series.forEach(function(serie) {
                                const newSerie = document.createElement('option');
                                newSerie.value = serie.nombre;
                                newSerie.textContent = serie.nombre;
                                idSerieDocModal.appendChild(newSerie);
                            });
                        })
                        .catch(error => console.log(error));
                })

                idSerieDocModal.addEventListener('change', async function() {
                //obtener correlativo con fetch
                await fetch(`/obtenerCorrelativo/${idSerieDocModal.value}`)
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('correlativoModal').value = data.ultimoNumero;
                    })
                  
            })
        })
    </script>
</div>