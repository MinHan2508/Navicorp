<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="shortcut icon" href="{{ asset('img/admin/lg_1.ico') }}">
    <title>Navico</title>

    <!-- Fonts & CSS -->

    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <link href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
</head>

<body>

    <div id="app" class="d-flex flex-column min-vh-100">

        <!-- Header -->
        <header id="header" class="header d-flex align-items-center shadow-sm fixed-top bg-white" style="height: 70px;">

            <div class="container-fluid d-flex align-items-center justify-content-between">


                <div class="d-flex align-items-center">
                    <button class="btn btn-link p-0 me-3" id="toggle-sidebar-btn">
                        <i class="bi bi-list fs-4"></i>
                    </button>
                    <a href="{{ url('/') }}" class="logo d-flex align-items-center text-decoration-none">
                        <img src="{{ asset('img/admin/lg_1.png') }}" alt="Logo" height="40">
                        <span class="ms-2 fs-5 fw-bold text-dark d-none d-lg-block">Navicorp</span>
                    </a>
                </div>

                <div class="dropdown">
                    @php
                        $user = Auth::user();
                        $avatar = $user && $user->anh ? route('user.avatar', basename($user->anh)) : asset('images/default-avatar.png');
                    @endphp
                    <a href="#" class="dropdown-toggle d-flex align-items-center text-decoration-none"
                        data-bs-toggle="dropdown">
                        <img src="{{ $avatar }}" class="rounded-circle border" width="40" height="40" alt="User Avatar">
                        <span class="ms-2 fw-semibold text-dark">{{ $user->name ?? 'Khách' }}</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                        <li><a class="dropdown-item" href="{{ route('user.profile') }}"><i
                                    class="bi bi-person me-2"></i>Trang cá nhân</a></li>
                        <li><a class="dropdown-item" href="#"><i class="bi bi-gear me-2"></i>Cài đặt</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger">
                                    <i class="bi bi-box-arrow-right me-2"></i>Đăng xuất
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </header>
        @auth


            <div style="margin-top: 50px;">
                @include('layouts.sidebar')
                <main id="main" class="main-content p-4 bg-light">
                    @yield('content')
                </main>
            </div>
        @endauth

        <footer id="footer" class="footer mt-auto text-center py-3 bg-white border-top">
            <div class="container">
                <div class="copyright text-muted">
                    &copy; {{ now()->year }} <strong>Quản lý chứng từ</strong>. All rights reserved.
                </div>
            </div>
        </footer>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const toggleSidebarBtn = document.getElementById('toggle-sidebar-btn');
            const sidebar = document.getElementById('sidebar');
            const main = document.getElementById('main');

            toggleSidebarBtn.addEventListener('click', function () {
                sidebar.classList.toggle('collapsed');
                main.classList.toggle('expanded');
            });
        });
        
    </script>

    @stack('modals')

</body>

</html>