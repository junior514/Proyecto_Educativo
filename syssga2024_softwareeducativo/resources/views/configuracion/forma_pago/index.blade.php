@extends('layouts.admin')
@section('contenido')
<div class="card">
    <div class="card-header">
        <h4>
            <b>Formas de Pago</b>
        </h4>
        <a class="btn btn-success btn-sm" href="" data-target="#modal-add" data-toggle="modal">
            <i class="fas fa-plus-circle" style="color: #cef5e1; margin-right: 10px"></i>Agregar
        </a>
    </div>
    <div class="card-body">
        @include('configuracion.forma_pago.search')
    </div>
</div>
@include('configuracion.forma_pago.create')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover table-sm text-nowrap">
                        <thead style="background: #0059D1; color: #ffffff;">
                            <tr>
                                <th>N°</th>
                                <th>Nombre de Forma de Pago</th>
                                <th colspan="2" style="text-align:center">Opciones</th>
                            </tr>
                        </thead>
                        @php
                            $page = isset($_GET['page']) ? $_GET['page'] : 1;
                            $cont = ($page - 1) * $paginate + 1;
                        @endphp
                        @foreach($formasPago as $formaPago)
                            <tr>
                                <td>{{ $cont++ }}</td>
                                <td>{{ $formaPago->nombreFP }}</td>
                                <td align="center">
                                    <a class="btn btn-default btn-sm"
                                        href="{{ route('forma_pago.edit', $formaPago->idFormaPago) }}">
                                        <i class="far fa-edit text-info" title="Editar {{ $formaPago->nombreFP }}"></i>
                                    </a>
                                </td>
                                <td align="center">
                                    <form action="{{ route('forma_pago.destroy', $formaPago->idFormaPago) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-default borrar btn-sm"
                                            title="Eliminar {{ $formaPago->nombreFP }}" data-nombre="{{ $formaPago->nombreFP }}">
                                            <i class="fa fa-trash text-danger" aria-hidden="true"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                    
                    
                </div>
            </div>
           {{ $formasPago->appends(['st' => $st]) }}
        </div>
    </div>


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

        @if (count($errors) > 0)
            <script>
                $(document).ready(function() {
                    Snackbar.show({
                        text: 'Registre de forma correcta los campos.',
                        actionText: 'CERRAR',
                        pos: 'bottom-right',
                        duration: 5000
                    });
                    $('#modal-add').modal('show');
                });
            </script>
        @endif
    @endpush
@endsection
