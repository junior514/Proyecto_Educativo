<?php use App\Http\Controllers\EstudianteController as EC; ?>
@extends('layouts.admin')
@section('contenido')
    <div class="row mt-2">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>
                        <b>Cuotas a Pagar - </b>
                    </h4>
                    <div class="row justify-content-end">
                        <div class="col-md-8 col-12 text-right">
                            <h4>{{ $credito->nomEst }}</h4>
                            <h5>DNI: {{ $credito->nroDoc }}</h5>
                        </div>
                        <div class="col-md-2">
                            @php($nombre_fichero = public_path('cuotaPagar/' . $credito->fotoEst))
                            @if (file_exists($nombre_fichero) && !empty($credito->fotoEst))
                                <img src="{{ asset('estudiante/' . $credito->fotoEst) }}" id="img" width="100"
                                    height="100">
                            @else
                                <img src="{{ asset('estudiante/auxiliar_' . ($credito->generoEst == 'MASCULINO' ? 'hombre' : 'mujer') . '.png') }}"
                                    id="img" width="100" height="100">
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row justify-content-center">
                        <div class="col-9 text-right">
                            <a href="{{ route('create_credito', $credito->idMatricula) }}" class="btn btn-primary">Crear
                                Crédito</a>
                        </div>
                        <div class="col-md-10 col-12">
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-header pb-2 pt-2" style="background: #e7e7e7">
                                            <span style="font-size: 1.1em">{{ $credito->nomCur }}</span>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-4 col-6">
                                                    <div class="form-group row">
                                                        <label for="inputEmail3"
                                                            class="col-sm-5 col-form-label text-right">Pagaré:</label>
                                                        <div class="col-sm-7 col-form-label">
                                                            {{ $credito->idCredito }}
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="inputEmail3"
                                                            class="col-sm-5 col-form-label text-right">Observaciones:</label>
                                                        <div class="col-sm-7 col-form-label">
                                                            {{ $credito->observacionesCre }}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-6">
                                                    <div class="form-group row">
                                                        <label for="inputEmail3"
                                                            class="col-sm-5 col-form-label text-right">Fecha:</label>
                                                        <div class="col-sm-7 col-form-label">
                                                            {{ date('d/m/Y', strtotime($credito->fechaCre)) }}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-6">
                                                    <div class="form-group row">
                                                        <label for="inputEmail3"
                                                            class="col-sm-5 col-form-label text-right">Valor:</label>
                                                        <div class="col-sm-7 col-form-label">
                                                            S/{{ $credito->valorCre }}
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="inputEmail3"
                                                            class="col-sm-5 col-form-label text-right">Conceptos:</label>
                                                        <div class="col-sm-7 col-form-label">
                                                            <a href="" data-target="#modal-detalle-credito"
                                                                data-toggle="modal">
                                                                Ver detalle
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-footer text-center">
                                            @php($obtenerPagado = EC::obtenerPagado($credito->idCredito))
                                            <label for="">Total Pendiente</label><br>
                                            S/{{ number_format($credito->valorCre - $obtenerPagado, 2) }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-header pb-2 pt-2" style="background: #e7e7e7">
                                            <span style="font-size: 1.1em">Cuotas programadas</span>
                                        </div>
                                        <div class="card-body">
                                            <table class="table table-sm">
                                                <thead>
                                                    <tr>
                                                        <th style="text-align: center">Fecha Cuota</th>
                                                        <th style="text-align: right">Capital</th>
                                                        {{-- <th class="text-danger">Total cuota hoy</th> --}}
                                                        <th style="text-align: right">Pagado</th>
                                                        <th style="text-align: right">Pendiente</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php($total = 0)
                                                    @foreach ($cuotaPagar as $c)
                                                        <tr>
                                                            <td style="text-align: center">{{ date('d/m/Y', strtotime($c->fechAPagar)) }}</td>
                                                            <td style="text-align: right">S/{{ $c->montoAPagar }}</td>
                                                            {{-- <td></td> --}}
                                                            <td style="text-align: right">
                                                                S/{{ $obtenerPagado > $c->montoAPagar ? $c->montoAPagar : number_format($obtenerPagado, 2) }}
                                                            </td>
                                                            <td style="text-align: right">
                                                                @if($obtenerPagado >= $c->montoAPagar)
                                                                    PAGADO
                                                                @else
                                                                    @if ($c->fechAPagar < $fecha)
                                                                        <span class="text-danger" style="font-weight:bold">S/{{ number_format($c->montoAPagar - $obtenerPagado, 2) }}</span>
                                                                    @else
                                                                        <span>S/{{ number_format($c->montoAPagar - $obtenerPagado, 2) }}</span>
                                                                    @endif
                                                                @endif
                                                            </td>
                                                        </tr>
                                                        @if ($obtenerPagado > $c->montoAPagar)
                                                            @php($obtenerPagado -= $c->montoAPagar)
                                                        @else
                                                            @php($obtenerPagado = 0)
                                                        @endif
                                                    @endforeach
                                                </tbody>

                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-header pb-2 pt-2" style="background: #e7e7e7">
                                            <div style="float: right; font-size: 0.9em">
                                                <span onclick="crearPago()" style="color: rgb(66, 148, 219); cursor: pointer;"><i class="fa fa-plus-circle"></i>&nbsp;Agregar
                                                    abono</span>
                                            </div>
                                            <span style="font-size: 1.1em">Pagos realizados</span>
                                        </div>

                                        <div class="card-body">
                                            <table class="table table-sm">
                                                <thead>
                                                    <tr>
                                                        <th>N°</th>
                                                        <th>Asiento</th>
                                                        <th>Fecha</th>
                                                        <th>Detalle</th>
                                                        <th style="text-align: center">Importe</th>
                                                        <th>Opciones</th>
                                                    </tr>
                                                </thead>

                                                <tbody>
                                                    @php($cont = 1)

                                                    @foreach ($pagos as $p)
                                                        <tr>
                                                            <td>{{ $cont++ }}</td>
                                                            <td>{{ date('d/m/Y', strtotime($p->fechaAsiento)) }}</td>
                                                            <td>{{ date('d/m/Y', strtotime($p->fechaPago)) }}</td>
                                                            <td>{{ $p->detallePago }}</td>
                                                            <td style="text-align: right;">S/{{ $p->valorPago }}</td>
                                                            <td class="d-flex justify-content-center">
                                                                @if ($p->sunat_pdf != null && $p->sunat_estado != 2)
                                                                <div class="pr-2">
                                                                    <button
                                                                    onclick="crearCredito({{ $p->idPago }}, '{{ $p->tipoDoc }}', '{{ $p->serieComprobante }}', '{{ $p->numComprobante }}')" 
                                                                    class="btn btn-outline-danger btn-sm">Anular</button>
                                                                </div>
                                                                <div class="">
                                                                    <a href="{{$p->sunat_pdf}}" target="_blank" class="btn btn-outline-info btn-sm">PDF</a>
                                                                </div>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                        @php($total += $p->valorPago)
                                                    @endforeach

                                                </tbody>

                                            </table>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-header pb-2 pt-2" style="background: #e7e7e7">
                                            <div style="float: right; font-size: 0.9em">
                                                <a href="#" onclick="crearObservacion()"><i
                                                        class="fa fa-plus-circle"></i>&nbsp;Agregar
                                                    Observación</a>
                                            </div>
                                            <span style="font-size: 1.1em">Observaciones</span>
                                        </div>
                                        <div class="card-body table-responsive">
                                            <table class="table table-sm">
                                                <thead>
                                                    <tr>
                                                        <th>Fecha</th>
                                                        <th>Observaciones</th>
                                                        <th>Creado por</th>
                                                        <th colspan="2" style="text-align: center">Acciones</th>
                                                    </tr>
                                                </thead>
                                                @foreach ($observaciones as $o)
                                                    <tr>
                                                        <td>{{ date('d/m/Y', strtotime($o->fechaObs)) }}</td>
                                                        <td>{{ $o->detalleObs }}</td>
                                                        <td>{{ $o->name }}</td>
                                                        <td>
                                                            <button class="btn btn-default btn-sm" type="button"
                                                                onclick="editObservacion({{ $o->idObservacion }}, '{{ $o->fechaObs }}', '{{ $o->detalleObs }}')">
                                                                <i class="fas fa-pencil-alt"></i>
                                                            </button>
                                                        </td>
                                                        <td>
                                                            <form action="{{ route('destroy_observacion', $o->idObservacion) }}"
                                                                style="margin-bottom: 0px" method="POST">
                                                                {!! csrf_field() !!}
                                                                {!! method_field('DELETE') !!}
                                                                <button class="btn btn-default borrar2 btn-sm"
                                                                    title="Eliminar Observación"
                                                                    data-nombre="Observación"><i class="fas fa-trash"
                                                                        aria-hidden="true"></i></button>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="card-footer text-center">
                    <a href="{{ route('pagos_curso', $credito->idMatricula) }}" type="button"
                        class="btn btn-danger ">Volver</a>
                </div>
            </div>
        </div>
    </div>
    @include('inicio.estudiante.notacredito_create')
    @include('inicio.estudiante.credito_detalle')
    @include('inicio.estudiante.pago_create')
    @include('inicio.estudiante.credito_observacion')

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
                    const credito_modal = @json($credito->idCredito);
                    const pago = @json(old('valorPago'));
                    if (pago) {
                        $('#modal-pago-' + credito_modal).modal('show');
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
        <script>
            function crearCredito(idPago, tipDocAfectado, serieComprobante, numDocfectado) {
                document.getElementById('idPago').value = idPago;
                document.getElementById('tipDocAfectado').value = tipDocAfectado;
                document.getElementById('numDocfectado').value = `${serieComprobante}-${numDocfectado}`;
                $('#modal-credito').modal('show');
            }
            
            function crearPago() {
                document.getElementById('idCredito').value = @json($credito->idCredito);
                $('#modal-pago').modal('show');
            }

            document.querySelector('#formulario_observacion').addEventListener('submit', function(e) {
                e.preventDefault(); // Prevenir el envío del formulario

                var form = this;

                let myButton = document.getElementById('enviar');
                myButton.disabled = true;
                myButton.style.opacity = 0.7;
                myButton.textContent = 'Procesando ...';

                var fd = new FormData(form);
                let idObservacion = fd.get("idObservacion");
                let action = "";

                if (idObservacion === "") {
                    action = "{{ route('store_observacion') }}";
                    fd.append('_method', 'POST');
                } else {
                    action = "{{ route('update_observacion', ':id') }}";
                    action = action.replace(':id', idObservacion);

                    var methodInput = document.createElement('input');
                    methodInput.setAttribute('type', 'hidden');
                    methodInput.setAttribute('name', '_method');
                    methodInput.setAttribute('value', 'PUT');
                    form.appendChild(methodInput);
                }
                form.action = action;
                form.submit();
            });


            function crearObservacion() {
                let tituloObservacion = document.getElementById("tituloObservacion");
                tituloObservacion.innerHTML = "Crear Observación";
                document.getElementById("idObservacion").value = "";
                document.getElementById("detalleObs").value = "";
                $('#modal-observacion').modal('show');
            }

            function editObservacion(idObservacion, fechaObs, detalleObs) {
                let tituloObservacion = document.getElementById("tituloObservacion");
                document.getElementById("idObservacion").value = idObservacion;
                document.getElementById("fechaObs").value = fechaObs;
                document.getElementById("detalleObs").value = detalleObs;
                tituloObservacion.innerHTML = "Modificar Observación";
                $('#modal-observacion').modal('show');

            }

            document.querySelector('#formularioPago').addEventListener('submit', function(e) {
                    var form = this;
                    let valorPago = document.getElementById('valorPagoC').value;

                    e.preventDefault(); // <--- prevent form from submitting

                    Swal.fire({
                        title: '¿Confirmar recepción del monto correspondiente?',
                        text: `Se recibirá el monto correspondiente al valor de pago: S/ ${valorPago}`,
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
        </script>
    @endpush

@endsection
