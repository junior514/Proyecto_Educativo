@extends('layouts.admin')
@section('contenido')
    <div class="card">
        <div class="card-header">
            <h4>
                <b>Grupos</b>
            </h4>
            <a class="btn btn-success btn-sm" href="" data-target="#modal-add" data-toggle="modal">
                <i class="fas fa-plus-circle" style="color: #cef5e1; margin-right: 10px"></i>Agregar
            </a>
        </div>
        <div class="card-body">
            @include('inicio.grupo.search')
        </div>
    </div>
    @include('inicio.grupo.create')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover table-sm text-nowrap">
                        <thead style="background: #0059D1; color: #ffffff;">
                            <tr>
                                <th>N°</th>
                                <th>Nombre del grupo</th>
                                <th>Curso</th>
                                <th>Docente</th>
                                <th>F. Creación</th>
                                <!-- <th>Estado</th> -->
                                <th colspan="2" style="text-align: center">Opciones</th>
                            </tr>
                        </thead>
                        @php($page = isset($_GET['page']) ? $_GET['page'] : 1)
                        @php($cont = ($page - 1) * $paginate + 1)
                        @foreach ($grupos as $g)
                            <tr>
                                <td>{{ $cont++ }}</td>
                                <td>
                                    <a href="{{ route('grupo.show', $g->idGrupo) }}">
                                        {{ $g->nombreGrupo }}
                                    </a>
                                </td>
                                <td>{{ $g->nomCur }}</td>
                                <td>{{ $g->nomDoc }}</td>
                                <td>{{ date('d/m/Y H:i:s', strtotime($g->fechCreacionGru)) }}</td>
                                <!-- <td><span class="badge badge-success"> {{ $g->estadoCur }} </span></td> -->
                               
                                <td align="center">
                                    <a class="btn btn-default btn-sm" href="{{ route('grupo.edit', $g->idGrupo) }}">
                                        <i class="far fa-edit text-info" title="Editar {{ $g->nombreGrupo }} "></i>
                                    </a>
                                </td>
                                <td align="center">
                                    <form action="{{ route('grupo.destroy', $g->idGrupo) }}" method="POST">
                                        {!! csrf_field() !!}
                                        {!! method_field('DELETE') !!}
                                        <button class="btn btn-default borrar btn-sm"
                                            title="Eliminar {{ $g->nombreGrupo }}" data-nombre="{{ $g->nombreGrupo }}"><i
                                                class="fa fa-trash text-danger" aria-hidden="true"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </table>

                </div>
            </div>
            {{ $grupos->appends(['st' => $st, 'st2' => $st2]) }}
        </div>
        <h2 class="float-right"><a href="{{ url('export-excel-csv-file/xlsx') }}" class="btn btn-success mr-1">Exportar
                Movimientos del día Excel</a></h2>
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
