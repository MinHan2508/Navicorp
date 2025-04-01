@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h1 class="mb-4 text-primary">📝 Tạo mới Chứng từ</h1>
    <form action="{{ route('chungtu.store') }}" method="POST" enctype="multipart/form-data" class="shadow p-4 rounded bg-light">
        @csrf

        <!-- Người Tạo -->
        <div class="form-group mb-3">
            <label for="nguoi_tao_id" class="form-label">Người Tạo/Tiếp nhận chứng từ</label>
            @if(auth()->check())
                <input type="text" class="form-control" value="{{ auth()->user()->email }}" disabled>
                <input type="hidden" name="nguoi_tao_id" id="nguoi_tao_id" value="{{ auth()->user()->id }}">
            @else
                <input type="text" class="form-control" value="Không xác định" disabled>
                <input type="hidden" name="nguoi_tao_id" id="nguoi_tao_id" value="">
            @endif
        </div>

        <!-- Tiếp Nhận Chứng Từ Bên Ngoài -->
        <div class="form-group mb-3">
            <div class="form-check">
            <input type="checkbox" class="form-check-input" id="tiep_nhan_ben_ngoai" name="tiep_nhan_ben_ngoai" value="1">
            <label class="form-check-label" for="tiep_nhan_ben_ngoai">Tiếp nhận chứng từ bên ngoài</label>
            </div>
        </div>

        <!-- Người Gửi Đối Tác -->
        <div class="form-group mb-3" id="nguoi_gui_doi_tac_section" style="display: none;">
            <label for="nguoi_gui_doi_tac_id" class="form-label">Người Gửi Đối Tác</label>
            @if($doiTacs->isEmpty())
            <p class="text-danger">Không có đối tác nào để chọn.</p>
            @else
            <select name="nguoi_gui_doi_tac_id" id="nguoi_gui_doi_tac_id" class="form-select">
                <option value="">-- Chọn Người Gửi Đối Tác --</option>
                @foreach($doiTacs as $doiTac)
                <option value="{{ $doiTac->id }}">{{ $doiTac->ten_doi_tac }}</option>
                @endforeach
            </select>
            @endif
        </div>

        <script>
            document.getElementById('tiep_nhan_ben_ngoai').addEventListener('change', function() {
            const section = document.getElementById('nguoi_gui_doi_tac_section');
            section.style.display = this.checked ? 'block' : 'none';
            });
        </script>

        

        <!-- Mã Chứng Từ -->
        <div class="form-group mb-3">
            <label for="ma_chung_tu" class="form-label">Mã Chứng Từ</label>
            <input type="text" name="ma_chung_tu" id="ma_chung_tu" class="form-control" required>
        </div>

        <!-- Tiêu Đề -->
        <div class="form-group mb-3">
            <label for="tieu_de" class="form-label">Tiêu Đề</label>
            <input type="text" name="tieu_de" id="tieu_de" class="form-control" required>
        </div>

        <!-- Loại Chứng Từ -->
        <div class="form-group mb-3">
            <label for="id_loai_chung_tu" class="form-label">Loại Chứng Từ</label>
            <select name="id_loai_chung_tu" id="id_loai_chung_tu" class="form-select" required>
                <option value="">-- Chọn Loại Chứng Từ --</option>
                @foreach($loaiChungTus as $loaiChungTu)
                    <option value="{{ $loaiChungTu->id }}">{{ $loaiChungTu->ten_loai_chung_tu }}</option>
                @endforeach
            </select>
        </div>

        <!-- Tải lên File -->
        <div class="form-group mb-3">
            <label for="duong_dan" class="form-label">Tải lên File Chứng Từ</label>
            <input type="file" name="duong_dan" id="duong_dan" class="form-control" accept=".pdf,.doc,.docx,.xlsx,.xls" required>
        </div>

        <!-- Ghi Chú -->
        <div class="form-group mb-3">
            <label for="ghi_chu" class="form-label">Ghi Chú</label>
            <textarea name="ghi_chu" id="ghi_chu" class="form-control" rows="3"></textarea>
        </div>

      

        <!-- Nút Lưu -->
        <button type="submit" class="btn btn-primary">💾 Lưu</button>
        <a href="{{ route('chungtu.index') }}" class="btn btn-secondary">← Quay lại</a>
    </form>
</div>
@endsection