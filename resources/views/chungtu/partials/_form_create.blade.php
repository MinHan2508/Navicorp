@php
    // file: resources/views/chungtu/partials/_form_create.blade.php
@endphp


@php
    use Illuminate\Support\Str;
    $huong = App\Models\HuongChungTu::find($huongMacDinh);
@endphp

@if(isset($huong) && (Str::startsWith($huong->ma_huong_chung_tu, ['DEN', 'DI'])))
    {{-- Hiển thị nội dung nếu mã hướng bắt đầu bằng DEN_ --}}

    <div class="form-group mb-3">
        <label for="id_nguoi_gui_doi_tac" class="form-label">
            @if(isset($huong) && Str::startsWith($huong->ma_huong_chung_tu, 'DEN'))
                Đơn vị cung cấp chứng từ, văn bản
            @elseif(isset($huong) && Str::startsWith($huong->ma_huong_chung_tu, 'DI'))
                Đơn vị cần gửi
            @else
                Đối tác/ Đơn vị
            @endif
        </label>
        <div class="d-flex align-items-center gap-2">
            <!-- Thêm CSS của Select2 -->
            <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

            <select name="id_nguoi_gui_doi_tac" id="id_nguoi_gui_doi_tac"
                class="form-select @error('id_nguoi_gui_doi_tac') is-invalid @enderror" style="width: 85%">
                <option value="">-- Đơn vị / Đối Tác --</option>
                @foreach($doiTacs as $doiTac)
                    <option value="{{ $doiTac->id }}" {{ old('id_nguoi_gui_doi_tac', $chungTu->id_nguoi_gui_doi_tac ?? '') == $doiTac->id ? 'selected' : '' }}>
                        {{ $doiTac->ten_doi_tac }}{{ $doiTac->email ? ' - ' . $doiTac->email : '' }}
                    </option>
                @endforeach
            </select>
            <button type="button" class="btn btn-outline-success btn-sm" data-bs-toggle="modal"
                data-bs-target="#modalThemDoiTac">
                ➕
            </button>

            <!-- Thêm JS của Select2 và jQuery -->
            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

            <!-- Khởi tạo Select2 -->
            <script>
                $(document).ready(function () {
                    $('#id_nguoi_gui_doi_tac').select2({
                        placeholder: "-- Đơn vị / Đối Tác --",
                        allowClear: true,
                        width: '100%',
                        dropdownParent: $('#id_nguoi_gui_doi_tac').parent() // Đảm bảo dropdown hiển thị đúng trong modal (nếu có)
                    });

                    // Xử lý lỗi validation của Laravel
                    @if($errors->has('id_nguoi_gui_doi_tac'))
                        $('#id_nguoi_gui_doi_tac').next('.select2-container').addClass('is-invalid');
                    @endif
            });
            </script>
        </div>
        @error('id_nguoi_gui_doi_tac')
            @if($errors->has('id_nguoi_gui_doi_tac'))
                <div class="invalid-feedback">{{ $errors->first('id_nguoi_gui_doi_tac') }}</div>
            @endif
        @enderror
    </div>

@endif

@push('modals')
    @include('chungtu.partials._modal_them_doi_tac')
@endpush

{{-- Mã & tiêu đề --}}
<div class="row">
    <div class="col-md-6 mb-3">
        <label for="ma_chung_tu" class="form-label">Mã Chứng Từ</label>
        <input type="text" name="ma_chung_tu" id="ma_chung_tu"
            class="form-control @error('ma_chung_tu') is-invalid @enderror"
            value="{{ old('ma_chung_tu', $chungTu->ma_chung_tu ?? '') }}" required>
        @error('ma_chung_tu')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label for="tieu_de" class="form-label">Tiêu Đề</label>
        <input type="text" name="tieu_de" id="tieu_de" class="form-control @error('tieu_de') is-invalid @enderror"
            value="{{ old('tieu_de', $chungTu->tieu_de ?? '') }}" required>
        @error('tieu_de')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

{{-- Số hiệu & nơi ban hành --}}
<div class="row">
    <div class="col-md-6 mb-3">
        <label for="so_hieu" class="form-label">Số Hiệu</label>
        <input type="text" name="so_hieu" id="so_hieu" class="form-control"
            value="{{ old('so_hieu', $chungTu->so_hieu ?? '') }}">
    </div>
    <div class="col-md-6 mb-3">
        <label for="noi_ban_hanh" class="form-label">Nơi Ban Hành</label>
        <input type="text" name="noi_ban_hanh" id="noi_ban_hanh" class="form-control"
            value="{{ old('noi_ban_hanh', $chungTu->noi_ban_hanh ?? '') }}">
    </div>
</div>

{{-- Trích yếu --}}
<div class="form-group mb-3">
    <label for="trich_yeu" class="form-label">Trích Yếu</label>
    <textarea name="trich_yeu" id="trich_yeu" class="form-control"
        rows="2">{{ old('trich_yeu', $chungTu->trich_yeu ?? '') }}</textarea>
</div>

{{-- Ngày tháng --}}
<div class="row">
    <div class="col-md-4 mb-3">
        <label for="ngay_ban_hanh" class="form-label">Ngày Ban Hành</label>
        <input type="date" name="ngay_ban_hanh" id="ngay_ban_hanh" class="form-control"
            value="{{ old('ngay_ban_hanh', $chungTu->ngay_ban_hanh ?? '') }}">
    </div>
    <div class="col-md-4 mb-3">
        <label for="ngay_hieu_luc" class="form-label">Ngày Hiệu Lực</label>
        <input type="date" name="ngay_hieu_luc" id="ngay_hieu_luc" class="form-control"
            value="{{ old('ngay_hieu_luc', $chungTu->ngay_hieu_luc ?? '') }}">
    </div>
    <div class="col-md-4 mb-3">
        <label for="ngay_het_hieu_luc" class="form-label">Ngày Hết Hiệu Lực</label>
        <input type="date" name="ngay_het_hieu_luc" id="ngay_het_hieu_luc" class="form-control"
            value="{{ old('ngay_het_hieu_luc', $chungTu->ngay_het_hieu_luc ?? '') }}">
    </div>
</div>

{{-- Ký số --}}
<div class="form-check mb-3">
    <input type="checkbox" name="ky_so" id="ky_so" class="form-check-input" value="1" {{ old('ky_so', $chungTu->ky_so ?? false) ? 'checked' : '' }}>
    <label for="ky_so" class="form-check-label">Ký số</label>
</div>

{{-- Loại chứng từ --}}
<div class="form-group mb-3">
    <label for="id_loai_chung_tu" class="form-label">Loại Chứng Từ</label>
    <select name="id_loai_chung_tu" id="id_loai_chung_tu"
        class="form-select @error('id_loai_chung_tu') is-invalid @enderror" required>
        <option value="">-- Chọn Loại Chứng Từ --</option>
        @foreach($loaiChungTus as $loai)
            <option value="{{ $loai->id }}" {{ old('id_loai_chung_tu', $chungTu->id_loai_chung_tu ?? '') == $loai->id ? 'selected' : '' }}>
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
    <input type="file" name="duong_dan" id="duong_dan" class="form-control @error('duong_dan') is-invalid @enderror"
        accept=".pdf,.doc,.docx,.xlsx,.xls">
    @error('duong_dan')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

{{-- Ghi chú --}}
<div class="form-group mb-3">
    <label for="ghi_chu" class="form-label">Ghi Chú</label>
    <textarea name="ghi_chu" id="ghi_chu" class="form-control"
        rows="3">{{ old('ghi_chu', $chungTu->ghi_chu ?? '') }}</textarea>
</div>