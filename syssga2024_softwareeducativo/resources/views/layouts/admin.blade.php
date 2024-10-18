<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PAUL MULLER</title>
    <link rel="shortcut icon" href="{{ asset('img/favicon.jpeg') }}" type="image/x-icon">
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    <!-- IonIcons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dist/css/bootstrap-select.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dist/css/toastr.css') }}">

    {{-- <link rel="stylesheet" href="{{asset('plugins/sweetalerts/sweetalert.css')}}" type="text/css" /> --}}
    <link rel="stylesheet" href="{{ asset('plugins/notification/snackbar/snackbar.min.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('dist/css/dataTables.bootstrap4.min.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
</head>
<!--
`body` tag options:

  Apply one or more of the following classes to to the body tag
  to get the desired effect

  * sidebar-collapse
  * sidebar-mini
-->
<style type="text/css">
    body{
        font-size: 0.90em;
    }
</style>
{{-- <body class="hold-transition sidebar-mini text-sm"> --}}

<body class="sidebar-collapse layout-top-nav sidebar-closed" style="height: auto;">
    <div class="wrapper">

        <nav class="main-header navbar navbar-expand-md navbar-light navbar-dark" style="background: #0059D1">
            <div class="container">
                <a href="#" class="navbar-brand">
                    @if (!empty($empresa_ini->logo))
                        <img src="{{ asset('empresa/' . $empresa_ini->logo) }}" alt="AdminLTE Logo"
                            class="brand-image img-circle elevation-3" style="opacity: .8">
                    @endif
                    <span class="brand-text font-weight-light">{{ $empresa_ini->nombre }}</span>
                </a>
                <button class="navbar-toggler order-1" type="button" data-toggle="collapse"
                    data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse order-3" id="navbarCollapse">

                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i
                                    class="fas fa-bars"></i></a>
                        </li>
                        <li class="nav-item">

                            <select class="form-control selectpicker" id="busqueda_estudiante" data-live-search="true">
                                <option value="" selected hidden>Buscar</option>
                                @foreach($estudiantes_general as $e)
                                    <option value="{{$e->idEstudiante}}">{{$e->nroDoc}} - {{$e->nomEst}}</option>
                                @endforeach
                            </select>
                            
                        </li>
                    </ul>
                  
                    <ul class="navbar-nav ml-auto" >

                        <li class="nav-item dropdown" >
                            <a class="nav-link" data-toggle="dropdown" href="#">
                                <i class="fas fa-sort-down"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                                <a href="{{ asset('configuracion/mi_perfil') }}"
                                    class="dropdown-header">{{ auth()->user()->name }}<br>
                                    <b>{{ auth()->user()->tipUse }}</b>
                                </a>

                                <div class="dropdown-divider"></div>
                                <form method="POST" action="{{ route('login') }}">
                                    @method('put')
                                    @csrf
                                    <button class="dropdown-item dropdown-footer">
                                        Cerrar Sesión <i class="fas fa-sign-out-alt"
                                            style="margin-left: 1em"></i></button>
                                </form>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <aside class="main-sidebar sidebar-light-primary elevation-4" >
            <a href="#" class="brand-link text-white" style="background: #0059D1;">
                @if (!empty($empresa_ini->logo))
                    <img src="{{ asset('empresa/' . $empresa_ini->logo) }}" alt="AdminLTE Logo"
                        class="brand-image img-circle elevation-3" style="opacity: .8">
                @endif
                <span class="brand-text font-weight-light">{{ $empresa_ini->nombre }}</span>
            </a>

            <div class="sidebar">

                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    {{-- <div class="image">
                        <img src="../../dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
                    </div> --}}
                    <div class="info">
                        <a href="#" class="d-block">{{ auth()->user()->name }}</a>
                    </div>
                </div>
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <li class="nav-item {{ 'inicio' == request()->segment(1) ? 'menu-open' : '' }}">
                            <a href="#" class="nav-link"
                                style="background: {{ 'inicio' == request()->segment(1) ? '#0059D1; color: #ffffff' : '' }}">
                                <i class="nav-icon  fas fa-chart-line"></i>
                                <p>
                                    Inicio
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ asset('inicio/estudiante') }}"
                                        class="nav-link {{ 'estudiante' == request()->segment(2) ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Estudiantes</p>
                                    </a>
                                </li>
                            </ul>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ asset('inicio/grupo') }}"
                                        class="nav-link {{ 'grupo' == request()->segment(2) ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Grupos</p>
                                    </a>
                                </li>
                            </ul>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ asset('inicio/docente') }}"
                                        class="nav-link {{ 'docente' == request()->segment(2) ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Docentes</p>
                                    </a>
                                </li>
                            </ul>
                           
                        </li>
                        
                        <li class="nav-item {{ 'mantenimiento' == request()->segment(1) ? 'menu-open' : '' }}">
                            <a href="#" class="nav-link"
                            style="background: {{ 'mantenimiento' == request()->segment(1) ? '#0059D1; color: #ffffff' : '' }}">
                                <i class="nav-icon fas fa-table"></i>
                                <p>
                                    Mantenimiento
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ asset('mantenimiento/curso') }}"
                                        class="nav-link {{ 'curso' == request()->segment(2) ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Cursos</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ asset('mantenimiento/producto') }}"
                                        class="nav-link {{ 'producto' == request()->segment(2) ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Productos</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item {{ 'acceso' == request()->segment(1) ? 'menu-open' : '' }}">
                            <a href="#" class="nav-link"
                            style="background: {{ 'acceso' == request()->segment(1) ? '#0059D1; color: #ffffff' : '' }}">
                                <i class="nav-icon fas fa-shield-alt"></i>
                                <p>
                                    Acceso
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ asset('acceso/usuario') }}"
                                        class="nav-link {{ 'usuario' == request()->segment(2) ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Usuario</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item {{ 'configuracion' == request()->segment(1) ? 'menu-open' : '' }}">
                            <a href="#" class="nav-link"
                            style="background: {{ 'configuracion' == request()->segment(1) ? '#0059D1; color: #ffffff' : '' }}">
                                <i class="nav-icon fas fa-tools"></i>
                                <p>
                                    Configuración
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ asset('configuracion/ajustes') }}"
                                        class="nav-link {{ 'ajustes' == request()->segment(2) ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Ajustes</p>
                                    </a>
                                </li>
                            </ul>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ asset('configuracion/mi_perfil') }}"
                                        class="nav-link {{ 'mi_perfil' == request()->segment(2) ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Mi perfíl</p>
                                    </a>
                                </li>
                            </ul>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ asset('configuracion/forma_pago') }}"
                                        class="nav-link {{ 'forma_pago' == request()->segment(2) ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Formas de Pago</p>
                                    </a>
                                </li>
                            </ul>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ asset('configuracion/tipo_descuento') }}"
                                        class="nav-link {{ 'tipo_descuento' == request()->segment(2) ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Tipos de Descuento</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </nav>

            </div>

        </aside>

        <div class="content-wrapper" style="min-height: 1504.06px;">
            <div class="content">
                <div class="container-fluid">
                    @yield('contenido')
                </div>
            </div>
        </div>
      


        <footer class="main-footer">

            <div class="float-right d-none d-sm-inline">
                Anything you want
            </div>

            <strong>Copyright © 2019-2023 <a href="#">CWIL</a>.</strong> All rights reserved.
        </footer>
        <div id="sidebar-overlay"></div>
    </div>
    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->

    <!-- jQuery -->
    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap -->
    {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script> --}}

    <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('dist/js/bootstrap-select.min.js') }}"></script>

    <!-- AdminLTE -->
    <script src="{{ asset('dist/js/adminlte.js') }}"></script>
    <script src="{{ asset('dist/sweetalert2/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('dist/js/toastr.min.js') }}"></script>
    {{-- Data tables --}}
    <script src="{{ asset('dist/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('dist/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('dist/js/chart.min.js') }}"></script>
    @stack('scripts')
    <script src="{{ asset('plugins/notification/snackbar/snackbar.min.js') }}"></script>
    <script src="{{ asset('dist/js/eliminar.js') }}"></script>
    <script src="{{ asset('dist/js/eliminar2.js') }}"></script>
    <script src="{{ asset('plugins/moment/moment.main.js') }}"></script>
    <script src="{{ asset('plugins/moment/moment-timezone.js') }}"></script>
    
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
    <script>
        $('.decimales').on('input', function() {
            this.value = this.value.replace(/[^0-9,.]/g, '').replace(/,/g, '.');
        });

        // Para eliminar
        function confirmDelete(id) {
            Swal.fire({
                title: '¿Estás seguro?',
                text: 'Esta acción no se puede deshacer',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('deleteForm' + id).submit();
                }
            });
        }

        let busquedaEstudiante = document.getElementById('busqueda_estudiante');
        busquedaEstudiante.addEventListener('change', function() {

            let route = "{{route('estudiante.show', ':id')}}";
            route = route.replace(':id', busquedaEstudiante.value);
            window.location.href = route;
        })

    </script>
</body>

</html>
