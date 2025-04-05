@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h2 class="mb-4 text-success">➕ Thêm mới Đối tác</h2>

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

    <form action="{{ route('doitac.store') }}" method="POST">
        @csrf

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Tên đối tác</label>
                <input type="text" name="ten_doi_tac" class="form-control" value="{{ old('ten_doi_tac') }}" required>
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Loại đối tác</label>
                <select name="loai_doi_tac" class="form-select" required>
                    <option value="">-- Chọn loại --</option>
                    @foreach(['Cá nhân', 'Tổ chức', 'Nhà Nước', 'Khác'] as $loai)
                        <option value="{{ $loai }}" {{ old('loai_doi_tac') == $loai ? 'selected' : '' }}>{{ $loai }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Số điện thoại</label>
                <input type="text" name="sdt" class="form-control" value="{{ old('sdt') }}">
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" value="{{ old('email') }}">
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Mã số thuế</label>
                <input type="text" name="ma_so_thue" class="form-control" value="{{ old('ma_so_thue') }}">
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Fax</label>
                <input type="text" name="fax" class="form-control" value="{{ old('fax') }}">
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Người đại diện</label>
                <input type="text" name="nguoi_dai_dien" class="form-control" value="{{ old('nguoi_dai_dien') }}">
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Chức vụ đại diện</label>
                <input type="text" name="chuc_vu_dai_dien" class="form-control" value="{{ old('chuc_vu_dai_dien') }}">
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Website</label>
                <input type="text" name="website" class="form-control" value="{{ old('website') }}">
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Địa chỉ</label>
                <input type="text" name="dia_chi" class="form-control" value="{{ old('dia_chi') }}">
            </div>

            <div class="col-12 mb-3">
                <label class="form-label">Ghi chú</label>
                <textarea name="ghi_chu" class="form-control" rows="3">{{ old('ghi_chu') }}</textarea>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">💾 Lưu</button>
        <a href="{{ route('doitac.index') }}" class="btn btn-secondary">← Quay lại</a>
    </form>
</div>
@endsection
