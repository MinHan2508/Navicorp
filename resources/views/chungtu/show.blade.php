<link rel="stylesheet" href="{{ asset('css/timeline.css') }}">
@extends('layouts.app')

@section('content')
<div class="container">
    {{-- 🧭 Breadcrumb định hướng điều hướng người dùng --}}
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-light px-3 py-2 rounded shadow-sm">
            <li class="breadcrumb-item">
                <a href="{{ route('chungtu.index') }}">📁 Danh sách chứng từ</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">Chi tiết chứng từ</li>
        </ol>
    </nav>

    {{-- 🕒 Tiêu đề timeline --}}
    <h5 class="mt-5">📜 Sơ đồ timeline xử lý chứng từ</h5>

    {{-- 📌 Timeline xử lý các bước chứng từ --}}
    <div class="timeline-wrapper mt-4">
        @foreach($lichSu as $index => $ls)
            <div class="timeline-step">
                {{-- 🔵 Icon số thứ tự bước --}}
                <div class="timeline-icon">
                    <span>{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</span>
                </div>

                {{-- 📝 Nội dung chi tiết từng bước xử lý --}}
                <div class="timeline-content">
                    <div class="timeline-date">
                        {{ $ls->created_at->format('d/m/Y H:i:s') }}
                    </div>
                    <div class="timeline-title">
                        {{ $ls->trangThaiMoi->ten_trang_thai ?? 'Trạng thái không xác định' }}
                    </div>
                    <div class="timeline-sub">
                        Người xử lý: {{ $ls->nguoiThayDoi->name ?? 'Không rõ' }}
                    </div>
                    <div class="timeline-note">
                        📝 {{ $ls->ghi_chu }}
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    {{-- 📄 Chi tiết thông tin chứng từ --}}
    <div class="card shadow-sm border-0">
        <div class="card-body mt-4">

            {{-- Thông tin chung --}}
            <div class="row mb-3">
                <div class="col-md-6"><strong>Mã Chứng Từ:</strong> {{ $chungTu->ma_chung_tu }}</div>
                <div class="col-md-6"><strong>Tiêu Đề:</strong> {{ $chungTu->tieu_de }}</div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6"><strong>Số Hiệu:</strong> {{ $chungTu->so_hieu ?? '-' }}</div>
                <div class="col-md-6">
                    <strong>Trạng Thái:</strong>
                    <span class="badge bg-info">{{ $chungTu->trangThai->ten_trang_thai ?? '-' }}</span>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6"><strong>Loại Chứng Từ:</strong> {{ $chungTu->loaiChungTu->ten_loai_chung_tu ?? '-' }}</div>
                <div class="col-md-6"><strong>Hướng:</strong>    {{ $chungTu->huong->ten_huong_chung_tu ?? '-' }}</div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6"><strong>Nơi Ban Hành:</strong> {{ $chungTu->noi_ban_hanh ?? '-' }}</div>
                <div class="col-md-6"><strong>Trích Yếu:</strong> {{ $chungTu->trich_yeu ?? '-' }}</div>
            </div>

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

            <div class="row mb-3">
                <div class="col-md-6"><strong>Ký Số:</strong> {{ $chungTu->ky_so ? '✔️ Có' : '❌ Không' }}</div>
                <div class="col-md-6"><strong>Đối Tác Gửi:</strong> {{ $chungTu->nguoiGuiDoiTac->ten_doi_tac ?? '-' }}</div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6"><strong>Người Tạo:</strong> {{ $chungTu->nguoiTao->name ?? 'Không xác định' }}</div>
                <div class="col-md-6"><strong>Ngày Tạo:</strong> {{ $chungTu->created_at->format('d/m/Y H:i') }}</div>
            </div>

            <div class="row mb-4">
                <div class="col-12"><strong>Ghi Chú:</strong> {{ $chungTu->ghi_chu ?? 'Không có' }}</div>
            </div>






            {{-- 🔍 Thông tin kiểm tra quyền và trạng thái --}}
<div class="alert alert-secondary mt-4">
    <h6 class="mb-2">🔍 Debug: Thông tin quyền & trạng thái</h6>
    <ul class="mb-0">
        <li><strong>👤 User:</strong> {{ auth()->user()->name }} (ID: {{ auth()->id() }})</li>
        <li><strong>📛 Vai trò:</strong> {{ auth()->user()->vaiTro->ma_vai_tro ?? 'Không có' }}</li>
        <li><strong>🏢 Phòng ban người dùng:</strong> {{ auth()->user()->id_phongban ?? 'Không rõ' }}</li>
        <li><strong>📄 Trạng thái hiện tại:</strong> {{ $chungTu->trangThai->ma_trang_thai ?? 'Chưa xác định' }}</li>
        <li><strong>🏢 Phòng ban người tạo chứng từ:</strong> {{ $chungTu->nguoiTao->id_phongban ?? 'Không rõ' }}</li>
        <li><strong>🔐 Các quyền của vai trò:</strong>
            <ul>
                @foreach(auth()->user()->vaiTro->quyenHans ?? [] as $quyen)
                    <li>🔹 {{ $quyen->ma_quyen }} - {{ $quyen->ten_quyen }}</li>
                @endforeach
            </ul>
        </li>
    </ul>
</div>


















            {{-- 📋 Khu vực xử lý chứng từ --}}
<div class="mb-4">
    <h5 class="text-primary">⚙️ Xử lý chứng từ</h5>

    {{-- Thông báo session --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    @if(session('info'))
        <div class="alert alert-info">{{ session('info') }}</div>
    @endif

    {{-- Form xử lý --}}
    <form method="POST" action="{{ route('chungtu.xuly', $chungTu->id) }}" id="form-xuly">
        @csrf

        {{-- Ghi chú sẽ hiển thị khi bấm nút xử lý --}}
        <div id="ghi-chu-container" class="mb-2 d-none">
            <textarea name="ghi_chu" class="form-control" placeholder="Lý do hoặc ghi chú xử lý">{{ old('ghi_chu') }}</textarea>
        </div>



        <div class="d-flex flex-wrap gap-2">
    @php
        $user = auth()->user();
        $trangThaiHienTai = optional($chungTu->trangThai)->ma_trang_thai ?? null;
        $phongBanNguoiTao = $chungTu->nguoiTao->id_phongban ?? null;
        $phongBanNguoiDung = $user->id_phongban ?? null;
    @endphp

    {{-- Duyệt theo quy trình --}}
    @if(isset($quyTrinhXuLy) && $quyTrinhXuLy->count())
        @foreach ($quyTrinhXuLy as $buoc)
            @php
                $coTheXuLy = false;
                $maTrangThaiDen = optional($buoc->trangThaiDen)->ma_trang_thai ?? null;

                if ($maTrangThaiDen === 'DA_DUYET_CAP_PHONG') {
                    $coTheXuLy = $user->coQuyen('duyet_cap_phong') && $phongBanNguoiTao === $phongBanNguoiDung;
                } elseif ($maTrangThaiDen === 'DA_DUYET') {
                    $coTheXuLy = $user->coQuyen('duyet_lanh_dao') && $trangThaiHienTai === 'DA_DUYET_CAP_PHONG';
                } else {
                    $coTheXuLy = $user->coQuyen('duyet_khac');
                }
            @endphp

            @if ($coTheXuLy)
                <button type="submit" name="thu_tu" value="{{ $buoc->thu_tu }}" class="btn btn-success btn-xuly">
                    ✅ {{ $buoc->mo_ta }}
                </button>
            @endif


            
        @endforeach
    @else
        <span class="text-muted">Không có bước xử lý kế tiếp.</span>
    @endif

    {{-- Từ chối --}}
    @if(in_array($trangThaiHienTai, ['TAO_MOI', 'DA_DUYET_CAP_PHONG']) && $user->coQuyen('tu_choi_chung_tu'))
        <button type="submit" name="tu_choi" class="btn btn-outline-danger btn-xuly">
            ❌ Từ chối chứng từ
        </button>
    @endif
</div>





    </form>
</div>

{{-- JS hiển thị ô ghi chú khi bấm xử lý --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const buttons = document.querySelectorAll('.btn-xuly');
        const ghiChuContainer = document.getElementById('ghi-chu-container');
        buttons.forEach(btn => {
            btn.addEventListener('click', () => {
                ghiChuContainer.classList.remove('d-none');
            });
        });
    });
</script>














            {{-- 📎 Khu vực file đính kèm --}}
            <div class="mb-4">
                <h5 class="text-primary">📎 File đính kèm</h5>
                @php
                    $fileExtension = pathinfo($chungTu->duong_dan, PATHINFO_EXTENSION);
                    $fileUrl = route('chungtu.viewFile', $chungTu->id);
                @endphp

                <div id="file-preview-loading" class="text-center text-muted py-3">
                    <div class="spinner-border text-primary mb-2" role="status"></div><br>
                    Đang tải file, vui lòng chờ...
                </div>

                <div id="file-preview-content" class="border rounded mt-2 p-2 bg-light d-none">
                    @if ($fileExtension === 'pdf')
                        <iframe id="preview-frame" src="{{ $fileUrl }}" width="100%" height="600px" class="border" onload="hideLoading()"></iframe>
                    @elseif (in_array($fileExtension, ['doc', 'docx', 'xls', 'xlsx']))
                        <iframe id="preview-frame" src="https://view.officeapps.live.com/op/embed.aspx?src={{ urlencode($fileUrl) }}" width="100%" height="600px" class="border" onload="hideLoading()"></iframe>
                    @else
                        <a href="{{ $fileUrl }}" target="_blank" class="btn btn-outline-primary mt-2">Tải xuống file</a>
                        <script>hideLoading();</script>
                    @endif
                </div>
            </div>

            {{-- 🔙 Nút quay lại danh sách --}}
            <a href="{{ route('chungtu.index') }}" class="btn btn-secondary">← Quay lại danh sách</a>
        </div>
    </div>
</div>

{{-- 📜 Script xử lý khi file preview tải xong --}}
<script>
    function hideLoading() {
        document.getElementById('file-preview-loading')?.classList.add('d-none');
        document.getElementById('file-preview-content')?.classList.remove('d-none');
    }
</script>
@endsection
