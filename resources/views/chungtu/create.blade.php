@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Tạo mới Chứng từ</h1>
    <form action="{{ route('chungtu.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

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
            <input type="text" name="ma_chung_tu" id="ma_chung_tu" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="tieu_de">Tiêu Đề</label>
            <input type="text" name="tieu_de" id="tieu_de" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="id_loai_chung_tu">Loại Chứng Từ</label>
            <select name="id_loai_chung_tu" id="id_loai_chung_tu" class="form-control" required>
                <option value="">-- Chọn Loại Chứng Từ --</option>
                @foreach($loaiChungTus as $loaiChungTu)
                    <option value="{{ $loaiChungTu->id }}">{{ $loaiChungTu->ten_loai_chung_tu }}</option>
                @endforeach
            </select>
        </div>



          <div class="form-group">
            <label for="duong_dan">Tải lên File Chứng Từ</label>
            <input type="file" name="duong_dan" id="duong_dan" class="form-control" accept=".pdf,.doc,.docx,.xlsx,.xls" required>
        </div>

        <div class="form-group">
            <label for="ghi_chu">Ghi Chú</label>
            <textarea name="ghi_chu" id="ghi_chu" class="form-control"></textarea>
        </div>
        
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
                    <option value="{{ $trangThai->id }}">{{ $trangThai->ten_trang_thai }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary mt-3">Lưu</button>
    </form>
</div>
@endsection