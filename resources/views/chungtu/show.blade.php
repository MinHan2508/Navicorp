@extends('layouts.app')

@section('content')
<div class="container">

    {{--  Breadcrumb --}}
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-light px-3 py-2 rounded shadow-sm">
            <li class="breadcrumb-item"><a href="{{ route('chungtu.index') }}">📁 Danh sách chứng từ</a></li>
            <li class="breadcrumb-item active" aria-current="page">Chi tiết chứng từ</li>
        </ol>
    </nav>

    <h2 class="mb-4 text-primary">🧾 Chi tiết Chứng từ:  {{ $chungTu->ma_chung_tu }}</h2>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-6"><strong>Mã Chứng Từ:</strong> {{ $chungTu->ma_chung_tu }}</div>
                <div class="col-md-6"><strong>Tiêu Đề:</strong> {{ $chungTu->tieu_de }}</div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <strong>Loại Chứng Từ:</strong> {{ $chungTu->loaiChungTu->ten_loai_chung_tu}}
                </div>
                <div class="col-md-6"><strong>Trạng Thái:</strong> {{ $chungTu->trangThai->ten_trang_thai }}</div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6"><strong>Người Tạo:</strong> {{ $chungTu->nguoiTao->name ?? 'N/A' }}</div>
                <div class="col-md-6"><strong>Ngày Tạo:</strong> {{ $chungTu->created_at->format('d/m/Y H:i') }}</div>
            </div>
            <div class="row mb-3">
            <div class="col-md-6"><strong>Ghi Chú:</strong> {{ $chungTu->ghi_chu ?? 'Không có' }}</div>
            </div>

            {{-- ✅ Xem file --}}
            <div class="mb-4">
                <strong>📎 File đính kèm:</strong>
                @php
                    $fileExtension = pathinfo($chungTu->duong_dan, PATHINFO_EXTENSION);
                    $fileUrl = route('chungtu.viewFile', $chungTu->id);
                @endphp

                {{-- ✅ Loading effect --}}
                <div id="file-preview-loading" class="text-center text-muted py-3">
                    <div class="spinner-border text-primary mb-2" role="status"></div><br>
                    Đang tải file, vui lòng chờ...
                </div>

                <div id="file-preview-content" class="border rounded mt-2 p-2 bg-light d-none">
                    @if($fileExtension === 'pdf')
                        <iframe id="preview-frame" src="{{ $fileUrl }}" width="100%" height="600px" class="border" onload="hideLoading()"></iframe>
                    @elseif(in_array($fileExtension, ['doc', 'docx', 'xls', 'xlsx']))
                        <iframe id="preview-frame" src="https://view.officeapps.live.com/op/embed.aspx?src={{ rawurlencode($fileUrl) }}" width="100%" height="600px" class="border" onload="hideLoading()"></iframe>
                    @else
                        <a href="{{ $fileUrl }}" target="_blank" class="btn btn-outline-primary mt-2">Tải xuống file</a>
                        <script>hideLoading();</script>
                    @endif
                </div>
            </div>

            <a href="{{ route('chungtu.index') }}" class="btn btn-secondary">
                ← Quay lại danh sách
            </a>
        </div>
    </div>
</div>

{{-- ✅ JavaScript: Ẩn loading khi iframe đã load --}}
<script>
    function hideLoading() {
        document.getElementById('file-preview-loading')?.classList.add('d-none');
        document.getElementById('file-preview-content')?.classList.remove('d-none');
    }
</script>
@endsection
