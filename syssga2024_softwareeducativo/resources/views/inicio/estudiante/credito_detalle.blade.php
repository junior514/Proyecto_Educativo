<div class="modal fade modal-slide-in-center" aria-hidden="true" role="dialog" tabindex="-1" id="modal-detalle-credito">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header text-white" style="background: #36679e">
                <h5>Conceptos relacionados</h5>
                <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        
            <div class="modal-body">
                <div class="row">
                   <div class="col-12 table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Concepto</th>
                                    <th style="text-align: center">Valor Unidad</th>
                                    <th style="text-align: center">Cantidad</th>
                                    <th style="text-align: center">Descuento</th>
                                    <th style="text-align: center">Valor Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($credito_detalle as $cd)
                                    <tr>
                                        <td>{{$cd->nombreProducto}}</td>
                                        <td style="text-align: right">S/{{$cd->valorUnidad}}</td>
                                        <td style="text-align: center">{{$cd->cantidad}}</td>
                                        <td style="text-align: right">S/{{$cd->valorDescontado}}</td>
                                        <td style="text-align: right">S/{{$cd->valorTotal}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                   </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>           
            </div>
         
        </div>
    </div>
</div>