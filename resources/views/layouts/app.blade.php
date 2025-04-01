<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

    
</head>
<body>
    <div id="app">
        <!-- Header -->
        <header id="header" class="header fixed-top d-flex align-items-center">
            <div class="d-flex align-items-center justify-content-between">
            <i class="bi bi-list toggle-sidebar-btn" id="toggle-sidebar-btn"></i>
                <a href="{{ url('/') }}" class="logo d-flex align-items-center">
                    <img src="{{ asset('assets/img/logo.png') }}" alt="">
                    <span class="d-none d-lg-block">Navicorp</span>
                </a>
                
            </div>

            @php
    $user = Auth::user();
    $avatar = $user && $user->anh
        ? route('user.avatar', basename($user->anh))
        : asset('images/default-avatar.png');
@endphp

<div class="dropdown ms-auto  me-3">
    <a href="#" class="dropdown-toggle d-flex align-items-center text-decoration-none" data-bs-toggle="dropdown" aria-expanded="false">
        <img src="{{ $avatar }}" alt="Ảnh đại diện"
             class="rounded-circle" width="40" height="40">
        <span class="ms-2 fw-semibold text-dark">{{ $user->name ?? 'Khách' }}</span>
    </a>

    <ul class="dropdown-menu dropdown-menu-end shadow">
        <li>
            <a class="dropdown-item d-flex align-items-center" href="{{ route('user.profile') }}">
                <i class="bi bi-person me-2"></i> Trang cá nhân
            </a>
        </li>
        <li>
            <a class="dropdown-item d-flex align-items-center" href="#">
                <i class="bi bi-gear me-2"></i> Cài đặt
            </a>
        </li>
        <li><hr class="dropdown-divider"></li>
        <li>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="dropdown-item d-flex align-items-center text-danger">
                    <i class="bi bi-box-arrow-right me-2"></i> Đăng xuất
                </button>
            </form>
        </li>
    </ul>
</div>

</header><!-- End Header -->

        <!-- Sidebar -->
        <aside id="sidebar" class="sidebar">
            <ul class="sidebar-nav" id="sidebar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('chungtu.index') }}">
                        <i class="bi bi-grid"></i> <span>Danh sách chứng từ</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link collapsed" data-bs-target="#components-nav" data-bs-toggle="collapse" href="#">
                        <i class="bi bi-menu-button-wide"></i><span>Chứng từ của tôi</span><i class="bi bi-chevron-down ms-auto"></i>
                    </a>
                    <ul id="components-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                    <li><a href="components-modal.html"><i class="bi bi-circle"></i><span>Đã gửi</span></a></li>
                        <li><a href="components-carousel.html"><i class="bi bi-circle"></i><span>Cần xử lý</span></a></li>
                        <li><a href="components-list-group.html"><i class="bi bi-circle"></i><span>Duyệt</span></a></li>
                        
                    </ul>
                </li>
           
        
        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#system-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-gear"></i><span>Quản trị hệ thống</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="system-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                <li><a href="{{ route('users.index') }}"><i class="bi bi-person"></i><span>Người dùng</span></a></li>
                <li><a href="{{ route('phancong.index') }}"><i class="bi bi-key"></i><span> Phân Công</span></a></li>
                
                <li><a href="{{ route('doitac.index') }}"><i class="bi bi-bank"></i><span>Đối Tác</span></a></li>
                <li><a href="{{ route('phongban.index') }}"><i class="bi bi-bank"></i><span>Phòng Ban</span></a></li>
                <li><a href="{{ route('loaichungtu.index') }}"><i class="bi bi-file-earmark-text"></i><span>Loại Chứng từ</span></a></li>
                <li><a href="{{ route('trangthaichungtu.index') }}"><i class="bi bi-file-earmark-text"></i><span>Trạng Thái Chứng từ</span></a></li>
                <li><a href="{{ route('vaitro.index') }}"><i class="bi bi-file-earmark-text"></i><span>Vai trò/Chức Vụ</span></a></li>
                <li><a href="{{ route('huongchungtu.index') }}"><i class="bi bi-file-earmark-text"></i><span>Hướng Chứng từ</span></a></li>s
            </ul>
        </li>
            </ul>
        </aside><!-- End Sidebar-->

        <!-- Main Content -->
        <main id="main" class="main">
            @yield('content')
        </main>

        <!-- Footer -->
        <footer id="footer" class="footer">
            <div class="copyright">
                &copy; Copyright <strong><span>Quản lý chứng từ</span></strong>. All Rights Reserved
            </div>
        </footer>

        <!-- Back to top -->
        <a href="#" class="back-to-top d-flex align-items-center justify-content-center">
            <i class="bi bi-arrow-up-short"></i>
        </a>
    </div>

    <!-- Vendor JS Files -->
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- JavaScript trực tiếp -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            let toggleSidebarBtn = document.getElementById("toggle-sidebar-btn");
            let sidebar = document.getElementById("sidebar");
            let mainContent = document.getElementById("main");

            toggleSidebarBtn.addEventListener("click", function () {
                sidebar.classList.toggle("hidden");
                mainContent.classList.toggle("full-width");
            });
        });
    </script>
</body>
</html>
