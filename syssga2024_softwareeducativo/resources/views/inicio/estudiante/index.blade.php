@extends('layouts.admin')
@section('contenido')
<div class="card">
    <div class="card-header">
        <h4>
            <b>Estudiante</b>
        </h4>

        <a class="btn btn-success btn-sm" href="" data-target="#modal-add" data-toggle="modal">
            <i class="fas fa-plus-circle" style="color: #cef5e1; margin-right: 10px"></i>Agregar
        </a>

    </div>
    <div class="card-body">
        @include('inicio.estudiante.search')
    </div>
</div>
@include('inicio.estudiante.create')

    <div class="row">

        <div class="col-md-12">
            <div class="card">
                <div class="card-body table-responsive p-0">
                    <table id="datatable" class="table table-hover table-sm text-nowrap">
                        <thead style="background: #0059D1; color: #ffffff;">
                            <tr>
                                <th>#</th>
                                <th></th>
                                <th>Nombres</th>
                                <th>N° Celular</th>
                                <th>Dirección</th>
                                <th>Correo</th>
                                <th>F. Nac.</th>
                                
                                <th colspan="3" style="text-align: center">Opciones</th>
                            </tr>
                        </thead>

                        <tbody>
                            @php($page = isset($_GET['page']) ? $_GET['page'] : 1)
                            @php($cont = (($page-1) * $paginate) + 1)
                            @foreach ($estudiante as $e)
                                <tr>
                                    <td>{{ $cont++ }}</td>
                                    <td> <span class="badge badge-defaut bg-{{$e->generoEst[0] == 'M' ? 'blue' : 'pink'}}">{{ $e->generoEst[0] }}</span> </td>
                                    <td><b>{{ $e->nroDoc }}</b> <br>{{ $e->nomEst }}</td>
                                    <td>{{ $e->telEst }}</td>
                                    <td>{{ $e->dirEst }}</td>
                                    <td>{{ $e->email }}</td>
                                    <td>{{ empty($e->f_nacimiento) ? '' : date('d/m/Y', strtotime($e->f_nacimiento)) }}</td>
                                    <td>
                                        <a href="{{route('estudiante.show', $e->idEstudiante)}}" class="btn btn-default btn-sm"><i class="far fa-thumbs-up"></i></a>
                                    </td>
                                    <td align="center">
                                        <a class="btn btn-default btn-sm"
                                            href="{{ route('estudiante.edit', $e->idEstudiante) }}">
                                            <i class="far fa-edit text-info" title="Editar {{ $e->nomEst }} "></i>
                                        </a>
                                    </td>
                                    <td align="center">
                                        <form action="{{ route('estudiante.destroy', $e->idEstudiante)  }}"
                                            method="POST">
                                            {!! csrf_field() !!}
                                            {!! method_field('DELETE') !!}
                                            <button class="btn btn-default borrar btn-sm"
                                                title="Eliminar {{ $e->nomEst }}" data-nombre="{{ $e->nomEst }}"><i
                                                    class="fa fa-trash text-danger" aria-hidden="true"></i></button>
                                        </form>
                                    </td>

                                </tr>
                       
                            @endforeach

                        </tbody>
                    </table>
                </div>
                {{ $estudiante->appends(['searchText' => $searchText]) }}
            </div>

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

           
        </script>
    @endpush

@endsection
