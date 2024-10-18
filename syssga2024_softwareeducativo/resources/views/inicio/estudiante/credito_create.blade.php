<?php use App\Http\Controllers\EstudianteController as EC; ?>
@extends('layouts.admin')
@section('contenido')
    <div class="row mt-2">
        <div class="col-md-12">
            <form action="{{ route('store_credito') }}" method="POST" id="form">
                @csrf
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
                                    <img src="{{ asset('estudiante/' . $matricula->fotoEst) }}" id="img"
                                        width="100" height="100">
                                @else
                                    <img src="{{ asset('estudiante/auxiliar_' . ($matricula->generoEst == 'MASCULINO' ? 'hombre' : 'mujer') . '.png') }}"
                                        id="img" width="100" height="100">
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="card-body">

                        <div class="row justify-content-center">
                            <div class="col-md-9 col-12">
                                <div class="card">
                                    <div class="card-header pb-1 pt-1" style="background: #e7e7e7">
                                        <span style="font-size: 1.1em">Selección de productos</span>
                                    </div>
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
                                        <div class="row">
                                            <div class="col-12" id="concepto_head" style="display: none">
                                                <table class="table table-sm">
                                                    <thead>
                                                        <tr>
                                                            <th>Concepto</th>
                                                            <th>V. Unitario</th>
                                                            <th>Cantidad</th>
                                                            <th>Descuento</th>
                                                            <th style="text-align: right">Descontado</th>
                                                            <th style="text-align: right">Valor Total</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="concepto">

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="idMatricula" value="{{ $matricula->idMatricula }}">
                        <div class="row justify-content-center">
                            <div class="col-md-9 col-12">
                                <div class="card">
                                    <div class="card-header pb-1 pt-1" style="background: #e7e7e7">
                                        <span style="font-size: 1.1em">Configuración del crédito</span>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-3 col-6">
                                                <div class="form-group">
                                                    <label for="">Pagare <span class="text-danger">*</span> </label>
                                                    <input type="text" class="form-control form-control-sm"
                                                        value="{{ $nroPagare }}" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-6">
                                                <div class="form-group">
                                                    <label for="">Valor</label>
                                                    <input type="text" name="valorPago" id="valorPago" value="0"
                                                        class="form-control form-control-sm" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-6" style="display: none">
                                                <div class="form-group">
                                                    <label for="">Pago Anticipado </label>
                                                    <input type="text" name="pagoAnticipado" id="pagoAnticipado"
                                                        class="form-control form-control-sm decimales"
                                                        value="{{ old('pagoAnticipado', 0) }}">
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-6">
                                                <div class="form-group">
                                                    <label for="">Fecha primera cuota <span
                                                            class="text-danger">*</span> </label>
                                                    <input type="date" name="fechaPrimCuota" id="fechaPrimCuota"
                                                        class="form-control form-control-sm"
                                                        value="{{ old('fechaPrimCuota', $fecha) }}" required>
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-6">
                                                <div class="form-group">
                                                    <label for="">Periodicidad cuotas <span
                                                            class="text-danger">*</span> </label>
                                                    <select name="periodoCuotas" id="periodoCuotas"
                                                        class="form-control form-control-sm" required>
                                                        @foreach ($periodoCuotas as $p)
                                                            <option value="{{ $p }}"
                                                                {{ $p == old('periodoCuotas') ? 'selected' : '' }}>
                                                                {{ $p }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-6">
                                                <div class="form-group">
                                                    <label for="">Número cuotas <span class="text-danger">*</span>
                                                    </label>
                                                    <input type="text" name="nroCuotas" id="nroCuotas"
                                                        class="form-control form-control-sm"
                                                        value="{{ old('nroCuotas', 5) }}" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="">Observaciones </label>
                                                    <textarea name="observacionesCre" rows="3" class="form-control form-control-sm">{{ old('observacionesCre') }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="card">
                                    <div class="card-header pb-1 pt-1" style="background: #e7e7e7">
                                        <span style="font-size: 1.1em">Cuotas programadas</span>
                                    </div>
                                    <div class="card-body pb-0 pt-1">
                                        <table id="cuotasTable" class="table table-sm">
                                            <thead>
                                                <tr>
                                                    <th>N°</th>
                                                    <th style="text-align: center">Fecha</th>
                                                    <th style="text-align: right">Capital</th>
                                                    <th style="text-align: right">Cuota</th>
                                                    <th style="text-align: center">Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <!-- Aquí se generarán las filas de cuotas dinámicamente -->
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="card-footer text-center">
                        <a href="{{ route('pagos_curso', $matricula->idMatricula) }}" type="button"
                            class="btn btn-danger ">Volver</a>
                        <button type="submit" class="btn btn-primary" id="enviar">Aceptar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    @include('inicio.estudiante.cuota_edit')

    @push('scripts')
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

            let cuotasData = [];

            function crearCuotas() {
                cuotasData = [];
                let valorPago = parseFloat(document.getElementById('valorPago').value);
                let fechaPrimCuota = document.getElementById('fechaPrimCuota').value + "T00:00:00-05:00";
                fechaPrimCuota = new Date(fechaPrimCuota);
                const periodoCuotas = document.getElementById('periodoCuotas').value;
                const nroCuotas = parseInt(document.getElementById('nroCuotas').value);

                const pagoAnticipado = parseFloat(document.getElementById('pagoAnticipado').value);

                // Añadimos la cuota del pago anticipado
                if (pagoAnticipado !== 0) {

                    cuotasData.push({
                        numero: 0,
                        fecha: new Date(fechaPrimCuota),
                        capital: valorPago,
                        cuota: pagoAnticipado
                    });

                }
                const montoCuota = (valorPago - pagoAnticipado) / nroCuotas;
                valorPago = valorPago - pagoAnticipado;


                for (let i = 0; i < nroCuotas; i++) {
                    const cuota = {
                        numero: i + 1,
                        fecha: new Date(fechaPrimCuota),
                        capital: valorPago - montoCuota * i,
                        cuota: montoCuota
                    };
                    cuotasData.push(cuota);

                    if (periodoCuotas === 'Mensual') {
                        cuota.fecha.setMonth(cuota.fecha.getMonth() + i); // Incrementar meses
                    } else if (periodoCuotas === 'Quincenal') {
                        cuota.fecha.setDate(cuota.fecha.getDate() + 15 * i); // Incrementar días
                    } else if (periodoCuotas === 'Semanal') {
                        cuota.fecha.setDate(cuota.fecha.getDate() + 7 * i); // Incrementar días
                    }
                }

                dibujarCuotas();
            }

            function dibujarCuotas() {
                const tbody = document.querySelector('#cuotasTable tbody');
                tbody.innerHTML = '';

                cuotasData.forEach(cuota => {
                    const row = document.createElement('tr');

                    // Formatea la fecha usando Moment.js
                    let formattedDate = moment(cuota.fecha).format('YYYY-MM-DD');
                    let formatoPresentarFecha = moment(cuota.fecha).format('DD/MM/YYYY');

                    row.innerHTML = `
                            <td>${cuota.numero}</td>
                            <td style="text-align:center"><input type="hidden" name="fechAPagar[]" value="${formattedDate}">${formatoPresentarFecha}</td>
                            <td style="text-align:right">S/${cuota.capital.toFixed(2)}</td>
                            <td style="text-align:right"><input type="hidden" name="montoAPagar[]" value="${cuota.cuota.toFixed(2)}">S/${cuota.cuota.toFixed(2)}</td>
                            <td style="text-align:center"><button class="editar-btn btn btn-sm btn-default" type="button" data-numero="${cuota.numero}" data-fecha="${formattedDate}" data-valor="${cuota.cuota.toFixed(2)}"><i class="fas fa-pencil-alt"></i></button></td>
                        `;
                    tbody.appendChild(row);
                });

                // Manejar la edición de cuotas
                const editarButtons = document.querySelectorAll('.editar-btn');
                editarButtons.forEach(button => {
                    button.addEventListener('click', () => {
                        const numero = parseInt(button.getAttribute('data-numero'));
                        const fecha = button.getAttribute('data-fecha');
                        const valor = parseFloat(button.getAttribute('data-valor'));
                        document.getElementById('nroCuota').value = numero;
                        document.getElementById('fechaCuota').value = fecha;
                        document.getElementById('valorCuota').value = valor;
                        if (numero == 0) {
                            document.getElementById('valorCuota').setAttribute('readonly', 'readonly');
                        } else {
                            document.getElementById('valorCuota').removeAttribute('readonly');
                        }
                        $('#modal-cuota').modal('show');

                    });
                });

            }


            function actualizarCuota(numero, nuevoValor) {
                console.log(numero)
                const cuotaActual = cuotasData.find(cuota => cuota.numero === numero);

                if (cuotaActual) {
                    const diferencia = nuevoValor - cuotaActual.cuota;
                    cuotaActual.cuota = nuevoValor;

                    // Redistribuir la diferencia entre las cuotas restantes
                    const cuotasRestantes = cuotasData.slice(cuotaActual.numero);
                    console.log(cuotasRestantes)
                    const cantidadCuotasRestantes = cuotasRestantes.length;

                    if (cantidadCuotasRestantes > 0) {

                        // const distribucion = diferencia / cantidadCuotasRestantes;
                        const distribucion = diferencia / cantidadCuotasRestantes;


                        let capitalRestante = cuotaActual.capital - nuevoValor;
                        console.log(capitalRestante)
                        cuotasRestantes.forEach(cuota => {
                            cuota.cuota -= distribucion;
                            cuota.capital = capitalRestante;
                            capitalRestante -= cuota.cuota;
                        });

                    }
                    dibujarCuotas(); // Vuelve a dibujar la tabla de cuotas
                    $('#modal-cuota').modal('hide'); // Cierra el modal de edición
                }
            }




            document.querySelector('#modal-cuota .btn-primary').addEventListener('click', () => {
                const numeroCuota = parseInt(document.getElementById('nroCuota').value);
                const fechaCuota = document.getElementById('fechaCuota').value;
                const valorCuota = parseFloat(document.getElementById('valorCuota').value);

                cuotasData[numeroCuota - 1].fecha = new Date(fechaCuota + 'T00:00:00-05:00');
                // cuotasData[numeroCuota - 1].cuota = valorCuota;
                actualizarCuota(numeroCuota, valorCuota);
                // dibujarCuotas();
                // $("#modal-cuota").modal('hide');

            });


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
                const concepto_head = document.getElementById('concepto_head');


                if (productosDetalles.length > 0) {

                    concepto_head.style.display = 'block';

                } else {
                    concepto_head.style.display = 'none';

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
                crearCuotas();

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
                            <td style="text-align:right" class="descontado">0.00</td>
                            <td style="text-align:right" class="total">${productInfo.precioUnitario}</td>
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
                        crearCuotas();
                    }
                });

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
                        crearCuotas();
                    }
                });


                const pagoAnticipadoElement = document.getElementById('pagoAnticipado');
                pagoAnticipadoElement.addEventListener('blur', function(event) {

                    crearCuotas();
                });

                // ------------------------------------------------------------------------------------------------------------------------

                crearCuotas();

                document.getElementById('nroCuotas').addEventListener('change', crearCuotas);
                document.getElementById('fechaPrimCuota').addEventListener('change', crearCuotas);
                document.getElementById('periodoCuotas').addEventListener('change', crearCuotas);

                // Para el formulario
                document.querySelector('#form').addEventListener('submit', function(e) {
                    var form = this;
                    let valorPago = parseFloat(document.getElementById('valorPago').value);

                    e.preventDefault(); // <--- prevent form from submitting

                    console.log(typeof(valorPago))
                    if (valorPago  === 0) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Advertencia',
                            text: 'No se puede continuar si el valor de crédito es 0.',
                        });
                        return 0;
                    }

                    Swal.fire({
                        // title: '¿Confirmar recepción del monto correspondiente?',
                        html: `<h5 style="font-weight:bold">¡Confirmar datos del crédito!</h5><br>
                            <table class="table table-sm">
                                <tr>
                                    <td style="text-align: right; font-weight: bold; width:50%">Valor Crédito: </td>
                                    <td>S/${valorPago.toFixed(2)}</td>
                                </tr>
                                <tr>
                                    <td style="text-align: right; font-weight: bold">N° Cuotas: </td>
                                    <td>${document.getElementById('nroCuotas').value}</td>
                                </tr>
                            </table>
                            No podrá revertir esta acción, ¿Desea continuar?`,
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
