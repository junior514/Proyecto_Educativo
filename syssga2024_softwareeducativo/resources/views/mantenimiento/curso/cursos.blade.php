@extends('layouts.admin')
@section('contenido')
	<div class="card">
        <div class="card-header">
            <h4>
                <b>Cursos | {{$docente->nomDoc}}</b>
            </h4>
            <a class="btn btn-success btn-sm" href="" data-target="#modal-add" data-toggle="modal">
                <i class="fas fa-plus-circle" style="color: #cef5e1; margin-right: 10px"></i>Agregar
            </a>
        </div>
        <div class="card-body">
            @include('inicio.docente.search')
        </div>
    </div>
    @include('inicio.docente.create_cursos')
     <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover table-sm text-nowrap">
                        <thead style="background: #0059D1; color: #ffffff;">
                            <tr>
                                <th>#</th>
                                <th>Nombre del Curso</th>
                                <th>F. Creación</th>
                                <th>Estado</th>
                                <th colspan="3" style="text-align: center">Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($cursos as $c)
                            	<tr>
                            		<td></td>
                            		<td>{{$c->nomCur}}</td>
                            		<td>{{ date('d/m/Y H:i:s', strtotime($c->fechCreacionCur)) }}</td>
                            		<td><span class="badge badge-success"> {{ $c->estadoCur }} </span></td>
                            	</tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
    	<div class="col-12 text-center">
    		<a href="{{ route('docente.index') }}" class="btn btn-danger">Volver</a>
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
    @endpush
@endsection