<link rel="stylesheet" href="{{ asset('css/timeline.css') }}">
@extends('layouts.app')

@section('content')
<div class="container">

    {{-- Breadcrumb --}}
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-light px-3 py-2 rounded shadow-sm">
            <li class="breadcrumb-item"><a href="{{ route('chungtu.index') }}">📁 Danh sách chứng từ</a></li>
            <li class="breadcrumb-item active" aria-current="page">Chi tiết chứng từ</li>
        </ol>
    </nav>

    <h5 class="mt-5">📜 Sơ đồ timeline xử lý chứng từ</h5>

<div class="timeline-wrapper mt-4">
    {{-- Bước 0: Khởi tạo --}}
    <div class="timeline-step">
        <div class="timeline-icon bg-secondary">
            <span>00</span>
        </div>
        <div class="timeline-content">
            <div class="timeline-date">
                {{ $chungTu->created_at->format('d/m/Y') }}
            </div>
            <div class="timeline-title">
                Khởi tạo chứng từ
            </div>
            <div class="timeline-sub">
                Người tạo: {{ $chungTu->nguoiTao->name ?? 'Không xác định' }}
            </div>
            <div class="timeline-note">
                📝 Hệ thống ghi nhận khởi tạo.
            </div>
        </div>
    </div>

    {{-- Các bước xử lý tiếp theo --}}
    @foreach($lichSu as $index => $ls)
        <div class="timeline-step">
            <div class="timeline-icon">
                <span>{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</span>
            </div>
            <div class="timeline-content">
                <div class="timeline-date">
                    {{ $ls->created_at->format('d/m/Y') }}
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
































    <div class="card shadow-sm border-0">
        <div class="card-body">

            {{-- Thông tin chứng từ --}}
            <div class="row mb-3">
                <div class="col-md-6"><strong>Mã Chứng Từ:</strong> {{ $chungTu->ma_chung_tu }}</div>
                <div class="col-md-6"><strong>Tiêu Đề:</strong> {{ $chungTu->tieu_de }}</div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6"><strong>Số Hiệu:</strong> {{ $chungTu->so_hieu ?? '-' }}</div>
                <div class="col-md-6"><strong>Trạng Thái:</strong> 
                    <span class="badge bg-info">{{ $chungTu->trangThai->ten_trang_thai ?? '-' }}</span>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6"><strong>Loại Chứng Từ:</strong> {{ $chungTu->loaiChungTu->ten_loai_chung_tu ?? '-' }}</div>
                <div class="col-md-6"><strong>Hướng:</strong> {{ $chungTu->huong->ten_huong ?? '-' }}</div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6"><strong>Nơi Ban Hành:</strong> {{ $chungTu->noi_ban_hanh ?? '-' }}</div>
                <div class="col-md-6"><strong>Trích Yếu:</strong> {{ $chungTu->trich_yeu ?? '-' }}</div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <strong>Ngày Ban Hành:</strong>
                    {{ optional($chungTu->ngay_ban_hanh)->format('d/m/Y') ?? '-' }}
                </div>
                <div class="col-md-6">
                    <strong>Hiệu Lực:</strong>
                    {{ optional($chungTu->ngay_hieu_luc)->format('d/m/Y') ?? '-' }} - 
                    {{ optional($chungTu->ngay_het_hieu_luc)->format('d/m/Y') ?? 'Không xác định' }}
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

            {{-- Xử lý chứng từ --}}
            <div class="mb-4">
                <h5 class="text-primary">⚙️ Xử lý chứng từ</h5>
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                <form method="POST" action="{{ route('chungtu.xuly', $chungTu->id) }}">
                    @csrf
                    <textarea name="ghi_chu" class="form-control mb-2" placeholder="Ghi chú (nếu có)">{{ old('ghi_chu') }}</textarea>
                    <div class="d-flex flex-wrap gap-2">
                        @if(isset($quyTrinhXuLy) && $quyTrinhXuLy->count())
                            @foreach ($quyTrinhXuLy as $buoc)
                                <button type="submit" name="thu_tu" value="{{ $buoc->thu_tu }}" class="btn btn-success">
                                    ✅ {{ $buoc->mo_ta }}
                                </button>
                            @endforeach
                        @else
                            <span class="text-muted">Không có bước xử lý kế tiếp.</span>
                        @endif

                        @if(in_array($chungTu->id_trang_thai_hien_tai, [1, 2]) ||
                            in_array(optional($chungTu->trangThai)->ma_trang_thai, ['DUYET_CAP_PHONG', 'TAO_MOI']))
                            <button type="submit" name="tu_choi" class="btn btn-outline-danger">
                                ❌ Từ chối chứng từ
                            </button>
                        @endif
                    </div>
                </form>
            </div>

            {{-- File đính kèm --}}
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
                        <iframe id="preview-frame" src="{{ $fileUrl }}" width="100%" height="800px" class="border" onload="hideLoading()"></iframe>
                    @elseif (in_array($fileExtension, ['doc', 'docx', 'xls', 'xlsx']))
                        <iframe id="preview-frame" src="https://view.officeapps.live.com/op/embed.aspx?src={{ urlencode($fileUrl) }}" width="100%" height="600px" class="border" onload="hideLoading()"></iframe>
                    @else
                        <a href="{{ $fileUrl }}" target="_blank" class="btn btn-outline-primary mt-2">Tải xuống file</a>
                        <script>hideLoading();</script>
                    @endif
                </div>
            </div>

            {{-- Quay lại --}}
            <a href="{{ route('chungtu.index') }}" class="btn btn-secondary">← Quay lại danh sách</a>
        </div>
    </div>
</div>

{{-- JavaScript để ẩn loading khi file iframe đã tải --}}
<script>
    function hideLoading() {
        document.getElementById('file-preview-loading')?.classList.add('d-none');
        document.getElementById('file-preview-content')?.classList.remove('d-none');
    }
</script>
@endsection
