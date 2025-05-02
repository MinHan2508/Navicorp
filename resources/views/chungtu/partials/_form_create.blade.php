<script src="{{ asset('js/hienthidoitac.js') }}"></script>

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
            <script src="{{ asset('js/hienthidoitac.js') }}"></script>
            <select name="id_nguoi_gui_doi_tac" id="id_nguoi_gui_doi_tac" class="form-select">
                <option value="">-- Chọn đối tác --</option>
                @foreach($doiTacs as $dt)
                    <option value="{{ $dt->id }}" data-ten="{{ $dt->ten_doi_tac }}" data-email="{{ $dt->email }}"
                        data-sdt="{{ $dt->sdt }}" data-diachi="{{ $dt->dia_chi }}" data-mst="{{ $dt->ma_so_thue }}"
                        data-nguoi="{{ $dt->nguoi_dai_dien }}" data-chucvu="{{ $dt->chuc_vu_dai_dien }}"
                        data-fax="{{ $dt->fax }}" data-website="{{ $dt->website }}" data-ghichu="{{ $dt->ghi_chu }}">
                        {{ $dt->ten_doi_tac }} ({{ $dt->email }})
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
{{-- Input chọn file từ đối tác --}}
<input type="hidden" name="ky_so" id="input-ky-so" value="0">
<div class="mb-3">
    <label for="duong_dan" class="form-label">📎 File chứng từ </label>
    <input type="file" class="form-control" name="duong_dan" id="duong_dan" accept=".pdf,.docx,.xml"
        onchange="kiemTraKySo()">


    {{-- Khung hiển thị thông tin ký số --}}
    <div id="thong-tin-ky-so" class="mt-3 d-none">
        {{-- Trường hợp file đã ký số --}}
        <div class="alert alert-success p-2" id="thong-tin-ok" style="display: none;">
            <strong>✔️ File đã được ký số.</strong>
            <ul class="mb-0 small">
                <li><strong>Đơn vị ký:</strong> <span id="dv-ky"></span></li>
                <li><strong>Thời gian ký:</strong> <span id="tg-ky"></span></li>
                <li><strong>Chủ thể:</strong> <span id="ct-ky"></span></li>
            </ul>
        </div>

        {{-- Trường hợp chưa được ký --}}
        <div class="alert alert-danger p-2" id="thong-tin-fail" style="display: none;">
            ❌ <span id="msg-loi"></span>
        </div>
    </div>

</div>


{{-- Ghi chú --}}
<div class="form-group mb-3">
    <label for="ghi_chu" class="form-label">Ghi Chú</label>
    <textarea name="ghi_chu" id="ghi_chu" class="form-control"
        rows="3">{{ old('ghi_chu', $chungTu->ghi_chu ?? '') }}</textarea>
</div>


<!-- //kiểm tra chứng từ có ký số hay không -->

<script>
    function kiemTraKySo() {
        const input = document.getElementById('duong_dan');
        const file = input.files[0];
        if (!file) return;

        const formData = new FormData();
        formData.append("file", file);

        fetch("{{ route('kiemtra.handle') }}", {
            method: "POST",
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: formData
        })
            .then(res => res.json())
            .then(data => {
                document.getElementById("thong-tin-ky-so").classList.remove("d-none");
                const kySoInput = document.getElementById("input-ky-so");

                if (data.success) {
                    // ✅ Cập nhật input = 1 nếu file đã ký số
                    kySoInput.value = 1;

                    document.getElementById("thong-tin-ok").style.display = "block";
                    document.getElementById("thong-tin-fail").style.display = "none";
                    document.getElementById("dv-ky").innerText = data.data?.don_vi_ky ?? 'Không rõ';
                    document.getElementById("tg-ky").innerText = data.data?.signing_time ?? 'Không rõ';
                    document.getElementById("ct-ky").innerText = data.data?.subject ?? 'Không có';
                } else {
                    // ❌ Nếu không có chữ ký số → input = 0
                    kySoInput.value = 0;

                    document.getElementById("thong-tin-ok").style.display = "none";
                    document.getElementById("thong-tin-fail").style.display = "block";
                    document.getElementById("msg-loi").innerText = data.msg;
                }
            })
            .catch(err => {
                alert("Lỗi kiểm tra chữ ký số: " + err);
            });
    }
</script>