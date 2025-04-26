<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts & CSS -->
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

            <!-- Profile dropdown -->
            <div class="dropdown ms-auto me-3">
                <a href="#" class="dropdown-toggle d-flex align-items-center text-decoration-none"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="{{ $avatar }}" alt="Avatar" class="rounded-circle" width="40" height="40">
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
                    <li>
                        <hr class="dropdown-divider">
                    </li>
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
        </header>

        <!-- Sidebar -->
        <aside id="sidebar" class="sidebar">
            @php $user = auth()->user(); @endphp
            <ul class="sidebar-nav" id="sidebar-nav">

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('chungtu.index') }}">
                        <i class="bi bi-grid"></i> <span>Danh sách tất cả chứng từ</span>
                    </a>
                </li>

                <!-- Nhóm: Tạo mới chứng từ -->
                <li class="nav-heading mt-3">➕ Tạo mới chứng từ</li>

                <li class="nav-item ms-3">
                    <a class="nav-link" href="{{ route('chungtu.create.di') }}">
                        <i class="bi bi-box-arrow-up-right text-primary"></i>
                        <span>Chứng từ đi</span>
                    </a>
                </li>

                <li class="nav-item ms-3">
                    <a class="nav-link" href="{{ route('chungtu.create.noi_bo') }}">
                        <i class="bi bi-arrow-repeat text-success"></i>
                        <span>Chứng từ nội bộ</span>
                    </a>
                </li>

                @if(auth()->user()?->coQuyen('tiep_nhan_chung_tu'))
                    <li class="nav-item ms-3">
                        <a class="nav-link" href="{{ route('chungtu.create.den') }}">
                            <i class="bi bi-box-arrow-down-left text-danger"></i>
                            <span>Tiếp nhận chứng từ đến</span>
                        </a>
                    </li>
                @endif


                @if(in_array(auth()->user()->vaiTro->ma_vai_tro ?? '', ['admin', 'giamdoc', 'pho_giamdoc', 'truongphong', 'pho_phong']))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('users.index') }}">
                            <i class="bi bi-person"></i> <span>Danh sách nhân sự</span>
                        </a>
                    </li>
                @endif


                {{-- Chứng từ của tôi --}}
                <li class="nav-item">
                    <a class="nav-link collapsed" data-bs-target="#components-nav" data-bs-toggle="collapse" href="#">
                        <i class="bi bi-menu-button-wide"></i><span>Chứng từ của tôi</span><i
                            class="bi bi-chevron-down ms-auto"></i>
                    </a>
                    <ul id="components-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                        <li><a href="{{ route('chungtu.index', ['filter' => 'tao_moi']) }}"><i class="bi bi-circle"></i>
                                Đã Khởi tạo/Tiếp nhận</a></li>

                        @php $vaiTro = auth()->user()->vaiTro->ma_vai_tro ?? ''; @endphp

                        @if(in_array($vaiTro, ['truongphong', 'pho_phong','admin']))
                            <li><a href="{{ route('chungtu.index', ['filter' => 'cho_truong_phong']) }}"><i
                                        class="bi bi-circle"></i> Chờ trưởng phòng duyệt</a></li>
                        @endif

                        @if(in_array($vaiTro, ['giamdoc', 'pho_giamdoc','admin']))
                            <li><a href="{{ route('chungtu.index', ['filter' => 'cho_lanh_dao']) }}"><i
                                        class="bi bi-circle"></i> Chờ lãnh đạo duyệt</a></li>
                        @endif

                        <li><a href="{{ route('chungtu.index', ['filter' => 'da_duyet']) }}"><i
                                    class="bi bi-circle"></i> Đã duyệt</a></li>
                        <li><a href="{{ route('chungtu.index', ['filter' => 'cho_ky_so']) }}"><i
                                    class="bi bi-circle"></i> Chờ ký số</a></li>
                        <li><a href="{{ route('chungtu.index', ['filter' => 'da_ky_so']) }}"><i
                                    class="bi bi-circle"></i> Đã ký số</a></li>
                        <li><a href="{{ route('chungtu.index', ['filter' => 'cho_gui']) }}"><i class="bi bi-circle"></i>
                                Chờ gửi đi</a></li>
                        <li><a href="{{ route('chungtu.index', ['filter' => 'da_gui_di']) }}"><i
                                    class="bi bi-circle"></i> Đã gửi đi</a></li>
                        <li><a href="{{ route('chungtu.index', ['filter' => 'tu_choi']) }}"><i class="bi bi-circle"></i>
                                Đã từ chối</a></li>
                    </ul>
                </li>

                {{-- Admin settings --}}
                @if(in_array($vaiTro, ['admin']))
                    <li class="nav-item">
                        <a class="nav-link collapsed" data-bs-target="#admin-nav" data-bs-toggle="collapse" href="#">
                            <i class="bi bi-gear"></i><span>Quản trị hệ thống</span><i
                                class="bi bi-chevron-down ms-auto"></i>
                        </a>
                        <ul id="admin-nav" class="nav-content collapse show" data-bs-parent="#sidebar-nav">
                            <li><a href="{{ route('users.index') }}"><i class="bi bi-person"></i> Người dùng</a></li>
                            <li><a href="{{ route('doitac.index') }}"><i class="bi bi-building"></i> Đối Tác</a></li>
                            <li><a href="{{ route('phongban.index') }}"><i class="bi bi-building"></i> Phòng Ban</a></li>
                            <li><a href="{{ route('loaichungtu.index') }}"><i class="bi bi-file-earmark-text"></i> Loại
                                    chứng từ</a></li>
                            <li><a href="{{ route('trangthaichungtu.index') }}"><i class="bi bi-list-check"></i> Trạng
                                    thái</a></li>
                            <li><a href="{{ route('vaitro.index') }}"><i class="bi bi-person-lines-fill"></i> Vai trò</a>
                            </li>
                            <li><a href="{{ route('huongchungtu.index') }}"><i class="bi bi-signpost"></i> Hướng chứng
                                    từ</a></li>
                            <li><a href="{{ route('quytrinh.index') }}"><i class="bi bi-diagram-3"></i> Quy trình xử lý</a>
                            </li>
                            <li><a href="{{ route('quyenhan.index') }}"><i class="bi bi-shield-lock"></i> Quyền hạn</a></li>
                            <li><a href="{{ route('vaitro_quyenhan.index') }}"><i class="bi bi-link-45deg"></i> Vai trò /
                                    Quyền hạn</a></li>
                        </ul>
                    </li>
                @endif
            </ul>
        </aside>

        <!-- Main Content -->
        <main id="main" class="main">
            @yield('content')
        </main>

        <!-- Footer -->
        <footer id="footer" class="footer">
            <div class="copyright">
                &copy; {{ now()->year }} <strong><span>Quản lý chứng từ</span></strong>. All Rights Reserved.
            </div>
        </footer>

        <!-- Back to top -->
        <a href="#" class="back-to-top d-flex align-items-center justify-content-center">
            <i class="bi bi-arrow-up-short"></i>
        </a>
    </div>

    <!-- JS Scripts -->
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

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

    @stack('modals')
</body>

</html>