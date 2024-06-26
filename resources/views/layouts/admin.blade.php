<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="icon" href="{{ asset('images/icon.ico') }}" type="image/x-icon">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <title>Api Ura | Interact</title>
</head>

<body class="sb-nav-fixed">

    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-nav">
        <!-- Navbar Brand-->
        <!-- <a class="navbar-brand ps-3" href="#">Interact</a> -->
        <img src="{{ asset('images/logo_mini.png') }}" alt="Logo" style="width: 160px;" class="mx-3">
        <!-- Sidebar Toggle-->
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i
                class="fas fa-bars"></i></button>
        <!-- Navbar Search-->
        <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">

        </form>
        <!-- Navbar-->
        <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button"
                    data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="{{ route('profile.show') }}"><i class="fa-regular fa-user"></i>
                            Perfil</a></li>
                    <li>
                        <hr class="dropdown-divider" />
                    </li>
                    <li><a class="dropdown-item" href="{{ route('login.destroy') }}"><i
                                class="fa-solid fa-arrow-right-to-bracket"></i>
                            Sair</a></li>
                </ul>
            </li>
        </ul>
    </nav>

    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-five" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">

                        <a @class(['nav-link', 'active' => isset($menu) && $menu == 'dashboard']) class="nav-link" href="{{ route('dashboard.index') }}">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Dashboard
                        </a>

                        @can('index-user')
                            <a @class(['nav-link', 'active' => isset($menu) && $menu == 'users']) class="nav-link" href="{{ route('user.index') }}">
                                <div class="sb-nav-link-icon"><i class="fa-solid fa-users"></i></div>
                                Usuários
                            </a>
                        @endcan

                        @can('index-course')
                            <a @class(['nav-link', 'active' => isset($menu) && $menu == 'courses']) class="nav-link" href="{{ route('course.index') }}">
                                <div class="sb-nav-link-icon"><i class="fa-solid fa-chalkboard-user"></i></div>
                                Clientes
                            </a>
                        @endcan

                        @can('index-papel')
                            <a @class(['nav-link', 'active' => isset($menu) && $menu == 'roles']) class="nav-link" href="{{ route('role.index') }}">
                                <div class="sb-nav-link-icon"><i class="fa-solid fa-network-wired"></i></div>
                                Papéis
                            </a>
                        @endcan
                        
                        @can('index-entradas')
                            <a @class(['nav-link', 'active' => isset($menu) && $menu == 'entradas']) class="nav-link" href="{{ route('entradas.index') }}">
                                <div class="sb-nav-link-icon"><i class="fa-solid fa-upload"></i></div>
                                Entradas
                            </a>
                        @endcan

                        @can('index-dialing')
                            <a  @class(['nav-link', 'active' => isset($menu) && $menu == 'dialing']) class="nav-link" href="{{ route('dialing.index') }}">
                            <div class="sb-nav-link-icon"><i class="fa-solid fa-phone-volume"></i></div>Canais Discando
                            </a>
                        @endcan

                        @can('index-ramais')
                            <a  @class(['nav-link', 'active' => isset($menu) && $menu == 'ramais']) class="nav-link" href="#" id="item1">
                                <div class="sb-nav-link-icon"><i class="fa-solid fa-tty"></i></div>PBX
                            </a>
                            <ul class="list-group list-group-flush submenu" id="submenu1" style="display: none;"> <!-- Inicia colapsado -->
                                <li class="list-group-item"><a class="ms-4 text-secondary text-decoration-none" href="{{ route('ramais.index') }}">Ramais</a></li>
                                <li class="list-group-item"><a class="ms-4 text-secondary text-decoration-none" href="{{ route('trunks.index') }}">Troncos</a></li>
                                <li class="list-group-item"><a class="ms-4 text-secondary text-decoration-none" href="{{ route('ramais.index') }}">URA</a></li>
                            </ul>
                        @endcan

                        @can('index-permission')
                            <a @class(['nav-link', 'active' => isset($menu) && $menu == 'permissions']) class="nav-link" href="{{ route('permission.index') }}">
                                <div class="sb-nav-link-icon"><i class="fa-regular fa-file"></i></div>
                                Páginas
                            </a>
                        @endcan

                        <a class="nav-link" href="{{ route('login.destroy') }}">
                            <div class="sb-nav-link-icon"><i class="fa-solid fa-arrow-right-to-bracket"></i></div>
                            Sair
                        </a>

                    </div>
                </div>
                <div class="sb-sidenav-footer">
                    <div class="small">Logado:
                        @if (auth()->check())
                            {{ auth()->user()->name }}
                            <br>
                            IP Local: {{ request()->ip() }}
                            <br>
                            IP Público: {{ file_get_contents('https://api.ipify.org') }}
                            <br>
                            <!-- MAC: {{ preg_match('/([0-9A-Fa-f]{2}[:-]){5}([0-9A-Fa-f]{2})/', exec('getmac'), $matches) ? $matches[0] : 'Não disponível' }} -->
                        @endif
                    </div>
                </div>
            </nav>
        </div>

        <div id="layoutSidenav_content">

            <main>
                @yield('content')
            </main>

            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy; Interact {{ date('Y') }}</div>
                        <div>
                            <a href="#" class="text-decoration-none">Política de Privacidade</a>
                            &middot;
                            <a href="#" class="text-decoration-none">Termos de Uso</a>
                        </div>
                    </div>
                </div>
            </footer>

        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    $(document).ready(function() {
        $('.nav-link').click(function() {
            // Encontre o submenu correspondente usando o ID
            var submenuId = $(this).attr('id').replace('item', 'submenu');
            var submenu = $('#' + submenuId);
            // Alternar a exibição do submenu
            submenu.slideToggle();
        });
    });
    </script>

</body>

</html>
