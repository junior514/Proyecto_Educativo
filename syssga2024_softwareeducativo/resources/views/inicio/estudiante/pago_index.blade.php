<?php use App\Http\Controllers\EstudianteController as EC; ?>
@extends('layouts.admin')
@section('contenido')
    <div class="row mt-2">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>
                        <b>Cuotas a Pagar - {{ $matricula->nomCur }}</b>
                    </h4>
                    <div class="row justify-content-end">
                        <div class="col-md-8 col-12 text-right">
                            <h4>{{ $matricula->nomEst }}</h4>
                            <h5>DNI: {{ $matricula->nroDoc }}</h5>
                        </div>
                        <div class="col-md-2">
                            @php($nombre_fichero = public_path('matricula/' . $matricula->fotoEst))
                            @if (file_exists($nombre_fichero) && !empty($matricula->fotoEst))
                                <img src="{{ asset('estudiante/' . $matricula->fotoEst) }}" id="img" width="100"
                                    height="100">
                            @else
                                <img src="{{ asset('estudiante/auxiliar_' . ($matricula->generoEst == 'MASCULINO' ? 'hombre' : 'mujer') . '.png') }}"
                                    id="img" width="100" height="100">
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row justify-content-center">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="">Producto</label>
                                        <select name="idProducto" id="idProducto"
                                            class="form-control form-control-sm selectpicker" data-live-search="true">
                                            <option value="">Seleccione el producto</option>
                                            @foreach ($productos as $p)
                                                <option
                                                    value="{{ $p->idProducto }}_{{ $p->nombreProducto }}_{{ $p->precio }}">
                                                    {{ $p->nombreProducto }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <form action="{{ route('pagarProducto') }}" method="POST" id="form">
                        @csrf
                        <input type="hidden" name="idMatricula" value="{{ $matricula->idMatricula }}">
                        <div class="row justify-content-center">
                            <div class="col-md-9 col-12" id="concepto_head" style="display: none">
                                <table class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th>Concepto</th>
                                            <th>V. Unitario</th>
                                            <th>Cantidad</th>
                                            <th>Descuento</th>
                                            <th>Descontado</th>
                                            <th>Valor Total</th>
                                        </tr>
                                    </thead>
                                    <tbody id="concepto">

                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-8 col-12" id="divPago" style="display: none">
                                {{-- Para Facturación --}}
                                <div class="row">
                                    <div class="col-md-4 col-6">
                                        <div class="form-group">
                                            <label for="">Tipo de comprobate</label>
                                            <select 
                                            required
                                            name="idTipoDoc" id="idTipoDoc"
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
                                                name="idSerieDoc" id="idSerieDoc"
                                                class="form-control form-control-sm">
                                                <option value="">Seleccione</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-6">
                                        <div class="form-group">
                                            <label for="">Correlativo</label>
                                            <input type="text" name="correlativo" id="correlativo"
                                                class="form-control form-control-sm" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-6">
                                        <div class="form-group">
                                            <label for="">Forma de pago</label>
                                            <select name="idFormaPago" id="idFormaPago"
                                                class="form-control form-control-sm">
                                                <option value="">Seleccione forma de pago</option>
                                                @foreach ($formasPago as $f)
                                                    <option value="{{ $f->idFormaPago }}">{{ $f->nombreFP }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2 col-6">
                                        <div class="form-group">
                                            <label for="">Valor</label>
                                            <input type="text" name="valorPago" id="valorPago"
                                                class="form-control form-control-sm" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-11 align-self-center">
                                        <div class="form-group">
                                            <label for="">Observaciones</label>
                                            <input type="text" name="detallePago" class="form-control form-control-sm">
                                        </div>
                                    </div>
                                    <div class="col-md-1 col-11 align-self-center">
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary" id="enviar">Registrar Pago</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="row">

                        <div class="col-md-11 col-12">
                            <div class="card">
                                <div class="card-header pb-2 pt-2" style="background: #e7e7e7">

                                    <div style="float: right; font-size: 0.9em">
                                        <a href="{{ route('create_credito', $matricula->idMatricula) }}">
                                            <i class="fa fa-plus-circle"></i>&nbsp;Crear
                                            Crédito
                                        </a>
                                    </div>
                                    <span style="font-size: 1.1em">Créditos</span>
                                </div>
                                <div class="card-body">
                                    <table class="table table-sm">
                                        <thead>
                                            <tr>
                                                <th>N°</th>
                                                <th>Crédito</th>
                                                <th>N° Pagaré</th>
                                                <th>Fecha</th>
                                                <th style="text-align: right">Saldo total</th>
                                                <th style="text-align: center">Acciones</th>
                                            </tr>
                                        </thead>
                                        @php($cont = 1)
                                        @foreach ($creditos as $c)
                                            @php($saldo = EC::obtenerSaldo($c->idCredito))
                                            <tr>
                                                <td>{{ $cont++ }}</td>
                                                <td>
                                                    <a href="{{ route('show_pago', $c->idCredito) }}">Ver
                                                        detalle</a>
                                                </td>
                                                <td>{{ $c->idCredito }} ({{ EC::obtenerEstadoCredito($c->idCredito) }})</td>
                                                <td>{{ date('d/m/Y', strtotime($c->fechaCre)) }}</td>
                                                <td align="right">S/{{ number_format($saldo, 2) }}</td>
                                                <td style="text-align: center;">
                                                    @if ($saldo > 0)
                                                        <button type="button" class="btn btn-default btn-sm"
                                                            onclick="crearPago({{ $c->idCredito }})">
                                                            <i class="fas fa-dollar-sign text-success"></i>
                                                        </button>
                                                    @endif
                                                </td>

                                            </tr>
                                        @endforeach
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-11 col-12">
                            <div class="card">
                                <div class="card-header pb-2 pt-2" style="background: #e7e7e7">
                                    <span style="font-size: 1.1em">Pagos realizados</span>
                                </div>
                                <div class="card-body pt-0 pb-0">
                                    <table class="table table-sm">
                                        <thead>
                                            <tr>
                                                <th>N°</th>
                                                <th>Fecha</th>
                                                <th>Observaciones</th>
                                                <th style="text-align: right">Valor</th>
                                                <th style="text-align: right">Doc. Relacionado</th>
                                                <th style="text-align: center">Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($pagos as $p)
                                                <tr>
                                                    <td>{{ $p->idPago }}</td>
                                                    <td>{{ date('d/m/Y', strtotime($p->fechaPago)) }}</td>
                                                    <td>ABONO a Pagaré: {{ $p->idCredito }} {{ $p->detallePago }}</td>
                                                    <td style="text-align: right">S/{{ $p->valorPago }}</td>
                                                    <td style="text-align: right">{{ $p->serieComprobante }} - {{ $p->numComprobante }}</td>
                                                    <td class="d-flex justify-content-center">
                                                        @if ($p->sunat_pdf != null && $p->sunat_estado != 2)
                                                        <div class="">
                                                            <a href="{{$p->sunat_pdf}}" target="_blank" class="btn btn-outline-info btn-sm">PDF</a>
                                                            <button
                                                            onclick="crearCredito({{ $p->idPago }}, '{{ $p->tipoDoc }}', '{{ $p->serieComprobante }}', '{{ $p->numComprobante }}')"
                                                            title="Nota de crédito"
                                                            class="btn btn-outline-danger btn-sm">N.C.</button>
                                                        </div>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="card-footer text-center">
                    <a href="{{ route('estudiante.show', $matricula->idEstudiante) }}" type="button"
                        class="btn btn-danger ">Volver</a>
                </div>
            </div>
        </div>
    </div>
    @include('inicio.estudiante.pago_create')
    @include('inicio.estudiante.notacredito_create')

    @push('scripts')
        @if (count($errors) > 0)
            <script>
                $(document).ready(function() {
                    Snackbar.show({
                        text: 'Registre de forma correcta los campos.',
                        actionText: 'CERRAR',
                        pos: 'bottom-right',
                        duration: 5000
                    });
                    const pago = @json(old('valorPagoC'));
                    if (pago) {
                        $('#modal-pago').modal('show');
                    }

                });
            </script>
        @endif
        @if (Session::has('success'))
            <script type="text/javascript">
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
                Toast.fire({
                    icon: 'success',
                    title: '{{ Session::get('success') }}',
                    customClass: 'swal-pop',
                })
            </script>
        @elseif (Session::has('error'))
            <script type="text/javascript">
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
                Toast.fire({
                    icon: 'error',
                    title: '{{ Session::get('error') }}',
                    customClass: 'swal-pop',
                })
            </script>
        @endif
        <script type="text/javascript">
            function crearPago(idCredito) {
                document.getElementById('idCredito').value = idCredito;
                $('#modal-pago').modal('show');
            }

            function crearCredito(idPago, tipDocAfectado, serieComprobante, numDocfectado) {
                document.getElementById('idPago').value = idPago;
                document.getElementById('tipDocAfectado').value = tipDocAfectado;
                document.getElementById('numDocfectado').value = `${serieComprobante}-${numDocfectado}`;
                $('#modal-credito').modal('show');
            }

            function mostrar() {
                var archivo = document.getElementById("Imagen").files[0];
                var reader = new FileReader();
                if (archivo) {
                    reader.readAsDataURL(archivo);
                    reader.onloadend = function() {
                        document.getElementById("img").src = reader.result;
                        // document.getElementById("nombre_imagen").value = archivo.name;
                    }
                } else {
                    document.getElementById("img").src = "";
                    // document.getElementById("nombre_imagen").value = "";
                }
            }

            // Agregar Productos
            // Estructura de datos para almacenar los detalles de los productos
            const productosDetalles = [];

            // Función para calcular el valor total de una fila
            function calcularTotal(fila) {
                const cantidad = parseFloat(fila.querySelector('.cantidad').value);
                const precioUnitario = parseFloat(fila.querySelector('.precio-unitario').textContent);
                const descuento = parseFloat(fila.querySelector('.descuento').value);

                const descontado = precioUnitario * cantidad * (descuento / 100);
                const total = (precioUnitario * cantidad) - descontado;

                fila.querySelector('.descontado').textContent = descontado.toFixed(2);
                fila.querySelector('.total').textContent = total.toFixed(2);

                const inputValorDescontado = fila.querySelector('input[name="valorDescontado[]"]');
                inputValorDescontado.value = descontado.toFixed(2); // Asignar el valor calculado al input oculto

                const inputTotal = fila.querySelector('input[name="valorTotal[]"]');
                inputTotal.value = total.toFixed(2);
            }


            function actualizarVisibilidadDiv() {
                const divMostrarOcultar = document.getElementById('divPago');
                const concepto_head = document.getElementById('concepto_head');

                let idFormaPago = document.getElementById('idFormaPago');
                if (productosDetalles.length > 0) {
                    divMostrarOcultar.style.display = 'block';
                    concepto_head.style.display = 'block';
                    idFormaPago.required = true;
                } else {
                    divMostrarOcultar.style.display = 'none';
                    concepto_head.style.display = 'none';
                    idFormaPago.required = false;
                }
            }


            // Función para eliminar una fila
            function eliminarFila(fila) {
                const idProducto = fila.dataset.idProducto;
                console.log(idProducto)
                const index = productosDetalles.findIndex(detalle => parseInt(detalle.idProducto) === parseInt(idProducto));
                if (index !== -1) {
                    productosDetalles.splice(index, 1);
                }
                console.log(productosDetalles)
                fila.remove();
                actualizarTotales();
            }


            function productoYaAgregado(idProducto) {
                return productosDetalles.some(detalle => parseInt(detalle.idProducto) === parseInt(idProducto));
            }

            // Función para actualizar el valor total en todas las filas
            function actualizarTotales() {
                const filas = document.querySelectorAll('.concepto-fila');
                let totalGeneral = 0;

                filas.forEach(function(fila) {
                    calcularTotal(fila);
                    const totalFila = parseFloat(fila.querySelector('.total').textContent);
                    totalGeneral += totalFila;
                });
                document.getElementById('valorPago').value = totalGeneral.toFixed(2);
                actualizarVisibilidadDiv();
            }

            document.addEventListener('DOMContentLoaded', function() {
                const idTipoDoc = document.getElementById('idTipoDoc');
                const idSerieDoc = document.getElementById('idSerieDoc');
                const idProducto = document.getElementById('idProducto');
                const concepto = document.getElementById('concepto');
                const tiposDescuento =
                    @json($tiposDescuento); // Esto es un ejemplo, asegúrate de obtener los datos correctos

                idProducto.addEventListener('change', function() {
                    const selectedProduct = idProducto.value.split('_');
                    const selectedProductId = selectedProduct[0];

                    if (selectedProductId !== "" && !productoYaAgregado(selectedProductId)) {
                        const productInfo = {
                            nombreProducto: selectedProduct[1],
                            precioUnitario: selectedProduct[2]
                        }; // Aquí puedes obtener la información del producto según su ID

                        // Ejemplo: productInfo = getProductInfo(selectedProduct);

                        const newRow = document.createElement('tr');
                        newRow.className = 'concepto-fila';
                        newRow.dataset.idProducto =
                            selectedProductId; // Agregamos el ID del producto como atributo de datos
                        newRow.innerHTML = `
                            <td><input type="hidden" name="idProducto[]" value="${selectedProductId}">${productInfo.nombreProducto}</td>
                            <td class="precio-unitario"><input type="hidden" name="valorUnidad[]" value="${productInfo.precioUnitario}">${productInfo.precioUnitario}</td>
                            <td><input type="number" class="form-control cantidad" name="cantidad[]" value="1" min="1"></td>
                            <td>
                                <select name="descuento[]" class="form-control descuento">
                                    <option value="0">0%</option>
                                    <!-- Iterar a través de tiposDescuento para agregar las opciones -->
                                    ${tiposDescuento.map(descuento => `<option value="${descuento.valorPorcentaje}">${descuento.nombreTP}</option>`).join('')}
                                </select>
                            </td>
                            <td class="descontado">0.00</td>
                            <td class="total">${productInfo.precioUnitario}</td>
                            <td>
                                <input type="hidden" name="valorDescontado[]" value="0">
                                <input type="hidden" name="valorTotal[]" value="${productInfo.precioUnitario}"></td>
                                <button class="btn btn-sm btn-danger eliminar-fila">Eliminar</button>
                            </td>
                        `;

                        concepto.appendChild(newRow);
                        productosDetalles.push({
                            idProducto: selectedProductId,
                            nombreProducto: productInfo.nombreProducto,
                            precioUnitario: productInfo.precioUnitario
                        });
                        actualizarTotales();
                    }
                });

                idTipoDoc.addEventListener('change', async function() {
                    //VACIAR EL SELECT
                    while (idSerieDoc.firstChild) {
                        idSerieDoc.removeChild(idSerieDoc.firstChild);
                    }
                    const newSerie = document.createElement('option');
                    //obtener serie con fetch
                    await fetch(`/obtenerSeries/${idTipoDoc.value}`)
                        .then(response => response.json())
                        .then(data => {
                            newSerie.value = "";
                            newSerie.textContent = "Seleccione";
                            idSerieDoc.appendChild(newSerie);
                            data.series.forEach(function(serie) {
                                const newSerie = document.createElement('option');
                                newSerie.value = serie.nombre;
                                newSerie.textContent = serie.nombre;
                                idSerieDoc.appendChild(newSerie);
                            });
                        })
                        .catch(error => console.log(error));
                })

                idSerieDoc.addEventListener('change', async function() {
                    //obtener correlativo con fetch
                    await fetch(`/obtenerCorrelativo/${idSerieDoc.value}`)
                        .then(response => response.json())
                        .then(data => {
                            document.getElementById('correlativo').value = data.ultimoNumero;
                        })
                        .catch(error => console.log(error));
                })

                concepto.addEventListener('click', function(event) {
                    const target = event.target;
                    if (target.classList.contains('eliminar-fila')) {
                        const fila = target.closest('.concepto-fila');
                        eliminarFila(fila);
                    }
                });

                concepto.addEventListener('change', function(event) {
                    const target = event.target;
                    if (target.classList.contains('cantidad') || target.classList.contains('descuento')) {
                        const fila = target.closest('.concepto-fila');
                        calcularTotal(fila);
                        actualizarTotales();
                    }
                });

                // Para el formulario de los Pagos
                document.querySelector('#formularioPago').addEventListener('submit', function(e) {
                    let form = this;
                    let valorPagoC = document.getElementById('valorPagoC').value;
                    console.log(valorPagoC)

                    e.preventDefault(); // <--- prevent form from submitting

                    Swal.fire({
                        title: '¿Confirmar recepción del monto correspondiente?',
                        text: `Se recibirá el monto correspondiente al valor de pago: S/ ${valorPagoC}`,
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonText: 'Sí, confirmar',
                        cancelButtonText: 'Cancelar'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            let myButton = document.getElementById('enviarPago');
                            myButton.disabled = true;
                            myButton.style.opacity = 0.7;
                            myButton.textContent = 'Procesando ...';
                            form.submit();
                        }
                    });
                });

                // Para el formulario Oculto 

                document.querySelector('#form').addEventListener('submit', function(e) {
                    let form = this;
                    e.preventDefault();
                    const filas = document.querySelectorAll('.concepto-fila');
                    for (const fila of filas) {
                        const cantidadInput = fila.querySelector('.cantidad');
                        const cantidadValue = cantidadInput.value.trim();

                        if (cantidadValue === "") {
                            alert("El campo de cantidad no puede estar vacío en una de las filas");
                            return 0;
                        } else {
                            const cantidad = parseFloat(cantidadValue);
                            if (isNaN(cantidad)) {
                                alert("El valor en el campo de cantidad no es un número válido en una de las filas");
                                return 0;
                            }
                        }
                    }

                    let valorPago = document.getElementById('valorPago').value;
                    Swal.fire({
                        title: '¿Confirmar recepción del monto correspondiente?',
                        text: `Se recibirá el monto correspondiente al valor de pago: S/ ${valorPago}`,
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonText: 'Sí, confirmar',
                        cancelButtonText: 'Cancelar'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            let myButton = document.getElementById('enviar');
                            myButton.disabled = true;
                            myButton.style.opacity = 0.7;
                            myButton.textContent = 'Procesando ...';
                            form.submit();
                        }
                    });

                });

            });
        </script>
    @endpush
@endsection
