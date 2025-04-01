@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Chỉnh Sửa Loại Chứng Từ</h1>
    <form action="{{ route('loaichungtu.update', $loaichungtu->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group mb-3">
            <label for="ma_loai_chung_tu">Mã Loại Chứng Từ</label>
            <input type="text" name="ma_loai_chung_tu" id="ma_loai_chung_tu" class="form-control" value="{{ $loaichungtu->ma_loai_chung_tu }}" required>
        </div>
        <div class="form-group mb-3">
            <label for="ten_loai_chung_tu">Tên Loại Chứng Từ</label>
            <input type="text" name="ten_loai_chung_tu" id="ten_loai_chung_tu" class="form-control" value="{{ $loaichungtu->ten_loai_chung_tu }}" required>
        </div>
        <div class="form-group mb-3">
            <label for="ghi_chu">Ghi Chú</label>
            <textarea name="ghi_chu" id="ghi_chu" class="form-control">{{ $loaichungtu->ghi_chu }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary">Cập Nhật</button>
        <a href="{{ route('loaichungtu.index') }}" class="btn btn-secondary">Hủy</a>
    </form>
</div>
@endsection