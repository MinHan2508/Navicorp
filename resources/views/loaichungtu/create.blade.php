@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Tạo Loại Chứng Từ Mới</h1>
    <form action="{{ route('loaichungtu.store') }}" method="POST">
        @csrf
        <div class="form-group mb-3">
            <label for="ma_loai_chung_tu">Mã Loại Chứng Từ</label>
            <input type="text" name="ma_loai_chung_tu" id="ma_loai_chung_tu" class="form-control" value="{{ old('ma_loai_chung_tu') }}" required>
        </div>
        <div class="form-group mb-3">
            <label for="ten_loai_chung_tu">Tên Loại Chứng Từ</label>
            <input type="text" name="ten_loai_chung_tu" id="ten_loai_chung_tu" class="form-control" value="{{ old('ten_loai_chung_tu') }}" required>
        </div>
        <div class="form-group mb-3">
            <label for="ghi_chu">Ghi Chú</label>
            <textarea name="ghi_chu" id="ghi_chu" class="form-control">{{ old('ghi_chu') }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary">Lưu</button>
        <a href="{{ route('loaichungtu.index') }}" class="btn btn-secondary">Hủy</a>
    </form>
</div>
@endsection