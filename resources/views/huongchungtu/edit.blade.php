
@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Chỉnh Sửa Hướng Chứng Từ</h1>
    <form action="{{ route('huongchungtu.update', $huongChungTu->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group mb-3">
            <label for="ma_huong_chung_tu">Mã Hướng Chứng Từ</label>
            <input type="text" name="ma_huong_chung_tu" id="ma_huong_chung_tu" class="form-control" value="{{ $huongChungTu->ma_huong_chung_tu }}" required>
        </div>
        <div class="form-group mb-3">
            <label for="ten_huong_chung_tu">Tên Hướng Chứng Từ</label>
            <input type="text" name="ten_huong_chung_tu" id="ten_huong_chung_tu" class="form-control" value="{{ $huongChungTu->ten_huong_chung_tu }}" required>
        </div>
        <div class="form-group mb-3">
            <label for="ghi_chu">Ghi Chú</label>
            <textarea name="ghi_chu" id="ghi_chu" class="form-control">{{ $huongChungTu->ghi_chu }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary">Cập Nhật</button>
        <a href="{{ route('huongchungtu.index') }}" class="btn btn-secondary">Hủy</a>
    </form>
</div>
@endsection