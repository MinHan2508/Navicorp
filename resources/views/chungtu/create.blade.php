@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h1 class="mb-4 text-primary">📝 Tạo mới Chứng từ</h1>

    {{-- Thông báo lỗi tổng quát --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Đã có lỗi xảy ra:</strong>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('chungtu.store') }}" method="POST" enctype="multipart/form-data" class="shadow p-4 rounded bg-light">
        @csrf

        {{-- Người tạo --}}
        <div class="form-group mb-3">
            <label class="form-label">Người tạo</label>
            <input type="text" class="form-control" value="{{ auth()->user()->email }}" disabled>
            <input type="hidden" name="id_nguoi_tao" value="{{ auth()->user()->id }}">
        </div>

        {{-- Hướng chứng từ --}}
        <div class="form-group mb-3">
    <label for="id_huong" class="form-label">Hướng Chứng Từ</label>
    <select name="id_huong" id="id_huong" class="form-select @error('id_huong') is-invalid @enderror" required>
        <option value="">-- Chọn Hướng --</option>
        @foreach($huongChungTus as $huong)
            <option value="{{ $huong->id }}"
                data-ma="{{ $huong->ma_huong_chung_tu }}"
                {{ old('id_huong', $chungTu->id_huong ?? '') == $huong->id ? 'selected' : '' }}>
                {{ $huong->ten_huong_chung_tu }}
            </option>
        @endforeach
    </select>
    @error('id_huong')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

        {{-- Đối tác/Đơn vị gửi --}}
        
        <div id="doiTacGroup" class="form-group mb-3" style="display: none;">
    <label for="id_nguoi_gui_doi_tac" class="form-label">Đối tác/ Đơn vị gửi bên ngoài</label>
    <select name="id_nguoi_gui_doi_tac" id="id_nguoi_gui_doi_tac" class="form-select @error('id_nguoi_gui_doi_tac') is-invalid @enderror">
        <option value="">-- Chọn Đối Tác --</option>
        @foreach($doiTacs as $doiTac)
            <option value="{{ $doiTac->id }}"
                {{ old('id_nguoi_gui_doi_tac', $chungTu->id_nguoi_gui_doi_tac ?? '') == $doiTac->id ? 'selected' : '' }}>
                {{ $doiTac->ten_doi_tac }}
            </option>
        @endforeach
    </select>
    @error('id_nguoi_gui_doi_tac')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

     

        {{-- Mã & tiêu đề --}}
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="ma_chung_tu" class="form-label">Mã Chứng Từ</label>
                <input type="text" name="ma_chung_tu" id="ma_chung_tu" class="form-control @error('ma_chung_tu') is-invalid @enderror" value="{{ old('ma_chung_tu') }}" required>
                @error('ma_chung_tu')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label for="tieu_de" class="form-label">Tiêu Đề</label>
                <input type="text" name="tieu_de" id="tieu_de" class="form-control @error('tieu_de') is-invalid @enderror" value="{{ old('tieu_de') }}" required>
                @error('tieu_de')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        {{-- Số hiệu & nơi ban hành --}}
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="so_hieu" class="form-label">Số Hiệu</label>
                <input type="text" name="so_hieu" id="so_hieu" class="form-control" value="{{ old('so_hieu') }}">
            </div>
            <div class="col-md-6 mb-3">
                <label for="noi_ban_hanh" class="form-label">Nơi Ban Hành</label>
                <input type="text" name="noi_ban_hanh" id="noi_ban_hanh" class="form-control" value="{{ old('noi_ban_hanh') }}">
            </div>
        </div>

        {{-- Trích yếu --}}
        <div class="form-group mb-3">
            <label for="trich_yeu" class="form-label">Trích Yếu</label>
            <textarea name="trich_yeu" id="trich_yeu" class="form-control" rows="2">{{ old('trich_yeu') }}</textarea>
        </div>

        {{-- Ngày tháng --}}
        <div class="row">
            <div class="col-md-4 mb-3">
                <label for="ngay_ban_hanh" class="form-label">Ngày Ban Hành</label>
                <input type="date" name="ngay_ban_hanh" id="ngay_ban_hanh" class="form-control" value="{{ old('ngay_ban_hanh') }}">
            </div>
            <div class="col-md-4 mb-3">
                <label for="ngay_hieu_luc" class="form-label">Ngày Hiệu Lực</label>
                <input type="date" name="ngay_hieu_luc" id="ngay_hieu_luc" class="form-control" value="{{ old('ngay_hieu_luc') }}">
            </div>
            <div class="col-md-4 mb-3">
                <label for="ngay_het_hieu_luc" class="form-label">Ngày Hết Hiệu Lực</label>
                <input type="date" name="ngay_het_hieu_luc" id="ngay_het_hieu_luc" class="form-control" value="{{ old('ngay_het_hieu_luc') }}">
            </div>
        </div>

        {{-- Ký số --}}
        <div class="form-check mb-3">
            <input type="checkbox" name="ky_so" id="ky_so" class="form-check-input" value="1" {{ old('ky_so') ? 'checked' : '' }}>
            <label for="ky_so" class="form-check-label">Ký số</label>
        </div>

        {{-- Loại chứng từ --}}
        <div class="form-group mb-3">
            <label for="id_loai_chung_tu" class="form-label">Loại Chứng Từ</label>
            <select name="id_loai_chung_tu" id="id_loai_chung_tu" class="form-select @error('id_loai_chung_tu') is-invalid @enderror" required>
                <option value="">-- Chọn Loại Chứng Từ --</option>
                @foreach($loaiChungTus as $loai)
                    <option value="{{ $loai->id }}" {{ old('id_loai_chung_tu') == $loai->id ? 'selected' : '' }}>
                        {{ $loai->ten_loai_chung_tu }}
                    </option>
                @endforeach
            </select>
            @error('id_loai_chung_tu')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- File đính kèm --}}
        <div class="form-group mb-3">
            <label for="duong_dan" class="form-label">Tải lên File Chứng Từ</label>
            <input type="file" name="duong_dan" id="duong_dan" class="form-control @error('duong_dan') is-invalid @enderror" accept=".pdf,.doc,.docx,.xlsx,.xls" required>
            @error('duong_dan')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Ghi chú --}}
        <div class="form-group mb-3">
            <label for="ghi_chu" class="form-label">Ghi Chú</label>
            <textarea name="ghi_chu" id="ghi_chu" class="form-control" rows="3">{{ old('ghi_chu') }}</textarea>
        </div>

        {{-- Submit --}}
        <button type="submit" class="btn btn-primary">💾 Lưu</button>
        <a href="{{ route('chungtu.index') }}" class="btn btn-secondary">← Quay lại</a>
    </form>
</div>


<script>
document.addEventListener('DOMContentLoaded', function () {
    const huongSelect = document.getElementById('id_huong');
    const doiTacGroup = document.getElementById('doiTacGroup');

    function toggleDoiTac() {
        const selected = huongSelect.options[huongSelect.selectedIndex];
        const maHuong = selected.getAttribute('data-ma') || '';
        if (maHuong.startsWith('DEN_')) {
            doiTacGroup.style.display = 'block';
        } else {
            doiTacGroup.style.display = 'none';
            document.getElementById('id_nguoi_gui_doi_tac').value = ''; // reset nếu không phải hướng đến
        }
    }

    // Run on load + on change
    toggleDoiTac();
    huongSelect.addEventListener('change', toggleDoiTac);
});
</script>




@endsection
