<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sistema Centro de Idiomas</title>
    {{-- Icono de la Pagina --}}
    <link rel="shortcut icon" type="image/ico" href="{{ asset('logo/' . $empresa_ini->logo) }}" />
    {{-- Meta descripción --}}
    <meta name="description"
        content="El Sistema permite el control de actividades educativas del centro de idiomas.">
    <meta name="author" content="Wilfredo Vargas Cárdenas - CWILSOFT" />
    <meta name="copyright" content="CWILSOFT" />

    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dist/css/bootstrap-select.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dist/css/toastr.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
    
</head>
<body class="sidebar-mini sidebar-collapse" style="height: auto;">
    <div class="wrapper">
        <nav class="main-header navbar navbar-expand-md navbar-light navbar-dark" style="background: #0059D1">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i
                            class="fas fa-bars"></i></a>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="fas fa-sort-down"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <a href="{{ asset('configuracion/mi_perfil') }}"
                            class="dropdown-header">{{ auth()->user()->nomDoc }}<br>
                            <b>{{ 'DOCENTE' }}</b>
                        </a>
                        <div class="dropdown-divider"></div>
                        <form method="POST" action="{{ route('logout') }}">
                            {{ csrf_field() }}
                            <button class="dropdown-item dropdown-footer">
                                Cerrar Sesión <i class="fas fa-sign-out-alt" style="margin-left: 1em"></i></button>
                        </form>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                        <i class="fas fa-expand-arrows-alt"></i>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-light-dark">
            <!-- Brand Logo -->
            <a href="#" class="brand-link text-white" style="background: #0059D1;">
                @if (!empty($empresa_ini->logo))
                    <img src="{{ asset('empresa/' . $empresa_ini->logo) }}" alt="AdminLTE Logo"
                        class="brand-image img-circle elevation-3" style="opacity: .8">
                        
                @endif
                <span class="brand-text font-weight-light" style="font-size: 0.90em">{{ $empresa_ini->nombre }}</span>
            </a>
            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user panel (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        {{-- @if ($user_ses->foto != '')
                            <img src="{{ asset('Imagen/' . $user_ses->foto) }}" class="img-circle elevation-2"
                                alt="User Image">
                        @endif --}}
                    </div>
                    <div class="info">
                        <a href="#" class="d-block">{{ auth()->user()->nomDoc }}</a>
                    </div>
                </div>


                <!-- Sidebar Menu -->
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
                                    <a href="{{ asset('inicio/grupo_docente') }}"
                                        class="nav-link {{ 'grupo_docente' == request()->segment(2) ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Grupos</p>
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
                                    <a href="{{ asset('configuracion/perfil_docente') }}"
                                        class="nav-link {{ 'perfil_docente' == request()->segment(2) ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Mi perfíl</p>
                                    </a>
                                </li>
                            </ul>
                          
                        </li>
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            @yield('encabezado')
            <!-- /.content-header -->

            <!-- Main content -->
            <div class="content">
                <div class="container-fluid">
                    @yield('contenido')
                </div>
                <!-- /.container-fluid -->
            </div>
            <!-- /.content -->
        </div>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->

        <!-- Main Footer -->
        <footer class="main-footer">
            <strong>Copyright &copy; CWILSOFT - 2023<a href="#"></a>.</strong>
            Todos los derechos Reservados
            <div class="float-right d-none d-sm-inline-block">
                <b>Sistema Centro de Idiomas</b>Versión Personalizado
            </div>
        </footer>
    </div>
    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->

    <!-- jQuery -->
    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap -->
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('dist/js/bootstrap-select.min.js') }}"></script>

    <!-- AdminLTE -->
    <script src="{{ asset('dist/js/adminlte.js') }}"></script>
    <script src="{{ asset('dist/js/toastr.min.js') }}"></script>
    <script src="{{ asset('dist/js/chart.min.js') }}"></script>
    <script src="{{ asset('dist/sweetalert2/sweetalert2.all.min.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
    @stack('scripts')

    <script src="{{ asset('dist/js/eliminar2.js') }}"></script>
   


    {{-- }}}}}}}}}}}}}}}}} --}}
    <!-- Moments -->


 

</body>

</html>
