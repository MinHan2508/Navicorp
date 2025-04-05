@extends('layouts.app')

@section('content')
<div class="container">
    {{-- Breadcrumb --}}
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-light px-3 py-2 rounded shadow-sm">
            <li class="breadcrumb-item"><a href="{{ route('chungtu.index') }}">📁 Danh sách chứng từ</a></li>
            <li class="breadcrumb-item active" aria-current="page">Chỉnh sửa chứng từ</li>
        </ol>
    </nav>

    <h2 class="mb-4 text-primary">📝 Chỉnh sửa Chứng từ</h2>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <form action="{{ route('chungtu.update', $chungTu->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                {{-- Người tạo --}}
                <div class="mb-3">
                    <label for="nguoi_tao_id" class="form-label">Người Tạo</label>
                    <input type="text" class="form-control" value="{{ $chungTu->nguoiTao->email ?? 'Không xác định' }}" disabled>
                    <input type="hidden" name="id_nguoi_tao" value="{{ $chungTu->id_nguoi_tao }}">
                </div>

                {{-- Mã, Tiêu đề, Số hiệu --}}
                <div class="mb-3">
                    <label for="ma_chung_tu" class="form-label">Mã Chứng Từ</label>
                    <input type="text" name="ma_chung_tu" class="form-control" value="{{ $chungTu->ma_chung_tu }}" required>
                </div>

                <div class="mb-3">
                    <label for="tieu_de" class="form-label">Tiêu Đề</label>
                    <input type="text" name="tieu_de" class="form-control" value="{{ $chungTu->tieu_de }}" required>
                </div>

                <div class="mb-3">
                    <label for="so_hieu" class="form-label">Số Hiệu</label>
                    <input type="text" name="so_hieu" class="form-control" value="{{ $chungTu->so_hieu }}">
                </div>

                {{-- Trích yếu, nơi ban hành --}}
                <div class="mb-3">
                    <label for="trich_yeu" class="form-label">Trích Yếu</label>
                    <textarea name="trich_yeu" class="form-control">{{ $chungTu->trich_yeu }}</textarea>
                </div>

                <div class="mb-3">
                    <label for="noi_ban_hanh" class="form-label">Nơi Ban Hành</label>
                    <input type="text" name="noi_ban_hanh" class="form-control" value="{{ $chungTu->noi_ban_hanh }}">
                </div>

                {{-- Các ngày --}}
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="ngay_ban_hanh" class="form-label">Ngày Ban Hành</label>
                        <input type="date" name="ngay_ban_hanh" class="form-control" value="{{ $chungTu->ngay_ban_hanh }}">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="ngay_hieu_luc" class="form-label">Ngày Hiệu Lực</label>
                        <input type="date" name="ngay_hieu_luc" class="form-control" value="{{ $chungTu->ngay_hieu_luc }}">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="ngay_het_hieu_luc" class="form-label">Ngày Hết Hiệu Lực</label>
                        <input type="date" name="ngay_het_hieu_luc" class="form-control" value="{{ $chungTu->ngay_het_hieu_luc }}">
                    </div>
                </div>

                {{-- Ký số --}}
                <div class="mb-3">
                    <label for="ky_so" class="form-label">Ký Số</label>
                    <select name="ky_so" class="form-control">
                        <option value="0" {{ $chungTu->ky_so == 0 ? 'selected' : '' }}>Chưa ký</option>
                        <option value="1" {{ $chungTu->ky_so == 1 ? 'selected' : '' }}>Đã ký</option>
                    </select>
                </div>

                {{-- Loại chứng từ --}}
                <div class="mb-3">
                    <label for="id_loai_chung_tu" class="form-label">Loại Chứng Từ</label>
                    <select name="id_loai_chung_tu" class="form-control" required>
                        @foreach($loaiChungTus as $loai)
                            <option value="{{ $loai->id }}" {{ $chungTu->id_loai_chung_tu == $loai->id ? 'selected' : '' }}>
                                {{ $loai->ten_loai_chung_tu }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- File chứng từ --}}
                <div class="mb-3">
                    <label for="duong_dan" class="form-label">File Chứng Từ</label>
                    <input type="file" name="duong_dan" class="form-control">
                    @if($chungTu->duong_dan)
                        <small class="text-muted">File hiện tại: <a href="{{ route('chungtu.viewFile', $chungTu->id) }}" target="_blank">{{ $chungTu->duong_dan }}</a></small>
                    @endif
                </div>

                {{-- Ghi chú --}}
                <div class="mb-3">
                    <label for="ghi_chu" class="form-label">Ghi Chú</label>
                    <textarea name="ghi_chu" class="form-control">{{ $chungTu->ghi_chu }}</textarea>
                </div>

               
                {{-- Hướng xử lý --}}
                <div class="mb-3">
                    <label for="id_huong" class="form-label">Hướng Xử Lý</label>
                    <select name="id_huong" id="id_huong" class="form-control">
                        <option value="">-- Chọn hướng xử lý --</option>
                        @foreach($huongChungTus as $huong)
                            <option value="{{ $huong->id }}"
                                data-ma="{{ $huong->ma_huong_chung_tu }}"
                                {{ $chungTu->id_huong == $huong->id ? 'selected' : '' }}>
                                {{ $huong->ten_huong_chung_tu }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Người gửi đối tác (chỉ hiển thị nếu ma_huong bắt đầu bằng DEN_) --}}
                <div id="doiTacGroup" class="mb-3" style="display: none;">
                    <label for="id_nguoi_gui_doi_tac" class="form-label">Người Gửi Đối Tác</label>
                    <select name="id_nguoi_gui_doi_tac" id="id_nguoi_gui_doi_tac" class="form-control">
                        <option value="">-- Chọn đối tác --</option>
                        @foreach($doiTacs as $dt)
                            <option value="{{ $dt->id }}" {{ $chungTu->id_nguoi_gui_doi_tac == $dt->id ? 'selected' : '' }}>
                                {{ $dt->ten_doi_tac }}
                            </option>
                        @endforeach
                    </select>
                </div>







                <button type="submit" class="btn btn-primary">💾 Cập nhật</button>
                <a href="{{ route('chungtu.index') }}" class="btn btn-secondary">← Quay lại</a>
            </form>
        </div>
    </div>
</div>


<script>
    document.addEventListener('DOMContentLoaded', function () {
        const huongSelect = document.getElementById('id_huong');
        const doiTacGroup = document.getElementById('doiTacGroup');

        function toggleDoiTacGroup() {
            const selectedOption = huongSelect.options[huongSelect.selectedIndex];
            const maHuong = selectedOption?.getAttribute('data-ma') || '';
            if (maHuong.startsWith('DEN_')) {
                doiTacGroup.style.display = 'block';
            } else {
                doiTacGroup.style.display = 'none';
                document.getElementById('id_nguoi_gui_doi_tac').value = '';
            }
        }

        // Run on load + on change
        toggleDoiTacGroup();
        huongSelect.addEventListener('change', toggleDoiTacGroup);
    });
</script>



@endsection
