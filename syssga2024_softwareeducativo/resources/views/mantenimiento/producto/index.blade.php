@extends('layouts.admin')
@section('contenido')
<div class="card">
    <div class="card-header">
        <h4>
            <b>Productos</b>
        </h4>
        <a class="btn btn-success btn-sm" href="" data-target="#modal-add" data-toggle="modal">
            <i class="fas fa-plus-circle" style="color: #cef5e1; margin-right: 10px"></i>Agregar
        </a>
    </div>
    <div class="card-body">
        @include('mantenimiento.producto.search')
    </div>
</div>
@include('mantenimiento.producto.create')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover table-sm text-nowrap">
                        <thead style="background: #0059D1; color: #ffffff;">
                            <tr>
                                <th>N°</th>
                                <th>Producto</th>
                                <th>Precio</th>
                                <th colspan="2" style="text-align:center">Opciones</th>
                            </tr>
                        </thead>
                        @php($page = isset($_GET['page']) ? $_GET['page'] : 1)
                        @php($cont = ($page - 1) * $paginate + 1)
                        @foreach($productos as $p)
                            <tr>
                                <td>{{ $cont++}}</td>
                                <td>{{$p->nombreProducto}}</td>
                                <td>{{$p->precio}}</td>
                                 <td align="center">
                                        <a class="btn btn-default btn-sm"
                                            href="{{ route('producto.edit', $p->idProducto) }}">
                                            <i class="far fa-edit text-info" title="Editar {{ $p->nombreProducto }} "></i>
                                        </a>
                                    </td>
                                    <td align="center">
                                        <form action="{{ route('producto.destroy', $p->idProducto)  }}"
                                            method="POST">
                                            {!! csrf_field() !!}
                                            {!! method_field('DELETE') !!}
                                            <button class="btn btn-default borrar btn-sm"
                                                title="Eliminar {{ $p->nombreProducto }}" data-nombre="{{ $p->nombreProducto }}"><i
                                                    class="fa fa-trash text-danger" aria-hidden="true"></i></button>
                                        </form>
                                    </td>
                            </tr>
                        @endforeach
                    </table>
                    
                </div>
            </div>
           {{ $productos->appends(['st' => $st]) }}
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
