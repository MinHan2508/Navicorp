
@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Chi Tiết Hướng Chứng Từ</h1>
    <div class="form-group mb-3">
        <label for="ma_huong_chung_tu">Mã Hướng Chứng Từ</label>
        <input type="text" class="form-control" id="ma_huong_chung_tu" value="{{ $huongChungTu->ma_huong_chung_tu }}" readonly>
    </div>
    <div class="form-group mb-3">
        <label for="ten_huong_chung_tu">Tên Hướng Chứng Từ</label>
        <input type="text" class="form-control" id="ten_huong_chung_tu" value="{{ $huongChungTu->ten_huong_chung_tu }}" readonly>
    </div>
    <div class="form-group mb-3">
        <label for="ghi_chu">Ghi Chú</label>
        <textarea class="form-control" id="ghi_chu" readonly>{{ $huongChungTu->ghi_chu }}</textarea>
    </div>
    <a href="{{ route('huongchungtu.index') }}" class="btn btn-secondary">Quay Lại</a>
</div>
@endsection