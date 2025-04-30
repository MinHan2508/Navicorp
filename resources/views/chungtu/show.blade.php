@extends('layouts.app')

@section('content')
    {{-- Bao gồm CSS cho timeline --}}
    <link rel="stylesheet" href="{{ asset('css/timeline.css') }}">
    {{-- Bao gồm SweetAlert2 để hiển thị thông báo --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <div class="container">
        {{-- Điều hướng breadcrumb --}}
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-light px-3 py-2 rounded shadow-sm">
                <li class="breadcrumb-item">
                    <a href="{{ route('chungtu.index') }}">📁 Danh sách chứng từ</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Chi tiết chứng từ</li>
            </ol>
        </nav>

        {{-- Hiển thị sơ đồ xử lý chứng từ dưới dạng timeline --}}
        <h5 class="mt-5">📜 Sơ đồ xử lý chứng từ</h5>
        <div class="timeline-wrapper mt-4">
            {{-- Lặp qua các bản ghi lịch sử --}}
            @foreach($lichSu as $index => $ls)
                <div class="timeline-step">
                    <div class="timeline-icon">
                        {{-- Hiển thị số thứ tự bước --}}
                        <span>{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</span>
                    </div>
                    <div class="timeline-content">
                        {{-- Hiển thị ngày giờ của bước --}}
                        <div class="timeline-date">{{ $ls->created_at->format('d/m/Y H:i:s') }}</div>
                        {{-- Hiển thị trạng thái mới --}}
                        <div class="timeline-title">{{ $ls->trangThaiMoi->ten_trang_thai ?? 'Không xác định' }}</div>
                        {{-- Hiển thị người xử lý bước --}}
                        <div class="timeline-sub"> Người xử lý:
                            {{ $ls->nguoiThayDoi->name ?? 'Không rõ' }}
                        </div>
                        {{-- Hiển thị email của người xử lý --}}
                        <div class="text-muted small">{{ $ls->nguoiThayDoi->email ?? 'Không có email' }}</div>
                        {{-- Hiển thị ghi chú của bước --}}
                        <div class="timeline-note">📝 {{ $ls->ghi_chu }}</div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Hiển thị danh sách email nếu có --}}
        @if (session('danhSachEmailNguoiNhan'))
            <div class="alert alert-info">
                <strong>📧 Email đã gửi đến:</strong>
                <ul class="mb-0">
                    @foreach (session('danhSachEmailNguoiNhan') as $nguoiNhan)
                        <li>{{ $nguoiNhan }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Thông tin chi tiết chứng từ --}}
        <div class="card shadow-sm border-0">
            <div class="card-body mt-4">
                {{-- Hiển thị các thông tin chi tiết của chứng từ --}}
                <div class="row mb-3">
                    <div class="col-md-6"><strong>Mã Chứng Từ:</strong> {{ $chungTu->ma_chung_tu }}</div>
                    <div class="col-md-6"><strong>Tiêu Đề:</strong> {{ $chungTu->tieu_de }}</div>
                </div>
                {{-- Các dòng thông tin bổ sung --}}
                <div class="row mb-3">
                    <div class="col-md-6"><strong>Số Hiệu:</strong> {{ $chungTu->so_hieu ?? '-' }}</div>
                    <div class="col-md-6">
                        <strong>Trạng Thái:</strong>
                        <span class="badge bg-info">{{ $chungTu->trangThai->ten_trang_thai ?? '-' }}</span>
                    </div>
                </div>
                {{-- Tiếp tục hiển thị các thuộc tính khác --}}
                <div class="row mb-3">
                    <div class="col-md-6"><strong>Loại Chứng Từ:</strong>
                        {{ $chungTu->loaiChungTu->ten_loai_chung_tu ?? '-' }}</div>
                    <div class="col-md-6"><strong>Hướng:</strong> {{ $chungTu->huong->ten_huong_chung_tu ?? '-' }}</div>
                </div>
                {{-- Hiển thị ngày ban hành và hiệu lực --}}
                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Ngày Ban Hành:</strong>
                        {{ $chungTu->ngay_ban_hanh ? \Carbon\Carbon::parse($chungTu->ngay_ban_hanh)->format('d/m/Y') : '-' }}
                    </div>
                    <div class="col-md-6">
                        <strong>Hiệu Lực:</strong>
                        @if($chungTu->ngay_hieu_luc)
                            {{ \Carbon\Carbon::parse($chungTu->ngay_hieu_luc)->format('d/m/Y') }}
                            <b>→</b>
                            {{ $chungTu->ngay_het_hieu_luc ? \Carbon\Carbon::parse($chungTu->ngay_het_hieu_luc)->format('d/m/Y') : 'Không rõ' }}
                        @else
                            -
                        @endif
                    </div>
                </div>
                {{-- Hiển thị thông tin ký số và đối tác gửi --}}
                <div class="row mb-3">
                    <div class="col-md-6"><strong>Ký Số:</strong> {{ $chungTu->ky_so ? '✔️ Có' : '❌ Không' }}</div>
                    <div class="col-md-6"><strong>Đối Tác Gửi:</strong> {{ $chungTu->nguoiGuiDoiTac->ten_doi_tac ?? '-' }}
                    </div>
                </div>
                {{-- Hiển thị người tạo và ngày tạo --}}
                <div class="row mb-3">
                    <div class="col-md-6"><strong>Người Tạo:</strong> {{ $chungTu->nguoiTao->name ?? 'Không xác định' }}
                    </div>
                    <div class="col-md-6"><strong>Ngày Tạo:</strong> {{ $chungTu->created_at->format('d/m/Y H:i') }}</div>
                </div>
                {{-- Hiển thị ghi chú --}}
                <div class="row mb-4">
                    <div class="col-12"><strong>Ghi Chú:</strong> {{ $chungTu->ghi_chu ?? 'Không có' }}</div>
                </div>
            </div>
        </div>

        {{-- Phần xử lý chứng từ --}}
        @php
            $user = auth()->user();
            $phongBanNguoiTao = $chungTu->nguoiTao->id_phongban ?? null;
            $phongBanNguoiDung = $user->id_phongban ?? null;
            $trangThaiHienTai = optional($chungTu->trangThai)->ma_trang_thai ?? null;
            $daDuyetCapPhong = $lichSu->contains(fn($ls) => $ls->id_nguoi_thay_doi === $user->id && optional($ls->trangThaiMoi)->ma_trang_thai === 'DA_DUYET_CAP_PHONG');
        @endphp

        <div class="mb-4">
            <h5 class="text-primary" style="margin-top: 10px;">⚙️ Xử lý chứng từ</h5>
            {{-- Hiển thị thông báo thành công, lỗi hoặc thông tin --}}
            @foreach (['success', 'error', 'info'] as $msg)
                @if(session($msg))
                    <div class="alert alert-{{ $msg }}">{{ session($msg) }}</div>
                @endif
            @endforeach

            {{-- Form xử lý chứng từ --}}
            <form method="POST" action="{{ route('chungtu.xuly', $chungTu->id) }}" id="form-xuly">
                @csrf

                <div class="d-flex flex-wrap gap-2">
                    {{-- Hiển thị các bước xử lý --}}
                    @if(isset($quyTrinhXuLy) && $quyTrinhXuLy->count())
                                @foreach ($quyTrinhXuLy as $buoc)
                                            @php
                                                $coTheXuLy = false;
                                                $maTrangThaiDen = optional($buoc->denTrangThai)->ma_trang_thai ?? null;

                                                switch ($maTrangThaiDen) {
                                                    case 'DA_DUYET_CAP_PHONG':
                                                        $coTheXuLy = $user->coQuyen('duyet_cap_phong') && $phongBanNguoiTao === $phongBanNguoiDung;
                                                        break;
                                                    case 'DA_DUYET':
                                                        $coTheXuLy = $user->coQuyen('duyet_lanh_dao') && $trangThaiHienTai === 'DA_DUYET_CAP_PHONG';
                                                        break;
                                                    case 'DA_GUI':
                                                        $coTheXuLy = ($user->coQuyen('gui_chung_tu') || $user->id === $chungTu->id_nguoi_tao)
                                                            && $daGuiSoLuong > 0;
                                                        break;
                                                    case 'DA_BAN_HANH':
                                                        $coTheXuLy = ($user->coQuyen('gui_chung_tu') || $user->id === $chungTu->id_nguoi_tao)
                                                            && $daGuiSoLuong > 0;
                                                        break;
                                                    case 'DA_KY_SO':
                                                        $coTheXuLy = $user->coQuyen('ky_so');
                                                        break;
                                                    case 'DA_LUU_TRU':
                                                        $coTheXuLy = $user->coQuyen('tiep_nhan_chung_tu');
                                                        break;
                                                    default:
                                                        $coTheXuLy = $user->coQuyen('duyet_khac');
                                                }
                                            @endphp

                                            {{-- Hiển thị nút cho từng bước nếu người dùng có quyền --}}
                                            @if ($coTheXuLy)

                                                <div class="col-md-4 d-flex justify-content-center mb-2">
                                                    <button type="button" class="btn btn-success"
                                                        onclick="xacNhanDuyet({{ $buoc->thu_tu }}, '{{ $buoc->mo_ta }}')">
                                                        ✅ {{ $buoc->mo_ta }}
                                                    </button>
                                                </div>
                                            @endif
                                @endforeach
                    @else
                        {{-- Hiển thị thông báo nếu không có bước xử lý --}}
                        <span class="text-muted">Không có bước xử lý kế tiếp.</span>
                    @endif

                    {{-- Hiển thị ghi chú từ chối và nút nếu có thể --}}
                    @php
                        $daDuyetCapPhong = $lichSu->contains(function ($ls) use ($user) {
                            return $ls->id_nguoi_thay_doi === $user->id &&
                                optional($ls->trangThaiMoi)->ma_trang_thai === 'DA_DUYET_CAP_PHONG';
                        });
                    @endphp

                    @if(in_array($trangThaiHienTai, ['TAO_MOI', 'DA_DUYET_CAP_PHONG']) && $user->coQuyen('tu_choi_chung_tu') && !$daDuyetCapPhong)
                        <div id="ghi-chu-container" class="mb-2 w-100">
                            <label for="ghi_chu" class="form-label">📝 Lý do từ chối <span class="text-danger">*</span></label>
                            <textarea id="ghi_chu" name="ghi_chu" class="form-control"
                                placeholder="Vui lòng nhập lý do từ chối..."></textarea>
                            <div id="ghi-chu-error" class="text-danger small mt-1 d-none">⚠️ Vui lòng nhập lý do từ chối!</div>
                        </div>
                        <button type="button" class="btn btn-outline-danger" onclick="xacNhanTuChoi()">
                            ❌ Từ chối chứng từ
                        </button>
                    @endif


                    {{-- Hiển thị modal gửi chứng từ nếu có --}}
                    @php
                        $coBuocGuiChungTu = $quyTrinhXuLy->contains(function ($buoc) {
                            $ma = optional($buoc->denTrangThai)->ma_trang_thai;
                            return in_array($ma, ['DA_GUI', 'DA_BAN_HANH']);
                        });
                    @endphp

                    @if ($coBuocGuiChungTu)
                        <div class="d-flex flex-column align-items-center gap-2 mt-3">
                            {{-- Nút xem danh sách đã gửi --}}
                            <a href="{{ route('nguoinhanchungtu.showDaGui', $chungTu->id) }}"
                                class="btn btn-outline-info w-100 text-center" style="max-width: 300px">
                                📋 Xem danh sách đã gửi
                            </a>

                            {{-- Nút gửi chứng từ --}}
                            <button type="button" class="btn btn-warning w-100 text-center" style="max-width: 300px"
                                data-bs-toggle="modal" data-bs-target="#guiChungTuModal">
                                📤 Gửi chứng từ
                            </button>
                        </div>
                    @endif
                        @if(in_array($trangThaiHienTai, ['DA_GUI', 'DA_BAN_HANH']))
                        <a href="{{ route('nguoinhanchungtu.showDaGui', $chungTu->id) }}"
                                class="btn btn-outline-info w-100 text-center" style="max-width: 300px">
                                📋 Xem danh sách đã gửi
                            </a>
                            @endif
                         



                </div>
            </form>
        </div>

        {{-- Bao gồm xem trước file --}}
        @include('chungtu.partials._file', ['chungTu' => $chungTu])

        {{-- Bao gồm SweetAlert JS --}}
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="{{ asset('js/tu_choi.js') }}"></script>
        <a href="{{ route('chungtu.viewFile', $chungTu->id) }}" class="btn btn-sm btn-outline-primary" target="_blank">
            📄 Xem file
        </a>
    </div>

    {{-- Bao gồm modal gửi chứng từ --}}
    @include('nguoinhanchungtu._modal_gui_chung_tu')
@endsection