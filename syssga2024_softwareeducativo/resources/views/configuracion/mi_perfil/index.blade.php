@extends('layouts.admin')
@section('contenido')
    <div class="card">
        <div class="card-header">
            <h4>
                <b>Mi Perfíl</b>
            </h4>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12">
                    <div class="table-responsive">
                        <table class="table ">
                            <tr>
                                <td colspan="2" style="color: #d44c4c">
                                    *Esta información es importante para la emisión de reportes.
                                </td>
                            </tr>
                            {{-- <tr>
                            <td class="text-secondary"><b>Foto:</b></td>
                            <td>
                                @if (!empty($users->imageUsers))
                                    <img src="{{asset('users/'.$users->imageUsers)}}" alt=""
                                    width="100" height="100">
                                @else
                                    Aún no tiene una foto.
                                @endif
                            </td>
                        </tr> --}}
                            <tr>
                                <td class="text-secondary"><b>Nombre:</b></td>
                                <td>{{ $users->name }}</td>
                            </tr>
                            <tr>
                                <td class="text-secondary"><b>Teléfono:</b></td>
                                <td>{{ $users->telUse }}</td>
                            </tr>
                            <tr>
                                <td class="text-secondary"><b>Correo:</b></td>
                                <td>{{ $users->email }}</td>
                            </tr>
                            {{-- <tr>
                            <td class="text-secondary"><b>Rol:</b></td>
                            <td>{{$users->tipo}} --}}
                            {{-- @if (auth()->user()->tipo == 'DOCTOR') --}}
                            {{-- - {{$users->nomLocalidad}} --}}
                            {{-- @endif --}}
                            {{-- </td>
                        </tr> --}}
                            <tr>
                                <td class="text-secondary"><b>Estado:</b></td>
                                <td>{{ $users->estUse }}</td>
                            </tr>

                            <tr>
                                <td colspan="2" style="text-align: center;">
                                    <a class="btn btn-primary" href="" data-target="#modal-add-{{ $users->id }}"
                                        data-toggle="modal">
                                        Editar <i class="far fa-edit" style="margin-left: 20px"></i>
                                    </a>
                                </td>
                            </tr>

                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
    @include('configuracion.mi_perfil.modal')
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
        @endif
        {{-- ----------------------------------------------- --}}
        @if (Session::has('error'))
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
            <script type="text/javascript">
                $(document).ready(function() {
                    // $('#modal-add').modal('show');
                    $('#modal-add-<?php echo old('codUsuario'); ?>').modal('show');
                    $("#modal-add-<?php echo old('codUsuario'); ?>").on('hidden.bs.modal', function() {
                        location.reload();
                    });
                });
            </script>
        @endif
    @endpush
@endsection
