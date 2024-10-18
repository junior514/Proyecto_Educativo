@extends('layouts.admin')
@section('contenido')

    <div class="row mt-2">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>
                        <b>{{ $grupo->nomCur }} - {{ $grupo->nomDoc }} ({{ $grupo->nombreGrupo }})</b>

                    </h4>
                </div>
                <div class="card-body">
                    <div class="row justify-content-center">
                        <div class="col-md-8 col-12">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Módulo</th>
                                        <th style="text-align: center">N° Estudiantes</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($modulos as $m)
                                        <tr>
                                            <td>
                                                <a href="{{ route('detalle_modulo', [$grupo->idGrupo, $m->nroModulo]) }}">
                                                    Módulo N° {{ $m->nroModulo }}
                                                </a>
                                            </td>
                                            <td style="text-align: center">{{ $m->cantidadAlumnos }}</td>
                                           
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                        </div>

                    </div>
                </div>
                <div class="card-footer text-center">
                    <a href="{{ route('grupo.index') }}" type="button" class="btn btn-danger ">Volver</a>
                    {{-- <button type="submit" class="btn btn-primary">Guardar</button> --}}
                </div>
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
    @endpush
@endsection
