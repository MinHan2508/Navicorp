@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Chỉnh sửa Chứng từ</h1>
    <form action="{{ route('chungtu.update', $chungTu->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="nguoi_tao_id">Người Tạo</label>
            @if(auth()->check())
                <input type="text" class="form-control" value="{{ auth()->user()->email }}" disabled>
                <input type="hidden" name="nguoi_tao_id" id="nguoi_tao_id" value="{{ auth()->user()->id }}">
            @else
                <input type="text" class="form-control" value="Không xác định" disabled>
                <input type="hidden" name="nguoi_tao_id" id="nguoi_tao_id" value="">
            @endif
        </div>

        <div class="form-group">
            <label for="ma_chung_tu">Mã Chứng Từ</label>
            <input type="text" name="ma_chung_tu" id="ma_chung_tu" class="form-control" value="{{ $chungTu->ma_chung_tu }}" required>
        </div>
        <div class="form-group">
            <label for="tieu_de">Tiêu Đề</label>
            <input type="text" name="tieu_de" id="tieu_de" class="form-control" value="{{ $chungTu->tieu_de }}" required>
        </div>

        <div class="form-group">
    <label for="id_loai_chung_tu">Loại Chứng Từ</label>
    <select name="id_loai_chung_tu" id="id_loai_chung_tu" class="form-control" required>
        <option value="">-- Chọn Loại Chứng Từ --</option>
        @foreach($loaiChungTus as $loaiChungTu)
            <option value="{{ $loaiChungTu->id }}"
                {{ $chungTu->id_loai_chung_tu == $loaiChungTu->id ? 'selected' : '' }}>
                {{ $loaiChungTu->ten_loai_chung_tu }}
            </option>
        @endforeach
    </select>
</div>


        <div class="form-group">
            <label for="duong_dan">Tải lên File Chứng Từ</label>
            <input type="file" name="duong_dan" id="duong_dan" class="form-control" accept=".pdf,.doc,.docx,.xlsx,.xls">
            @if($chungTu->duong_dan)
                <p class="mt-2">File hiện tại: <a href="{{ asset('storage/' . $chungTu->duong_dan) }}" target="_blank">Tải xuống</a></p>
            @endif
        </div>

        <div class="form-group">
            <label for="ghi_chu">Ghi Chú</label>
            <textarea name="ghi_chu" id="ghi_chu" class="form-control">{{ $chungTu->ghi_chu }}</textarea>
        </div>

        <div class="form-group">
            <label for="nguoi_gui_doi_tac_id">Người Gửi Đối Tác</label>
            <select name="nguoi_gui_doi_tac_id" id="nguoi_gui_doi_tac_id" class="form-control">
                <!-- Nếu cần, bạn có thể thêm dữ liệu người gửi đối tác -->
            </select>
        </div>

        <div class="form-group">
            <label for="trang_thai_id">Trạng Thái</label>
            <select name="trang_thai_id" id="trang_thai_id" class="form-control" required>
                <option value="">-- Chọn Trạng Thái --</option>
                @foreach($trangThaiChungTus as $trangThai)
                    <option value="{{ $trangThai->id }}" {{ $chungTu->trang_thai_id == $trangThai->id ? 'selected' : '' }}>
                        {{ $trangThai->ten_trang_thai }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary mt-3">Cập nhật</button>
    </form>
</div>
@endsection