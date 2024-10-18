<div class="modal fade modal-slide-in-center" aria-hidden="true" role="dialog" tabindex="-1"
    id="modal-credito">

    <div class="modal-dialog" role="document">
        <form action="{{route('store_notacredito')}}" method="POST" id="formularioPago">
            @csrf
            <div class="modal-content">
                <div class="modal-header text-white" style="background: #0059D1;">
                    <h4 style="margin:0px">Nuevo nota de crédito</h4>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <input type="hidden" name="idPago" id="idPago" value="{{ old('idPago') }}">
                        <input type="hidden" name="tipDocAfectado" id="tipDocAfectado" value="{{ old('tipDocAfectado') }}">
                        <input type="hidden" name="numDocfectado" id="numDocfectado" value="{{ old('numDocfectado') }}">
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
                                <label for="">Tipo de doc</label>
                                <select 
                                required
                                name="idTipoDoc" id="idTipoDocCredito"
                                    class="form-control form-control-sm">
                                    <option value="">Seleccione</option>
                                    @foreach ($tipos_docCredito as $tp)
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
                                    name="idSerieDoc" id="idSerieDocCredito"
                                    class="form-control form-control-sm">
                                    <option value="">Seleccione</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4 col-6">
                            <div class="form-group">
                                <label for="">Correlativo</label>
                                <input type="text" name="correlativo" id="correlativoCredito"
                                    class="form-control form-control-sm" readonly>
                            </div>
                        </div>
                        <div class="col-12" id="bloque_nroDocEst">
                            <div class="form-group">
                                <label>Justificación</label>
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
            const idTipoDocCredito = document.getElementById('idTipoDocCredito');
            const idSerieDocCredito = document.getElementById('idSerieDocCredito');

            idTipoDocCredito.addEventListener('change', async function() {
                    //VACIAR EL SELECT
                    while (idSerieDocCredito.firstChild) {
                        idSerieDocCredito.removeChild(idSerieDocCredito.firstChild);
                    }
                    const newSerie = document.createElement('option');
                    //obtener serie con fetch
                    await fetch(`/obtenerSeries/${idTipoDocCredito.value}`)
                        .then(response => response.json())
                        .then(data => {
                            newSerie.value = "";
                            newSerie.textContent = "Seleccione";
                            idSerieDocCredito.appendChild(newSerie);
                            data.series.forEach(function(serie) {
                                const newSerie = document.createElement('option');
                                newSerie.value = serie.nombre;
                                newSerie.textContent = serie.nombre;
                                idSerieDocCredito.appendChild(newSerie);
                            });
                        })
                        .catch(error => console.log(error));
                })

                idSerieDocCredito.addEventListener('change', async function() {
                //obtener correlativo con fetch
                await fetch(`/obtenerCorrelativo/${idSerieDocCredito.value}`)
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('correlativoCredito').value = data.ultimoNumero;
                    })
                  
            })
        })
    </script>
</div>
