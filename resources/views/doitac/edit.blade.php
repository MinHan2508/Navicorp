@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h1 class="mb-4 text-primary">✏️ Chỉnh sửa Chứng từ</h1>
    <form action="{{ route('chungtu.update', $chungTu->id) }}" method="POST" enctype="multipart/form-data" class="shadow p-4 rounded bg-light">
        @csrf
        @method('PUT')

        <!-- Người Tạo -->
        <div class="form-group mb-3">
            <label for="nguoi_tao_id" class="form-label">Người Tạo</label>
            @if(auth()->check())
                <input type="text" class="form-control" value="{{ auth()->user()->email }}" disabled>
                <input type="hidden" name="nguoi_tao_id" id="nguoi_tao_id" value="{{ auth()->user()->id }}">
            @else
                <input type="text" class="form-control" value="Không xác định" disabled>
                <input type="hidden" name="nguoi_tao_id" id="nguoi_tao_id" value="">
            @endif
        </div>

        <!-- Người Gửi Đối Tác -->
        <div class="form-group mb-3">
            <label for="nguoi_gui_doi_tac_id" class="form-label">Người Gửi Đối Tác</label>
            <select name="nguoi_gui_doi_tac_id" id="nguoi_gui_doi_tac_id" class="form-select">
                <option value="">-- Chọn Người Gửi Đối Tác --</option>
                @foreach($doiTacs as $doiTac)
                    <option value="{{ $doiTac->id }}" {{ $chungTu->nguoi_gui_doi_tac_id == $doiTac->id ? 'selected' : '' }}>
                        {{ $doiTac->ten_doi_tac }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Mã Chứng Từ -->
        <div class="form-group mb-3">
            <label for="ma_chung_tu" class="form-label">Mã Chứng Từ</label>
            <input type="text" name="ma_chung_tu" id="ma_chung_tu" class="form-control" value="{{ $chungTu->ma_chung_tu }}" required>
        </div>

        <!-- Tiêu Đề -->
        <div class="form-group mb-3">
            <label for="tieu_de" class="form-label">Tiêu Đề</label>
            <input type="text" name="tieu_de" id="tieu_de" class="form-control" value="{{ $chungTu->tieu_de }}" required>
        </div>

        <!-- Loại Chứng Từ -->
        <div class="form-group mb-3">
            <label for="id_loai_chung_tu" class="form-label">Loại Chứng Từ</label>
            <select name="id_loai_chung_tu" id="id_loai_chung_tu" class="form-select" required>
                <option value="">-- Chọn Loại Chứng Từ --</option>
                @foreach($loaiChungTus as $loaiChungTu)
                    <option value="{{ $loaiChungTu->id }}" {{ $chungTu->id_loai_chung_tu == $loaiChungTu->id ? 'selected' : '' }}>
                        {{ $loaiChungTu->ten_loai_chung_tu }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Tải lên File -->
        <div class="form-group mb-3">
            <label for="duong_dan" class="form-label">Tải lên File Chứng Từ</label>
            <input type="file" name="duong_dan" id="duong_dan" class="form-control" accept=".pdf,.doc,.docx,.xlsx,.xls">
            @if($chungTu->duong_dan)
                <p class="mt-2">File hiện tại: <a href="{{ asset('storage/' . $chungTu->duong_dan) }}" target="_blank">Tải xuống</a></p>
            @endif
        </div>

        <!-- Ghi Chú -->
        <div class="form-group mb-3">
            <label for="ghi_chu" class="form-label">Ghi Chú</label>
            <textarea name="ghi_chu" id="ghi_chu" class="form-control" rows="3">{{ $chungTu->ghi_chu }}</textarea>
        </div>

        <!-- Trạng Thái -->
        <div class="form-group mb-3">
            <label for="trang_thai_id" class="form-label">Trạng Thái</label>
            <select name="trang_thai_id" id="trang_thai_id" class="form-select" required>
                <option value="">-- Chọn Trạng Thái --</option>
                @foreach($trangThaiChungTus as $trangThai)
                    <option value="{{ $trangThai->id }}" {{ $chungTu->trang_thai_id == $trangThai->id ? 'selected' : '' }}>
                        {{ $trangThai->ten_trang_thai }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Nút Lưu -->
        <button type="submit" class="btn btn-primary">💾 Cập nhật</button>
        <a href="{{ route('chungtu.index') }}" class="btn btn-secondary">← Quay lại</a>
    </form>
</div>
@endsection
