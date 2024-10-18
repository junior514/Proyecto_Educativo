@extends('layouts.admin')
@section('contenido')
<div class="card">
    <div class="card-header">
        <h4>
            <b>Cursos</b>
        </h4>
        <a class="btn btn-success btn-sm" href="" data-target="#modal-add" data-toggle="modal">
            <i class="fas fa-plus-circle" style="color: #cef5e1; margin-right: 10px"></i>Agregar
        </a>
    </div>
    <div class="card-body">
        @include('mantenimiento.curso.search')
    </div>
</div>
@include('mantenimiento.curso.create')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover table-sm text-nowrap">
                        <thead style="background: #0059D1; color: #ffffff;">
                            <tr>
                                <th>N°</th>
                                <th>Curso</th>
                                {{-- <th>Estado</th> --}}
                                <th colspan="2" style="text-align: center"></th>
                            </tr>
                        </thead>
                        @php($page = isset($_GET['page']) ? $_GET['page'] : 1)
                        @php($cont = ($page - 1) * $paginate + 1)
                        @foreach($cursos as $c)
                            <tr>
                                <td>{{ $cont++}}</td>
                                <td>{{$c->nomCur}}</td>
                                {{-- <td><span class="badge badge-success"> {{ $c->estadoCur }} </span></td> --}}
                                 <td align="center">
                                        <a class="btn btn-default btn-sm"
                                            href="{{ route('curso.edit', $c->idCurso) }}">
                                            <i class="far fa-edit text-info" title="Editar {{ $c->nomCur }} "></i>
                                        </a>
                                    </td>
                                    <td align="center">
                                        <form action="{{ route('curso.destroy', $c->idCurso)  }}"
                                            method="POST">
                                            {!! csrf_field() !!}
                                            {!! method_field('DELETE') !!}
                                            <button class="btn btn-default borrar btn-sm"
                                                title="Eliminar {{ $c->nomCur }}" data-nombre="{{ $c->nomCur }}"><i
                                                    class="fa fa-trash text-danger" aria-hidden="true"></i></button>
                                        </form>
                                    </td>
                            </tr>
                        @endforeach
                    </table>
                    
                </div>
            </div>
           {{ $cursos->appends(['st' => $st]) }}
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
