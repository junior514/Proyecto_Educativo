@extends('layouts.docente')
@section('contenido')
<div class="card">
    <div class="card-header">
        <h4>
            <b>Grupos</b>
        </h4>
       
    </div>
    <div class="card-body">
        @include('inicio.grupo_docente.search')
    </div>
</div>

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
                            </tr>
                        </thead>
                        @php($page = isset($_GET['page']) ? $_GET['page'] : 1)
                        @php($cont = ($page - 1) * $paginate + 1)
                        @foreach($grupos as $g)
                            <tr>
                                <td>{{ $cont++}}</td>
                                <td>
                                    <a href="{{route('grupo_docente.show', $g->idGrupo)}}">
                                        {{$g->nombreGrupo}}
                                    </a>
                                </td>
                                <td>{{$g->nomCur}}</td>
                                <td>{{$g->nomDoc}}</td>
                                <td>{{ date('d/m/Y H:i:s', strtotime($g->fechCreacionGru)) }}</td>
                               
                            </tr>
                        @endforeach
                    </table>
                    
                </div>
            </div>
           {{ $grupos->appends(['st' => $st]) }}
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
