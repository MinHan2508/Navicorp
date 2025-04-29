<aside id="sidebar" class="sidebar" style="height: calc(50vh - 60px); overflow-y: auto;">
    @php
        $user = auth()->user();
        $vaiTro = $user->vaiTro->ma_vai_tro ?? '';
    @endphp

    <ul class="list-unstyled" id="sidebar-nav">

        <li class="nav-item">
            <a class="nav-link" href="{{ route('chungtu.index') }}">
                <i class="bi bi-grid"></i><span>Danh sách chứng từ</span>
            </a>
        </li>

        @php
            $user = auth()->user();
        @endphp

        @php
            $user = auth()->user();
            $vaiTro = $user?->vaiTro?->ma_vai_tro ?? '';
        @endphp

        <!-- DANH SÁCH HỨNG TỪ -->
        <li class="nav-heading mt-3 text-uppercase fw-bold text-primary fs-6">📄DANH SÁCH CHỨNG TỪ</li>

        <ul class="nav-content list-unstyled ms-3">
            {{-- Chứng từ đi --}}
            @if($vaiTro === 'admin' || $user?->coQuyen('xem_chung_tu_di'))
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('chungtu.index.di') }}">
                        <i class="bi bi-send-arrow-up text-primary"></i><span>Chứng từ đi</span>
                    </a>
                </li>
            @endif

            {{-- Chứng từ nội bộ --}}
            @if($vaiTro === 'admin' || $user?->coQuyen('xem_chung_tu_noi_bo'))
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('chungtu.index.noi_bo') }}">
                        <i class="bi bi-arrow-repeat text-success"></i><span>Chứng từ nội bộ</span>
                    </a>
                </li>
            @endif

            {{-- Chứng từ đến --}}
            @if($vaiTro === 'admin' || $user?->coQuyen('xem_chung_tu_den'))
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('chungtu.index.den') }}">
                        <i class="bi bi-box-arrow-down-left text-danger"></i><span>Chứng từ đến</span>
                    </a>
                </li>
            @endif
        </ul>


        <!-- kết thúc hiển thị danh sách chứng từ -->
        <li class="nav-heading mt-3 text-uppercase fw-bold text-primary fs-6">➕TẠO MỚI</li>


        <ul class="nav-content list-unstyled ms-3">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('chungtu.create.di') }}">
                    <i class="bi bi-box-arrow-up-right text-primary"></i><span>Chứng từ đi</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('chungtu.create.noi_bo') }}">
                    <i class="bi bi-arrow-repeat text-success"></i><span>Chứng từ nội bộ</span>
                </a>
            </li>

            @if($user?->coQuyen('tiep_nhan_chung_tu'))
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('chungtu.create.den') }}">
                        <i class="bi bi-box-arrow-down-left text-danger"></i><span>Chứng từ đến</span>
                    </a>
                </li>
            @endif
        </ul>

        <!-- NHÂN SỰ -->
        @if(in_array($vaiTro, ['admin', 'giamdoc', 'pho_giamdoc', 'truongphong', 'pho_phong']))
            <li class="nav-item">
                <a class="nav-link" href="{{ route('users.index') }}">
                    <i class="bi bi-people"></i><span>Nhân sự</span>
                </a>
            </li>
        @endif
        <!-- END NHÂN SỰ -->

        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-toggle="collapse" href="#mydoc-nav">
                <i class="bi bi-folder"></i><span>Chứng từ của tôi</span>
            </a>
            <ul id="mydoc-nav" class="nav-content collapse list-unstyled" style="padding-left: 20px;">

                {{-- Khởi tạo / Tiếp nhận --}}
                <li>
                    <a href="{{ route('chungtu.index', ['filter' => 'tao_moi']) }}" class="text-primary fw-semibold">
                        <i class="bi bi-pencil-square me-2"></i> Khởi tạo / Tiếp nhận
                    </a>
                </li>

                {{-- Chờ trưởng phòng --}}
                @if(in_array($vaiTro, ['truongphong', 'pho_phong', 'admin']))
                    <li>
                        <a href="{{ route('chungtu.index', ['filter' => 'cho_truong_phong']) }}"
                            class="text-warning fw-semibold">
                            <i class="bi bi-person-badge me-2"></i> Chờ phòng duyệt
                        </a>
                    </li>
                @endif

                {{-- Chờ lãnh đạo --}}
                @if(in_array($vaiTro, ['giamdoc', 'pho_giamdoc', 'admin']))
                    <li>
                        <a href="{{ route('chungtu.index', ['filter' => 'cho_lanh_dao']) }}"
                            class="text-warning fw-semibold">
                            <i class="bi bi-person-check me-2"></i> Chờ lãnh đạo duyệt
                        </a>
                    </li>
                @endif

                {{-- Đã duyệt --}}
                <li>
                    <a href="{{ route('chungtu.index', ['filter' => 'da_duyet']) }}" class="text-success fw-semibold">
                        <i class="bi bi-check-circle me-2"></i> Đã duyệt
                    </a>
                </li>

                {{-- Chờ ký số --}}
                <li>
                    <a href="{{ route('chungtu.index', ['filter' => 'cho_ky_so']) }}" class="text-primary fw-semibold">
                        <i class="bi bi-pen me-2"></i> Chờ ký số
                    </a>
                </li>

                {{-- Đã ký số --}}
                <li>
                    <a href="{{ route('chungtu.index', ['filter' => 'da_ky_so']) }}" class="text-success fw-semibold">
                        <i class="bi bi-shield-check me-2"></i> Đã ký số
                    </a>
                </li>

                {{-- Chờ gửi đi --}}
                <li>
                    <a href="{{ route('chungtu.index', ['filter' => 'cho_gui']) }}" class="text-info fw-semibold">
                        <i class="bi bi-send me-2"></i> Chờ gửi đi
                    </a>
                </li>

                {{-- Đã gửi đi --}}
                <li>
                    <a href="{{ route('chungtu.index', ['filter' => 'da_gui_di']) }}" class="text-info fw-semibold">
                        <i class="bi bi-envelope-paper me-2"></i> Đã gửi đi
                    </a>
                </li>

                {{-- Đã từ chối --}}
                <li>
                    <a href="{{ route('chungtu.index', ['filter' => 'tu_choi']) }}" class="text-danger fw-semibold">
                        <i class="bi bi-x-circle me-2"></i> Đã từ chối
                    </a>
                </li>




            </ul>

        </li>

        @if($vaiTro === 'admin')
            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-toggle="collapse" href="#admin-nav">
                    <i class="bi bi-gear-wide-connected"></i><span class="ms-2">Quản trị</span>
                </a>
                <ul id="admin-nav" class="nav-content collapse list-unstyled" style="padding-left: 20px;">

                    <li>
                        <a href="{{ route('users.index') }}"
                            class="text-decoration-none text-dark d-flex align-items-center py-2">
                            <i class="bi bi-people me-2"></i> Người dùng
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('doitac.index') }}"
                            class="text-decoration-none text-dark d-flex align-items-center py-2">
                            <i class="bi bi-briefcase me-2"></i> Đối tác
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('phongban.index') }}"
                            class="text-decoration-none text-dark d-flex align-items-center py-2">
                            <i class="bi bi-building me-2"></i> Phòng ban
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('loaichungtu.index') }}"
                            class="text-decoration-none text-dark d-flex align-items-center py-2">
                            <i class="bi bi-file-earmark-text me-2"></i> Loại chứng từ
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('trangthaichungtu.index') }}"
                            class="text-decoration-none text-dark d-flex align-items-center py-2">
                            <i class="bi bi-toggle-on me-2"></i> Trạng thái
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('vaitro.index') }}"
                            class="text-decoration-none text-dark d-flex align-items-center py-2">
                            <i class="bi bi-person-gear me-2"></i> Vai trò
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('huongchungtu.index') }}"
                            class="text-decoration-none text-dark d-flex align-items-center py-2">
                            <i class="bi bi-signpost-split me-2"></i> Hướng chứng từ
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('quytrinh.index') }}"
                            class="text-decoration-none text-dark d-flex align-items-center py-2">
                            <i class="bi bi-diagram-3 me-2"></i> Quy trình
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('quyenhan.index') }}"
                            class="text-decoration-none text-dark d-flex align-items-center py-2">
                            <i class="bi bi-shield-lock me-2"></i> Quyền hạn
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('vaitro_quyenhan.index') }}"
                            class="text-decoration-none text-dark d-flex align-items-center py-2">
                            <i class="bi bi-people-gear me-2"></i> Vai trò - Quyền hạn
                        </a>
                    </li>

                </ul>

            </li>

        @endif

    </ul>
</aside>